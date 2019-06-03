<?php

namespace common\models;

use backend\components\LinksBehavior;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%menu_items}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $link
 * @property integer $pos
 * @property integer $parent_id
 * @property integer $menu_id
 *
 * @property Menu $menu
 * @property MenuItems $parent
 * @property MenuItems[] $menuItems
 */
class MenuItems extends ActiveRecord
{
    const NOT_PARENT = null;

    public function behaviors()
    {
        return [
            [
                'class' => LinksBehavior::className()
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu_items}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['pos', 'parent_id', 'menu_id'], 'integer'],
            [['name', 'link'], 'string', 'max' => 512],
            [['menu_id'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['menu_id' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => MenuItems::className(), 'targetAttribute' => ['parent_id' => 'id']],
            ['link', 'default', 'value' => '/#'],
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
            'link' => 'Ссылка',
            'pos' => 'Позиция',
            'parent_id' => 'Родитель',
            'menu_id' => 'Menu ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::className(), ['id' => 'menu_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(MenuItems::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuItems()
    {
        return $this->hasMany(MenuItems::className(), ['parent_id' => 'id']);
    }

    public function getTree()
    {
        $query = self::find();
        if(!$this->isNewRecord){
            $query->where(['<>','id',$this->id]);
        }
        return ArrayHelper::map($query->asArray()->all(), 'id','name');
    }
}
