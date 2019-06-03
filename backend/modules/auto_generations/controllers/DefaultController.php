<?php

namespace backend\modules\auto_generations\controllers;

use backend\controllers\SiteController;
use common\models\AutoGenerations;
use common\models\AutoModels;
use core\repositories\AutoGenerationsRepository;
use Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use backend\components\FileHelper as FH;

/**
 * Default controller for the `auto_generations` module
 */
class DefaultController extends SiteController
{
    private $repository;

    public function __construct($id, $module, AutoGenerationsRepository $repository, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->repository = $repository;
    }

    public function actionAdd($id)
    {
        $form = new AutoGenerations();
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
            'auto_model' => AutoModels::findOne($id)
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
            'auto_model' => $form['model']
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
            'auto_model' => $form['model']
        ]);
    }

    /**
     * @param $id
     * @return bool
     */
    public function actionRemoveImage($id)
    {
        $model = AutoGenerations::findOne($id);
        if(FH::removeFile($model->image,$model::PATH)){
            $model->image = '';
            return $model->save();
        }
        return false;
    }
}
