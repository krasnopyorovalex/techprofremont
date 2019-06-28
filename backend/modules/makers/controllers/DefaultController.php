<?php

namespace backend\modules\makers\controllers;

use backend\controllers\ModuleController;
use common\models\CatalogCategories;
use common\models\Makers;
use DomainException;
use Yii;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Default controller for the `makers` module
 */
class DefaultController extends ModuleController
{
    /**
     * @return string|Response
     */
    public function actionAdd()
    {
        $form = new Makers();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $form->save();
                return $this->redirect(Yii::$app->homeUrl . $this->module->id);
            } catch (DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('form', [
            'model' => $form,
            'catalogCategory' => new CatalogCategories()
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id): string
    {
        $form = Makers::findOne($id);

        if ( !$form) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $this->loadData($form, Yii::$app->homeUrl . $this->module->id);

        return $this->render('form', [
            'model' => $form,
            'catalogCategory' => new CatalogCategories()
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
        $form = Makers::findOne($id);

        if(Yii::$app->request->isPost && $form){

            try {
                $form->delete();
            } catch (DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Yii::$app->homeUrl . $this->module->id);
        }

        return $this->render('form', [
            'model' => $form,
            'catalogCategory' => new CatalogCategories()
        ]);
    }
}
