<?php

namespace frontend\controllers;

use common\models\Catalog;
use frontend\components\PagesAndCatalogBehavior;
use common\models\AutoBrands;
use common\models\Pages;
use common\models\Subdomains;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 *
 * @mixin PagesAndCatalogBehavior
 */
class SiteController extends Controller
{
    public $layout = 'main.twig';

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'class' => PagesAndCatalogBehavior::class
        ];
    }

    /**
     * @param string $alias
     * @return string
     */
    public function actionIndex($alias = 'index')
    {
        $model = Pages::find()->where(['alias' => $alias])->one();
        $brands = AutoBrands::find()->with(['autoModels'])->asArray()->all();

        return $this->render('index.twig',[
            'model' => $model,
            'brands' => $brands
        ]);
    }

    /**
     * @param $alias
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionPage($alias)
    {
        if( ! $model = $this->getCatalogOrPage($alias) ) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render($model['template'], [
            'model' => $model
        ]);
    }

    /**
     * @return string
     */
    public function actionContacts()
    {
        return $this->render('contacts.twig');
    }

    /**
     * @return string
     */
    public function actionError()
    {
        return $this->render('error.twig');
    }

    /**
     * @param $action
     * @return bool
     * @throws \yii\base\ExitException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        $chunks = explode('.',\Yii::$app->request->hostName);
        $chunk = array_shift($chunks);

        $subdomain = Subdomains::findOne(['domain_name' => $chunk]);
        if( count($chunks) == 2 && ! $subdomain ) {
            \Yii::$app->response->setStatusCode(404);
            \Yii::$app->end();
        } elseif( ! $subdomain ) {
            $subdomain = Subdomains::findOne(['is_main' => Subdomains::IS_MAIN]);
        }

        \Yii::$app->params['subdomain_cases'] = json_decode($subdomain['cases_json'], true);
        \Yii::$app->params['phone'] = $subdomain->phone;
        \Yii::$app->params['address'] = $subdomain->address;
        \Yii::$app->params['contact_text'] = $subdomain->contact_text;
        \Yii::$app->params['subdomains'] = ArrayHelper::map(Subdomains::find()->asArray()->all(), 'domain_name', function($item){
            return json_decode($item['cases_json']);
        });
        return true;
    }
}
