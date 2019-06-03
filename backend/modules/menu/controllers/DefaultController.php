<?php

namespace backend\modules\menu\controllers;

use backend\controllers\ModuleController;
use common\models\Menu;
use common\models\MenuItems;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

/**
 * Default controller for the `menu` module
 */
class DefaultController extends ModuleController
{

    public $actions = [
        'menu-items-add' => 'Добавление пункта',
        'menu-items-edit' => 'Обновление пункта',
        'menu-items-delete' => 'Удаление пункта',
        'add' => 'Добавление меню',
        'update' => 'Обновление меню',
        'delete' => 'Удаление меню',
    ];

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(),[
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['menu-items', 'menu-items-add', 'menu-items-edit', 'menu-items-sorting', 'menu-items-delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ]);
    }

    public function actionMenuItems($id)
    {
        return $this->render('menu_list', [
            'model' => MenuItems::find()->where(['menu_id' => $id, 'parent_id' => MenuItems::NOT_PARENT])->orderBy('pos')->all(),
            'menu' => Menu::findOne($id)
        ]);
    }

    public function actionMenuItemsAdd($id)
    {
        $model = new MenuItems();
        if($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            return $this->redirect(['/menu/default/menu-items', 'id' => $model['menu_id']]);
        }
        return $this->render('menu_form',[
            'model' => $model,
            'menu' => Menu::findOne($id)
        ]);
    }

    public function actionMenuItemsEdit($id)
    {
        $model = MenuItems::find()->where(['id' => $id])->with(['menu'])->one();
        if($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            return $this->redirect(['/menu/default/menu-items', 'id' => $model['menu_id']]);
        }
        return $this->render('menu_form',[
            'model' => $model,
            'menu' => $model['menu']
        ]);
    }

    public function actionMenuItemsDelete($id)
    {
        $model = MenuItems::find()->where(['id' => $id])->with(['menu'])->one();
        if(Yii::$app->request->isPost && $model->delete()){
            return $this->redirect(['/menu/default/menu-items', 'id' => $model['menu_id']]);
        }
        return $this->render('menu_form', [
            'model' => $model,
            'menu' => $model['menu']
        ]);
    }

    public function actionMenuItemsSorting($id)
    {
        if(!$id){
            return false;
        }
        foreach (Yii::$app->request->post() as $key => $value){
            $model = MenuItems::find()->where(['id' => $key, 'menu_id' => $id])->one();
            $model['pos'] = $value['pos'];
            $model['parent_id'] = $value['parent_id'];
            $model->save();
        }
        return true;
    }

}
