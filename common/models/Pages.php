<?php

namespace common\models;

/**
 * This is the model class for table "{{%pages}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property string $description
 * @property string $text
 * @property string $alias
 * @property integer $created_at
 * @property integer $updated_at
 */
class Pages extends MainModel
{

    public $template = 'page.twig';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%pages}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'title', 'alias'], 'required'],
            [['name', 'description', 'title', 'alias'], 'trim'],
            [['text'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['name', 'title', 'description'], 'string', 'max' => 512],
            [['alias'], 'string', 'max' => 255],
            [['alias'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'title' => 'Title',
            'description' => 'Description',
            'text' => 'Контент',
            'alias' => 'Alias',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At'
        ];
    }
}
