<?php

namespace common\models;

use backend\components\BrandBehavior;
use backend\components\FileBehavior;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%products}}".
 *
 * @property int $id
 * @property int $category_id
 * @property int $subdomain_id
 * @property string $name
 * @property string $text
 * @property string $alias
 * @property string $phone
 * @property string $working_hours
 * @property string $balance
 * @property string $address
 * @property string $image
 * @property string $advantages
 * @property int $created_at
 * @property int $updated_at
 *
 * @property ProductBrands[] $productBrands
 * @property Brands[] $brands
 * @property ProductCategories[] $productCategories
 * @property CatalogCategories[] $categories
 * @property CatalogCategories $category
 * @property Subdomains $subdomain
 *
 * @mixin BrandBehavior
 */
class Products extends MainModel
{
    public const IMAGE_ENTITY = 'image';
    public const PATH = '/userfiles/products/';
    protected const ADVANTAGES = [
        'Выезд мастера',
        'Вызов курьера',
        'Срочный ремонт'
    ];

    public $file;
    public $bindingCategoriesList = [];
    public $bindingBrandsList;
    public $makers;
    public $filesGallery;

    /**
     * @return array
     */
    public function behaviors(): array
    {
        return ArrayHelper::merge(parent::behaviors(),[
            [
                'class' => FileBehavior::class,
                'path' => self::PATH,
                'entity_db' => self::IMAGE_ENTITY
            ],
            [
                'class' => BrandBehavior::class
            ]
        ]);
    }


    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%products}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['category_id', 'name', 'alias', 'working_hours'], 'required'],
            [['category_id', 'created_at', 'updated_at'], 'integer'],
            [['text'], 'string'],
            [['name'], 'string', 'max' => 512],
            [['alias'], 'string', 'max' => 255],
            [['working_hours', 'address'], 'string', 'max' => 128],
            [['balance'], 'string', 'max' => 64],
            [['image'], 'string', 'max' => 36],
            [['phone'], 'string', 'max' => 255],
            [['alias'], 'unique'],
            [['bindingCategoriesList', 'bindingBrandsList', 'advantages'], 'safe'],
            [['working_hours', 'address', 'balance', 'alias', 'name'], 'trim'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatalogCategories::class, 'targetAttribute' => ['category_id' => 'id']],
            [['subdomain_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subdomains::class, 'targetAttribute' => ['subdomain_id' => 'id']]
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'subdomain_id' => 'Субдомен',
            'name' => 'Наименование продукта',
            'text' => 'Текст',
            'alias' => 'Alias',
            'phone' => 'Телефон',
            'image' => 'Image',
            'file' => 'Изображение',
            'advantages' => 'Преимущества',
            'working_hours' => 'Время работы',
            'balance' => 'E-mail',
            'address' => 'Адрес',
            'bindingCategoriesList' => 'Выберите дополнительные категории',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At'
        ];
    }

    /**
     * @param int $id
     * @return bool
     */
    public function isMainCategory(int $id): bool
    {
        return $this->category->parent->id === $id || $this->category->id === $id;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function isChecked(int $id): bool
    {
        $keys = ArrayHelper::getColumn($this->productCategories, 'category_id');

        return in_array($id, $keys, true);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function isCheckedBrand(int $id): bool
    {
        $keys = ArrayHelper::getColumn($this->bindingBrandsList, 'id');

        return in_array($id, $keys, true);
    }

    /**
     * @return ActiveQuery
     */
    public function getProductBrands(): ActiveQuery
    {
        return $this->hasMany(ProductBrands::className(), ['product_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getBrands(): ActiveQuery
    {
        return $this->hasMany(Brands::className(), ['id' => 'brand_id'])->viaTable('{{%product_brands}}', ['product_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getImages(): ActiveQuery
    {
        return $this->hasMany(ProductImages::className(), ['product_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getProductCategories(): ActiveQuery
    {
        return $this->hasMany(ProductCategories::className(), ['product_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getCategories(): ActiveQuery
    {
        return $this->hasMany(CatalogCategories::className(), ['id' => 'category_id'])->viaTable('{{%product_categories}}', ['product_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(CatalogCategories::class, ['id' => 'category_id']);
    }

    /**
     * @param CatalogCategories $catalogCategory
     */
    public function setCategory(CatalogCategories $catalogCategory): void
    {
        $this->category = $catalogCategory;
        $this->category_id = $catalogCategory->id;
    }

    /**
     * @param array $brands
     */
    public function setBindingBrandsList(array $brands): void
    {
        $this->bindingBrandsList = $brands;
    }

    /**
     * @return ActiveQuery
     */
    public function getSubdomain(): ActiveQuery
    {
        return $this->hasOne(Subdomains::class, ['id' => 'subdomain_id']);
    }

    /**
     * @return array
     */
    public function getAdvantages(): array
    {
        return self::ADVANTAGES;
    }

    /**
     * @param int $id
     * @return mixed|string
     */
    public function getByKeyAdvantage(int $id)
    {
        return self::ADVANTAGES[$id] ?? '---';
    }

    public function fillBrands(): void
    {
        $this->bindingBrandsList = $this->brands;
    }

    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {

            if ($this->isNewRecord) {
                $this->advantages = array_keys(self::ADVANTAGES);
            }

            $this->advantages = json_encode($this->advantages);

            return true;
        }
        return false;
    }

    public function afterFind(): void
    {
        parent::afterFind();

        $this->advantages = json_decode($this->advantages, false);
    }

    public function afterSave($insert, $changedAttributes): void
    {
        parent::afterSave($insert, $changedAttributes);

        $this->unlinkAll('categories', true);

        if ($this->bindingCategoriesList) {
            $keys = array_keys(array_filter($this->bindingCategoriesList));
            array_map(function ($item) {
                return (new ProductCategories([
                    'product_id' => $this->id,
                    'category_id' => (int)$item
                ]))->save();
            }, $keys);
        }
    }

    public function fillMakers(): void
    {
        foreach ($this->category->makers as $maker) {
            $this->makers[$maker->id] = $maker;
        }

        if ($this->category->parent) {
            foreach ($this->category->parent->makers as $maker) {
                $this->makers[$maker->id] = $maker;
            }
        }
    }
}
