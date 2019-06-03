<?php

namespace common\models;

use frontend\models\Products as P;

/**
 * This is the model class for table "{{%makers}}".
 *
 * @property int $id
 * @property string $name
 * @property string $alias
 *
 * @property Products[] $products
 */
class Makers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%makers}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'alias'], 'required'],
            [['name'], 'string', 'max' => 128],
            [['alias'], 'string', 'max' => 255],
            [['alias'], 'unique'],
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
            'alias' => 'Alias',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(P::class, ['maker_id' => 'id']);
    }
}
