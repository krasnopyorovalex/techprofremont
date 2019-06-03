<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%products_auto_via}}".
 *
 * @property int $product_id
 * @property string $type
 * @property int $auto_id
 *
 * @property Products $product
 */
class ProductsAutoVia extends ActiveRecord
{
    const AUTO_MODEL = 'model';
    const AUTO_GENERATION = 'generation';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%products_auto_via}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'type', 'auto_id'], 'required'],
            [['product_id', 'auto_id'], 'integer'],
            [['type'], 'string', 'max' => 512],
            [['product_id', 'type', 'auto_id'], 'unique', 'targetAttribute' => ['product_id', 'type', 'auto_id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::class, 'targetAttribute' => ['product_id' => 'id']],
            ['type', 'in', 'range' => [self::AUTO_MODEL, self::AUTO_GENERATION]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'type' => 'Type',
            'auto_id' => 'Auto ID',
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
