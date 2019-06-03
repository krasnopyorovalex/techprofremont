<?php

namespace backend\modules\auto_brands\controllers;

use backend\controllers\ModuleController;
use common\models\AutoBrands;
use common\models\AutoModels;
use core\repositories\AutoBrandsRepository;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use backend\components\FileHelper as FH;

/**
 * Default controller for the `auto_brands` module
 */
class DefaultController extends ModuleController
{
    private $repository;

    public function __construct($id, $module, AutoBrandsRepository $repository, $config = [])
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
                        'actions' => ['models'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ]);
    }

    public function actionAdd()
    {
        $form = new AutoBrands();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->repository->save($form);
                return $this->redirect(['index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('form', [
            'model' => $form,
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
            return $this->redirect(['index']);
        }
        return $this->render('form', ['model' => $this->repository->get($id)]);
    }

    public function actionModels($id)
    {
        Url::remember();
        return $this->render('models',[
            'dataProvider' => $this->findData(AutoModels::find()->where(['brand_id' => $id])),
            'brand' => $this->repository->get($id)
        ]);
    }

    /**
     * @param $id
     * @return bool
     */
    public function actionRemoveImage($id)
    {
        $model = AutoBrands::findOne($id);
        if(FH::removeFile($model->image,$model::PATH)){
            $model->image = '';
            return $model->save();
        }
        return false;
    }
}
