<?php

namespace backend\modules\subcategory\controllers;

use backend\controllers\SiteController;
use common\models\Category;
use common\models\Products;
use common\models\SubCategory;
use core\repositories\SubCategoryRepository;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use backend\components\FileHelper as FH;

/**
 * Default controller for the `sub_category` module
 */
class DefaultController extends SiteController
{
    private $repository;

    public function __construct($id, $module, SubCategoryRepository $repository, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->repository = $repository;
    }

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(),[
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['products'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ]);
    }

    public function actionAdd($id)
    {
        $form = new SubCategory();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->repository->save($form);
                return $this->redirect(Url::previous());
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        $category = Category::find()->where(['id' => $id])->with(['catalog'])->one();
        return $this->render('form', [
            'model' => $form,
            'catalog' => $category['catalog'],
            'category' => $category
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        if(!$form = $this->repository->get($id)){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $this->loadData($form, Url::previous());
        return $this->render('form', [
            'model' => $form,
            'catalog' => $form['category']['catalog'],
            'category' => $form['category']
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(Yii::$app->request->isPost){
            try {
                $this->repository->remove($id);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Url::previous());
        }
        $form = $this->repository->get($id);
        return $this->render('form', [
            'model' => $form,
            'catalog' => $form['category']['catalog'],
            'category' => $form['category']
        ]);
    }

    public function actionProducts($id)
    {
        Url::remember();
        $subcategory = $this->repository->get($id);
        return $this->render('products',[
            'dataProvider' => $this->findData(Products::find()->where(['subcategory_id' => $id])),
            'catalog' => $subcategory['category']['catalog'],
            'category' => $subcategory['category'],
            'subcategory' => $subcategory
        ]);
    }

    /**
     * @param $id
     * @return bool
     */
    public function actionRemoveImage($id)
    {
        /**
         * @var $model SubCategory
         */
        $model = $this->repository->get($id);
        if(FH::removeFile($model->image,$model::PATH)){
            $model->image = '';
            return $model->save();
        }
        return false;
    }
}
