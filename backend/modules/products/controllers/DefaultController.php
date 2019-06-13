<?php

namespace backend\modules\products\controllers;

use backend\controllers\SiteController;
use common\models\CatalogCategories;
use common\models\Makers;
use common\models\Products;
use common\models\Subdomains;
use core\repositories\ProductsRepository;
use DomainException;
use Yii;
use yii\db\StaleObjectException;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use backend\components\FileHelper as FH;
use yii\web\Response;

/**
 * Default controller for the `products` module
 */
class DefaultController extends SiteController
{

    private $repository;

    /**
     * DefaultController constructor.
     * @param $id
     * @param $module
     * @param ProductsRepository $repository
     * @param array $config
     */
    public function __construct($id, $module, ProductsRepository $repository, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->repository = $repository;
    }

    /**
     * @param $id
     * @return string|Response
     */
    public function actionAdd($id)
    {
        $form = new Products();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->repository->save($form);
                return $this->redirect(Url::previous());
            } catch (DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('form', [
            'model' => $form,
            'catalogCategory' => CatalogCategories::findOne($id),
            'subdomains' => ArrayHelper::map(Subdomains::find()->asArray()->all(),'id','domain_name'),
            'makers' => ArrayHelper::map(Makers::find()->asArray()->all(),'id','name')
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id): string
    {
        if(!$form = $this->repository->get($id)){
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $this->loadData($form, Url::previous());

        return $this->render('form', [
            'model' => $form,
            'catalogCategory' => CatalogCategories::findOne(['id' => $form['category_id']]),
            'subdomains' => ArrayHelper::map(Subdomains::find()->asArray()->all(),'id','domain_name'),
            'makers' => ArrayHelper::map(Makers::find()->asArray()->all(),'id','name')
        ]);
    }

    /**
     * @param $id
     * @return string|Response
     * @throws StaleObjectException
     * @throws \Throwable
     */
    public function actionDelete($id)
    {
        if(Yii::$app->request->isPost){
            try {
                $this->repository->remove($id);
            } catch (DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Url::previous());
        }

        $form = $this->repository->get($id);

        return $this->render('form', [
            'model' => $form,
            'catalogCategory' => CatalogCategories::findOne(['id' => $form['category_id']]),
            'subdomains' => ArrayHelper::map(Subdomains::find()->asArray()->all(),'id','domain_name'),
            'makers' => ArrayHelper::map(Makers::find()->asArray()->all(),'id','name')
        ]);
    }

    /**
     * @param $id
     * @return bool
     */
    public function actionRemoveImage($id): bool
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
