<?php

namespace backend\modules\products\controllers;

use backend\components\UploadInterface;
use backend\controllers\SiteController;
use common\models\Brands;
use common\models\CatalogCategories;
use common\models\ProductImages;
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
     * @var UploadInterface
     */
    private $uploader;

    /**
     * DefaultController constructor.
     * @param $id
     * @param $module
     * @param ProductsRepository $repository
     * @param UploadInterface $uploader
     * @param array $config
     */
    public function __construct($id, $module, ProductsRepository $repository, UploadInterface $uploader, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->repository = $repository;
        $this->uploader = $uploader;
    }

    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $model = new Products();

        return $this->render('index',[
            'dataProvider' => $this->findData($model::find())
        ]);
    }

    /**
     * @param $id
     * @return string|Response
     */
    public function actionAdd($id)
    {
        $form = new Products();
        $form->setCategory(CatalogCategories::findOne($id));
        $form->setBindingBrandsList($form->category->getCheckedBrands());

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
            'catalogCategory' => $form->category,
            'subdomains' => ArrayHelper::map(Subdomains::find()->asArray()->all(),'id','domain_name'),
            'brands' => Brands::find()->all()
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
            'brands' => Brands::find()->all()
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
            'brands' => Brands::find()->all()
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
        if (FH::removeFile($model->image,$model::PATH)) {
            $model->image = '';
            return $model->save();
        }

        return false;
    }

    /**
     * @param $id
     * @return bool
     */
    public function actionUpload($id)
    {
        if($image = $this->uploader->upload($id))
        {
            $newImage = new ProductImages();
            $newImage->basename = $image['name'];
            $newImage->ext = $image['ext'];
            $newImage->product_id = $id;
            return $newImage->save();
        }
        return false;
    }

    public function actionDeleteImage($id)
    {
        return ProductImages::findOne($id)->delete();
    }

    public function actionLoaded($id)
    {
        return $this->renderAjax('_images_box', [
            'model' => Products::find()->where(['id' => $id])->with(['images'])->limit(1)->one()
        ]);
    }
}
