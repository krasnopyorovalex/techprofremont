<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%products_options}}".
 *
 * @property int $id
 * @property string $name
 *
 * @property ProductsOptionsVia[] $productsOptionsVias
 * @property Products[] $products
 */
class ProductsOptions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%products_options}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'trim'],
            [['name'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductsOptionsVias()
    {
        return $this->hasMany(ProductsOptionsVia::className(), ['option_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Products::className(), ['id' => 'product_id'])->viaTable('{{%products_options_via}}', ['option_id' => 'id']);
    }
}
