<?php

namespace common\models;

use backend\components\FileBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property int $id
 * @property int $catalog_id
 * @property string $name
 * @property string $text
 * @property string $alias
 * @property string $image
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Catalog $catalog
 * @property SubCategory[] $subCategories
 */
class Category extends MainModel
{

    const PATH = '/userfiles/category/';
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
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['catalog_id', 'name', 'alias'], 'required'],
            [['catalog_id', 'created_at', 'updated_at'], 'integer'],
            [['text'], 'string'],
            [['name'], 'string', 'max' => 512],
            [['alias'], 'string', 'max' => 255],
            [['image'], 'string', 'max' => 36],
            [['alias'], 'unique'],
            ['alias', 'unique', 'message' =>  'Такой alias уже есть в системе'],
            ['alias', 'match', 'pattern' => '/[a-zA-Z0-9-]+/', 'message' => 'Кириллица в поле alias запрещена'],
            [['catalog_id'], 'exist', 'skipOnError' => true, 'targetClass' => Catalog::className(), 'targetAttribute' => ['catalog_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'catalog_id' => 'Catalog ID',
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
    public function getCatalog()
    {
        return $this->hasOne(Catalog::className(), ['id' => 'catalog_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubCategories()
    {
        return $this->hasMany(SubCategory::className(), ['category_id' => 'id']);
    }

    /**
     * @return array
     */
    public function getIdsSubCategories()
    {
        return $this->hasMany(SubCategory::className(), ['category_id' => 'id'])->select(['id'])->column();
    }
}
