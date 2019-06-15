<?php

namespace backend\modules\catalog_categories\controllers;

use backend\controllers\ModuleController;
use common\models\Catalog;
use common\models\CatalogCategories;
use common\models\Products;
use core\repositories\BrandsRepository;
use core\repositories\CatalogCategoriesRepository;
use DomainException;
use Yii;
use backend\components\FileHelper as FH;
use yii\db\ActiveQuery;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Response;

/**
 * Default controller for the `catalog` module
 */
class DefaultController extends ModuleController
{
    /**
     * @var CatalogCategoriesRepository
     */
    private $repository;

    /**
     * @var BrandsRepository
     */
    private $brandRepository;

    /**
     * DefaultController constructor.
     * @param $id
     * @param $module
     * @param CatalogCategoriesRepository $repository
     * @param BrandsRepository $brandsRepository
     * @param array $config
     */
    public function __construct($id, $module, CatalogCategoriesRepository $repository, BrandsRepository $brandsRepository, $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->repository = $repository;
        $this->brandRepository = $brandsRepository;
    }

    /**
     * @return array
     */
    public function behaviors(): array
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

    /**
     * @param $id
     * @return string
     */
    public function actionCatList($id): string
    {
        Url::remember();

        return $this->render('index',[
            'dataProvider' => CatalogCategories::find()->where(['parent_id' => null, 'catalog_id' => $id])->with(['products', 'catalogCategories' => static function(ActiveQuery $query){
                return $query->with(['products', 'catalogCategories' => static function(ActiveQuery $query){
                    return $query->with(['products', 'catalogCategories']);
                }]);
            }])->all(),
            'catalog' => Catalog::findOne($id)
        ]);
    }

    /**
     * @return string|Response
     */
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
            'catalog' => Catalog::findOne(['id' => (int) Yii::$app->request->get('catalog_id')]),
            'brands' => $this->brandRepository->all()
        ]);
    }

    /**
     * @param $id
     * @return string|Response
     */
    public function actionUpdate($id)
    {
        $form = CatalogCategories::findOne($id);

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
            'catalog' => $form->catalog,
            'brands' => $this->brandRepository->all()
        ]);
    }

    /**
     * @param $id
     * @return string|Response
     * @throws \Throwable
     * @throws StaleObjectException
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
        /**
         * @var $model CatalogCategories
         */
        $model =  $this->repository->get($id);
        return $this->render('form', [
            'model' => $model,
            'catalog' => $model->catalog,
            'brands' => $this->brandRepository->all()
        ]);
    }

    /**
     * @param int $id
     * @return string
     */
    public function actionList(int $id): string
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
    public function actionRemoveImage($id): bool
    {
        /**
         * @var $model Catalog
         */
        $model = $this->repository->get($id);

        if(FH::removeFile($model->image ,$model::PATH)){
            $model->image = '';
            return $model->save();
        }

        return false;
    }
}
