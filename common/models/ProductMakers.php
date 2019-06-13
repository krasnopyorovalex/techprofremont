<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%product_makers}}".
 *
 * @property int $product_id
 * @property int $maker_id
 *
 * @property Makers $maker
 * @property Products $product
 */
class ProductMakers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%product_makers}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'maker_id'], 'required'],
            [['product_id', 'maker_id'], 'integer'],
            [['product_id', 'maker_id'], 'unique', 'targetAttribute' => ['product_id', 'maker_id']],
            [['maker_id'], 'exist', 'skipOnError' => true, 'targetClass' => Makers::className(), 'targetAttribute' => ['maker_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'maker_id' => 'Maker ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaker()
    {
        return $this->hasOne(Makers::className(), ['id' => 'maker_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::className(), ['id' => 'product_id']);
    }
}
