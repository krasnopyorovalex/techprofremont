<?php

namespace common\models;

use backend\components\FileBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%brands}}".
 *
 * @property int $id
 * @property string $name
 * @property string $h1
 * @property string $text
 * @property string $alias
 * @property string $image
 * @property integer $is_popular
 */
class Brands extends ActiveRecord
{
    public const PATH = '/userfiles/brands/';
    public const IMAGE_ENTITY = 'image';
    public const IS_POPULAR = 1;

    public $file;
    public $template = 'auto_brand.twig';

    public function behaviors(): array
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
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%brands}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['name', 'alias'], 'required'],
            [['text'], 'string'],
            [['is_popular'], 'integer'],
            [['name', 'h1'], 'string', 'max' => 512],
            [['alias'], 'string', 'max' => 255],
            [['image'], 'string', 'max' => 36],
            [['alias'], 'unique'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Название бренда',
            'h1' => 'h1',
            'text' => 'Текст',
            'alias' => 'Alias',
            'image' => 'Изображение',
            'file' => 'Изображение',
            'is_popular' => 'Отображать на главной?'
        ];
    }
}
