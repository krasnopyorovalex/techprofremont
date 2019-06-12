<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

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
class Helpfull extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%helpfull}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['parent_id', 'is_complete'], 'integer'],
            [['name', 'alias'], 'required'],
            [['name'], 'string', 'max' => 512],
            [['alias'], 'string', 'max' => 255],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => self::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
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
     * @return ActiveQuery
     */
    public function getParent(): ActiveQuery
    {
        return $this->hasOne(self::className(), ['id' => 'parent_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getHelpfulls(): ActiveQuery
    {
        return $this->hasMany(self::className(), ['parent_id' => 'id']);
    }
}
