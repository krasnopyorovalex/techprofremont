<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%products_options_via}}".
 *
 * @property int $product_id
 * @property int $option_id
 * @property string $value
 *
 * @property ProductsOptions $option
 * @property Products $product
 */
class ProductsOptionsVia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%products_options_via}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'option_id', 'value'], 'required'],
            [['product_id', 'option_id'], 'integer'],
            [['value'], 'string', 'max' => 512],
            [['value'], 'trim'],
            [['product_id', 'option_id'], 'unique', 'targetAttribute' => ['product_id', 'option_id']],
            [['option_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductsOptions::className(), 'targetAttribute' => ['option_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'option_id' => 'Option ID',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOption()
    {
        return $this->hasOne(ProductsOptions::className(), ['id' => 'option_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::className(), ['id' => 'product_id']);
    }
}
