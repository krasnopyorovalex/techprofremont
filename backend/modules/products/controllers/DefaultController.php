<?php

namespace backend\modules\products\controllers;

use backend\controllers\SiteController;
use common\models\Catalog;
use common\models\CatalogCategories;
use common\models\Makers;
use common\models\Products;
use core\repositories\ProductsRepository;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use backend\components\FileHelper as FH;

/**
 * Default controller for the `products` module
 */
class DefaultController extends SiteController
{

    private $repository;

    public function __construct($id, $module, ProductsRepository $repository, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->repository = $repository;
    }

    public function actionAdd($id)
    {
        $form = new Products();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->repository->save($form);
                return $this->redirect(Url::previous());
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('form', [
            'model' => $form,
            'catalogCategory' => CatalogCategories::findOne($id),
            'makers' => ArrayHelper::map(Makers::find()->asArray()->all(),'id','name')
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
            'catalogCategory' => CatalogCategories::findOne(['id' => $form['category_id']]),
            'makers' => ArrayHelper::map(Makers::find()->asArray()->all(),'id','name')
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
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
            'catalogCategory' => CatalogCategories::findOne(['id' => $form['category_id']]),
            'makers' => ArrayHelper::map(Makers::find()->asArray()->all(),'id','name')
        ]);
    }

    /**
     * @param $id
     * @return bool
     */
    public function actionRemoveImage($id)
    {
        /**
         * @var $model Products
         */
        $model = $this->repository->get($id);
        if(FH::removeFile($model->image,$model::PATH)){
            $model->image = '';
            return $model->save();
        }
        return false;
    }

}
