<?php

namespace backend\modules\brands\controllers;

use backend\controllers\ModuleController;
use common\models\Brands;
use core\repositories\BrandsRepository;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use backend\components\FileHelper as FH;

/**
 * Default controller for the `Brands` module
 */
class DefaultController extends ModuleController
{
    private $repository;

    public function __construct($id, $module, BrandsRepository $repository, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->repository = $repository;
    }

    /**
     * @return array
     */
    public function behaviors(): array
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
        $form = new Brands();
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
     * @param $id
     * @return string|\yii\web\Response
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
            return $this->redirect(['index']);
        }
        return $this->render('form', ['model' => $this->repository->get($id)]);
    }

    /**
     * @param $id
     * @return bool
     */
    public function actionRemoveImage($id): bool
    {
        $model = Brands::findOne($id);
        if($model && FH::removeFile($model->image,$model::PATH)){
            $model->image = '';
            return $model->save();
        }
        return false;
    }
}
