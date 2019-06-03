<?php

namespace backend\modules\catalog_categories\controllers;

use backend\controllers\ModuleController;
use common\models\Catalog;
use common\models\CatalogCategories;
use common\models\Products;
use core\repositories\CatalogCategoriesRepository;
use Yii;
use backend\components\FileHelper as FH;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * Default controller for the `catalog` module
 */
class DefaultController extends ModuleController
{
    private $repository;

    public function __construct($id, $module, CatalogCategoriesRepository $repository, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->repository = $repository;
    }

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(),[
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['list', 'cat-list'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ]);
    }

    public function actionCatList($id)
    {
        Url::remember();
        return $this->render('index',[
            'dataProvider' => CatalogCategories::find()->where(['parent_id' => null, 'catalog_id' => $id])->with(['products', 'catalogCategories' => function($query){
                return $query->with(['products', 'catalogCategories' => function($query){
                    return $query->with(['products', 'catalogCategories']);
                }]);
            }])->asArray()->all(),
            'catalog' => Catalog::findOne($id)
        ]);
    }

    public function actionAdd()
    {
        $form = new CatalogCategories();
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
            'catalog' => Catalog::findOne(['id' => (int) Yii::$app->request->get('catalog_id')])
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionUpdate($id)
    {
        $form = CatalogCategories::findOne($id);
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
            'catalog' => $form->catalog
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
        /**
         * @var $model CatalogCategories
         */
        $model =  $this->repository->get($id);
        return $this->render('form', [
            'model' => $model,
            'catalog' => $model->catalog
        ]);
    }

    /**
     * @param int $id
     * @return string
     */
    public function actionList(int $id)
    {
        Url::remember();
        $products = Products::find()->where(['category_id' => $id])->with(['category']);

        return $this->render('products_list', [
            'dataProvider' => $this->findData($products),
            'catalogCategory' => CatalogCategories::find()->where(['id' => $id])->one()
        ]);
    }

    /**
     * @param $id
     * @return bool
     */
    public function actionRemoveImage($id)
    {
        /**
         * @var $model Catalog
         */
        $model = $this->repository->get($id);
        if(FH::removeFile($model->image,$model::PATH)){
            $model->image = '';
            return $model->save();
        }
        return false;
    }
}