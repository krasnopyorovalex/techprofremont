<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%product_images}}".
 *
 * @property int $id
 * @property int $product_id
 * @property string $basename
 * @property string $ext
 * @property int $pos
 */
class ProductImages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%product_images}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'basename', 'ext'], 'required'],
            [['product_id', 'pos'], 'integer'],
            [['basename'], 'string', 'max' => 32],
            [['ext'], 'string', 'max' => 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'basename' => 'Basename',
            'ext' => 'Ext',
            'pos' => 'Pos',
        ];
    }
}
