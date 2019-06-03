<?php

namespace backend\modules\auto_models\controllers;

use backend\controllers\SiteController;
use common\models\AutoBrands;
use common\models\AutoGenerations;
use common\models\AutoModels;
use core\repositories\AutoModelsRepository;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use backend\components\FileHelper as FH;

/**
 * Default controller for the `auto_models` module
 */
class DefaultController extends SiteController
{
    private $repository;

    public function __construct($id, $module, AutoModelsRepository $repository, $config = [])
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
                        'actions' => ['generations'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ]);
    }

    public function actionAdd($id)
    {
        $form = new AutoModels();
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
            'brand' => AutoBrands::findOne($id)
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
            'brand' => $form['brand']
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
            'brand' => $form['brand']
        ]);
    }

    public function actionGenerations($id)
    {
        Url::remember();
        $model = $this->repository->get($id);

        return $this->render('generations',[
            'dataProvider' => $this->findData(AutoGenerations::find()->where(['model_id' => $id])),
            'brand' => $model['brand'],
            'model' => $model
        ]);
    }

    /**
     * @param $id
     * @return bool
     */
    public function actionRemoveImage($id)
    {
        $model = AutoModels::findOne($id);
        if(FH::removeFile($model->image,$model::PATH)){
            $model->image = '';
            return $model->save();
        }
        return false;
    }
}
