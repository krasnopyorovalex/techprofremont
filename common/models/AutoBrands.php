<?php

namespace common\models;

use backend\components\FileBehavior;

/**
 * This is the model class for table "{{%auto_brands}}".
 *
 * @property int $id
 * @property string $name
 * @property string $h1
 * @property string $text
 * @property string $alias
 * @property string $image
 *
 * @property AutoModels[] $autoModels
 */
class AutoBrands extends \yii\db\ActiveRecord
{
    const PATH = '/userfiles/auto_brands/';
    const IMAGE_ENTITY = 'image';

    public $file;
    public $template = 'auto_brand.twig';

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
        return '{{%auto_brands}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'alias'], 'required'],
            [['text'], 'string'],
            [['name', 'h1'], 'string', 'max' => 512],
            [['alias'], 'string', 'max' => 255],
            [['image'], 'string', 'max' => 36],
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
            'name' => 'Название бренда',
            'h1' => 'h1',
            'text' => 'Текст',
            'alias' => 'Alias',
            'image' => 'Изображение',
            'file' => 'Изображение'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAutoModels()
    {
        return $this->hasMany(AutoModels::class, ['brand_id' => 'id']);
    }
}
