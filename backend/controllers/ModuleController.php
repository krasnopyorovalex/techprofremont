<?php

namespace backend\controllers;

use common\models\Subdomains;
use Yii;
use backend\interfaces\ModelProviderInterface;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use backend\components\FileHelper as FH;

class ModuleController extends SiteController
{
    private $_model = null;

    public function init()
    {
        if ($this->module instanceof ModelProviderInterface) {
            $this->_model = $this->module->getModel();
        }
        if(!$this->_model){
            throw new \ErrorException('Не реализован метод getModels() у модуля');
        }
    }

    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $model = $this->_model;
        return $this->render('index',[
            'dataProvider' => $this->findData($model::find())
        ]);
    }

    public function actionAdd()
    {
        $model = new $this->_model;
        $this->loadData($model);
        return $this->render('form',[
            'model' => new $model
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->_model;
        if(!$model = $model::findOne(['id' => $id])){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $this->loadData($model);
        return $this->render('form', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $model = $this->_model;
        if(Yii::$app->request->isPost && $model::findOne($id)->delete()){
            return $this->redirect(Yii::$app->homeUrl . $this->module->id);
        }
        if(!$model = $model::findOne(['id' => $id])){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $this->render('form', ['model' => $model]);
    }

    /**
     * @param $id
     * @return bool
     */
    public function actionRemoveImage($id)
    {

        $model = $this->_model;
        $model = $model::findOne($id);
        if(FH::removeFile($model->image,$model::PATH)){
            $model->image = '';
            return $model->save();
        }
        return false;
    }

    public function beforeAction($action): bool
    {
        try {
            if (!parent::beforeAction($action)) {
                return false;
            }
            $session = Yii::$app->getSession();

            $subdomain = Subdomains::findOne(['id' => (int) $session->get('subdomain')]);
            if( !$subdomain) {
                $subdomain = Subdomains::findOne(['is_main' => Subdomains::IS_MAIN]);
                $session->set('subdomain', $subdomain->id);
            }
        } catch (BadRequestHttpException $e) {
            return false;
        }

        return true;
    }
}
