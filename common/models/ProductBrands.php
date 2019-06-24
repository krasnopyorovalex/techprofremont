<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%product_brands}}".
 *
 * @property int $product_id
 * @property int $brand_id
 *
 * @property Brands $brand
 * @property Products $product
 */
class ProductBrands extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%product_brands}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['product_id', 'brand_id'], 'required'],
            [['product_id', 'brand_id'], 'integer'],
            [['product_id', 'brand_id'], 'unique', 'targetAttribute' => ['product_id', 'brand_id']],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => Brands::className(), 'targetAttribute' => ['brand_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'product_id' => 'Product ID',
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
    public function getProduct(): ActiveQuery
    {
        return $this->hasOne(Products::className(), ['id' => 'product_id']);
    }
}
