<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%helpfull}}".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $name
 * @property string $alias
 * @property int $is_complete
 *
 * @property Helpfull $parent
 * @property Helpfull[] $helpfulls
 */
class Helpfull extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%helpfull}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'is_complete'], 'integer'],
            [['name', 'alias'], 'required'],
            [['name'], 'string', 'max' => 512],
            [['alias'], 'string', 'max' => 255],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Helpfull::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'name' => 'Name',
            'alias' => 'Alias',
            'is_complete' => 'Is Complete',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Helpfull::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHelpfulls()
    {
        return $this->hasMany(Helpfull::className(), ['parent_id' => 'id']);
    }
}
