<?php

namespace common\models;

use backend\components\FileBehavior;
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
 * @property Products[] $products
 */
class CatalogCategories extends MainModel
{
    const PATH = '/userfiles/categories/';
    const IMAGE_ENTITY = 'image';

    public $file;
    private $tree = [];

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(),[
            [
                'class' => FileBehavior::class,
                'path' => self::PATH,
                'entity_db' => self::IMAGE_ENTITY
            ]
        ]);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%catalog_categories}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
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
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatalogCategories::class, 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
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
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalog()
    {
        return $this->hasOne(Catalog::class, ['id' => 'catalog_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(CatalogCategories::class, ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogCategories()
    {
        return $this->hasMany(CatalogCategories::class, ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Products::class, ['category_id' => 'id']);
    }

    /**
     * @param array $items
     * @param string $step
     * @return array
     */
    public function getTree($items = [], $step = '*'): array
    {
        if( ! $items ){
            $catalogs = self::find()->where(['parent_id' => null])->with(['catalogCategories']);
            if( ! $this->isNewRecord ) {
                $catalogs->andWhere(['<>','id',$this->id]);
            }
            $items = $catalogs->all();
        }

        foreach ($items as $catalog) {
            array_push($this->tree, [
                'id' => $catalog['id'],
                'name' => $step . $catalog['name']
            ]);
            if(isset($catalog->catalogCategories) && $catalog->catalogCategories){
                $this->getTree($catalog->catalogCategories, $step.'*');
            }
        }
        return ArrayHelper::map($this->tree,'id','name');
    }
}
