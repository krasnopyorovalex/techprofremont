<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%products_original_numbers}}".
 *
 * @property int $product_id
 * @property string $number
 *
 * @property Products $product
 */
class ProductsOriginalNumbers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%products_original_numbers}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'number'], 'required'],
            [['product_id'], 'integer'],
            [['number'], 'string', 'max' => 128],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::class, 'targetAttribute' => ['product_id' => 'id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'number' => 'Number',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::class, ['id' => 'product_id']);
    }
}
