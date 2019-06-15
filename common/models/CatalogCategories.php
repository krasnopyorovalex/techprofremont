<?php

namespace common\models;

use backend\components\FileBehavior;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%catalog_categories}}".
 *
 * @property int $id
 * @property int $catalog_id
 * @property int $parent_id
 * @property string $name
 * @property string $h1
 * @property string $text
 * @property string $alias
 * @property string $image
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Catalog $catalog
 * @property CatalogCategories $parent
 * @property CatalogCategories[] $catalogCategories
 * @property CatalogCategoryBrands[] $catalogCategoryBrands
 * @property Brands[] $brands
 * @property ProductCategories[] $productCategories
 * @property Products[] $products
 * @property ActiveQuery $productsVia
 */
class CatalogCategories extends MainModel
{
    public const PATH = '/userfiles/categories/';
    public const IMAGE_ENTITY = 'image';

    public $file;
    public $bindingBrandsList;

    private $tree = [];

    public function behaviors(): array
    {
        return ArrayHelper::merge(parent::behaviors(), [
            [
                'class' => FileBehavior::class,
                'path' => self::PATH,
                'entity_db' => self::IMAGE_ENTITY
            ]
        ]);
    }

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%catalog_categories}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['catalog_id', 'name', 'alias'], 'required'],
            [['catalog_id', 'parent_id', 'created_at', 'updated_at'], 'integer'],
            [['text'], 'string'],
            [['name', 'h1'], 'string', 'max' => 512],
            [['alias'], 'string', 'max' => 255],
            [['alias'], 'unique'],
            [['image'], 'string', 'max' => 36],
            [['catalog_id'], 'exist', 'skipOnError' => true, 'targetClass' => Catalog::class, 'targetAttribute' => ['catalog_id' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => __CLASS__, 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'catalog_id' => 'Catalog ID',
            'parent_id' => 'Родительская категория',
            'name' => 'Название категории',
            'h1' => 'h1',
            'text' => 'Текст',
            'alias' => 'Alias',
            'file' => 'Изображение',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At'
        ];
    }


    /**
     * @return ActiveQuery
     */
    public function getCatalog(): ActiveQuery
    {
        return $this->hasOne(Catalog::className(), ['id' => 'catalog_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getParent(): ActiveQuery
    {
        return $this->hasOne(self::className(), ['id' => 'parent_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCatalogCategories(): ActiveQuery
    {
        return $this->hasMany(self::className(), ['parent_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCatalogCategoryBrands(): ActiveQuery
    {
        return $this->hasMany(CatalogCategoryBrands::className(), ['category_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getBrands(): ActiveQuery
    {
        return $this->hasMany(Brands::className(), ['id' => 'brand_id'])->viaTable('{{%catalog_category_brands}}', ['category_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getProductCategories(): ActiveQuery
    {
        return $this->hasMany(ProductCategories::className(), ['category_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getProductsVia(): ActiveQuery
    {
        return $this->hasMany(Products::className(), ['id' => 'product_id'])->viaTable('{{%product_categories}}', ['category_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getProducts(): ActiveQuery
    {
        return $this->hasMany(Products::className(), ['category_id' => 'id']);
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes): void
    {
        parent::afterSave($insert, $changedAttributes);

        $this->unlinkAll('brands', true);

        if ($this->bindingBrandsList) {
            $keys = array_keys(array_filter($this->bindingBrandsList));
            array_map(function ($item) {
                return (new CatalogCategoryBrands([
                    'category_id' => $this->id,
                    'brand_id' => (int)$item
                ]))->save();
            }, $keys);
        }
    }

    /**
     * @param array $items
     * @param string $step
     * @param string $cssClass
     * @return array
     */
    public function getTree($items = [], $step = '*', $cssClass = 'tab'): array
    {
        if( ! $items ){
            $catalogs = self::find()->where(['parent_id' => null])->with(['parent', 'catalogCategories' => static function(ActiveQuery $query) {
                return $query->with(['catalogCategories','parent']);
            }]);
            if( ! $this->isNewRecord ) {
                $catalogs->andWhere(['<>','id',$this->id]);
            }
            $items = $catalogs->all();
        }

        foreach ($items as $catalog) {
            $this->tree[] = [
                'id' => $catalog['id'],
                'name' => $step . $catalog['name'],
                'class' => $cssClass,
                'parent' => isset($catalog->parent) ? 'category_' . $catalog->parent->id : ''
            ];
            if(isset($catalog->catalogCategories) && $catalog->catalogCategories){
                $this->getTree($catalog->catalogCategories, $step.'*', $cssClass.'_t');
            }
        }
        return $this->tree;
    }
}
