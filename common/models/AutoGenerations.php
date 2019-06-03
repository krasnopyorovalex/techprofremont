<?php

namespace common\models;

use backend\components\FileBehavior;

/**
 * This is the model class for table "{{%auto_generations}}".
 *
 * @property int $id
 * @property int $model_id
 * @property string $name
 * @property string $h1
 * @property string $alias
 * @property string $image
 *
 * @property AutoModels $model
 */
class AutoGenerations extends \yii\db\ActiveRecord
{
    const PATH = '/userfiles/auto_generations/';
    const IMAGE_ENTITY = 'image';

    public $file;
    private $type = 'generation';

    public function behaviors()
    {
        return [
            [
                'class' => FileBehavior::class,
                'path' => self::PATH,
                'entity_db' => self::IMAGE_ENTITY
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auto_generations}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model_id', 'name', 'alias'], 'required'],
            [['model_id'], 'integer'],
            [['name', 'h1'], 'string', 'max' => 512],
            [['alias'], 'string', 'max' => 255],
            [['alias'], 'unique'],
            [['image'], 'string', 'max' => 36],
            [['model_id'], 'exist', 'skipOnError' => true, 'targetClass' => AutoModels::className(), 'targetAttribute' => ['model_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'model_id' => 'Model ID',
            'h1' => 'h1',
            'name' => 'Название модификации',
            'alias' => 'Alias',
            'file' => 'Изображение',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModel()
    {
        return $this->hasOne(AutoModels::className(), ['id' => 'model_id']);
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
