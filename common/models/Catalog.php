<?php

namespace common\models;

use backend\components\FileBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%catalog}}".
 *
 * @property int $id
 * @property string $name
 * @property string $text
 * @property string $alias
 * @property string $image
 * @property integer $is_main
 * @property int $created_at
 * @property int $updated_at
 *
 * @property CatalogCategories[] $catalogCategories
 */
class Catalog extends MainModel
{

    const PATH = '/userfiles/catalog/';
    const IMAGE_ENTITY = 'image';

    public $template = 'catalog.twig';
    public $file;

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(),[
            [
                'class' => FileBehavior::class,
                'path' => self::PATH,
                'entity_db' => self::IMAGE_ENTITY
            ]
        ]);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%catalog}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'alias'], 'required'],
            [['text'], 'string'],
            [['created_at', 'updated_at', 'is_main'], 'integer'],
            [['name'], 'string', 'max' => 512],
            [['image'], 'string', 'max' => 36],
            [['alias'], 'string', 'max' => 255],
            ['alias', 'unique', 'message' =>  'Такой alias уже есть в системе'],
            ['alias', 'match', 'pattern' => '/[a-zA-Z0-9-]+/', 'message' => 'Кириллица в поле alias запрещена']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название каталога',
            'text' => 'Текст',
            'alias' => 'Alias',
            'image' => 'Изображение',
            'file' => 'Изображение',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogCategories()
    {
        return $this->hasMany(CatalogCategories::class, ['catalog_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogCategoriesRoot()
    {
        return $this->hasMany(CatalogCategories::class, ['catalog_id' => 'id', 'parent_id' => null]);
    }
}
