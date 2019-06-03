<?php

namespace common\models;

use backend\components\FileBehavior;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%sub_category}}".
 *
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string $text
 * @property string $alias
 * @property string $image
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Products[] $products
 * @property Category $category
 */
class SubCategory extends MainModel
{

    const PATH = '/userfiles/subcategory/';
    const IMAGE_ENTITY = 'image';

    public $file;

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(),[
            [
                'class' => FileBehavior::className(),
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
        return '{{%sub_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'name', 'alias'], 'required'],
            [['category_id', 'created_at', 'updated_at'], 'integer'],
            [['text'], 'string'],
            [['name'], 'string', 'max' => 512],
            [['alias'], 'string', 'max' => 255],
            [['image'], 'string', 'max' => 36],
            [['alias'], 'unique'],
            ['alias', 'unique', 'message' =>  'Такой alias уже есть в системе'],
            ['alias', 'match', 'pattern' => '/[a-zA-Z0-9-]+/', 'message' => 'Кириллица в поле alias запрещена'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'name' => 'Name',
            'text' => 'Text',
            'alias' => 'Alias',
            'image' => 'Image',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Products::className(), ['subcategory_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }
}
