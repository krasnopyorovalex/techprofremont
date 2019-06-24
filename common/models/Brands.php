<?php

namespace common\models;

use backend\components\FileBehavior;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%brands}}".
 *
 * @property int $id
 * @property string $name
 * @property string $h1
 * @property string $text
 * @property string $alias
 * @property string $image
 * @property int $is_popular
 *
 * @property CatalogCategoryBrands[] $catalogCategoryBrands
 * @property CatalogCategories[] $categories
 * @property ProductBrands[] $productBrands
 * @property Products[] $products
 */
class Brands extends ActiveRecord
{
    public const PATH = '/userfiles/brands/';
    public const IMAGE_ENTITY = 'image';
    public const IS_POPULAR = 1;

    public $file;
    public $template = 'brand.twig';

    public function behaviors(): array
    {
        return [
            [
                'class' => FileBehavior::class,
                'path' => self::PATH,
                'entity_db' => self::IMAGE_ENTITY
            ]
        ];
    }

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%brands}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['name', 'alias'], 'required'],
            [['text'], 'string'],
            [['is_popular'], 'integer'],
            [['name', 'h1'], 'string', 'max' => 512],
            [['alias'], 'string', 'max' => 255],
            [['image'], 'string', 'max' => 36],
            [['alias'], 'unique'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Название бренда',
            'h1' => 'h1',
            'text' => 'Текст',
            'alias' => 'Alias',
            'image' => 'Изображение',
            'file' => 'Изображение',
            'is_popular' => 'Отображать на главной?'
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getCatalogCategoryBrands(): ActiveQuery
    {
        return $this->hasMany(CatalogCategoryBrands::className(), ['brand_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getCategories(): ActiveQuery
    {
        return $this->hasMany(CatalogCategories::className(), ['id' => 'category_id'])->viaTable('{{%catalog_category_brands}}', ['brand_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getProductBrands(): ActiveQuery
    {
        return $this->hasMany(ProductBrands::className(), ['brand_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function getProducts(): ActiveQuery
    {
        return $this->hasMany(Products::className(), ['id' => 'product_id'])->viaTable('{{%product_brands}}', ['brand_id' => 'id']);
    }
}
