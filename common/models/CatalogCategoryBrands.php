<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%catalog_category_brands}}".
 *
 * @property int $category_id
 * @property int $brand_id
 *
 * @property Brands $brand
 * @property CatalogCategories $category
 */
class CatalogCategoryBrands extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%catalog_category_brands}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['category_id', 'brand_id'], 'required'],
            [['category_id', 'brand_id'], 'integer'],
            [['category_id', 'brand_id'], 'unique', 'targetAttribute' => ['category_id', 'brand_id']],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => Brands::className(), 'targetAttribute' => ['brand_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatalogCategories::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'category_id' => 'Category ID',
            'brand_id' => 'Brand ID',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getBrand(): ActiveQuery
    {
        return $this->hasOne(Brands::className(), ['id' => 'brand_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(CatalogCategories::className(), ['id' => 'category_id']);
    }
}
