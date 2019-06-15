<?php

namespace frontend\controllers;

use frontend\components\PagesAndCatalogBehavior;
use common\models\Brands;
use common\models\Pages;
use common\models\Subdomains;
use frontend\components\ParserBehavior;
use Yii;
use yii\base\ExitException;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use \Exception;

/**
 * Site controller
 *
 * @mixin PagesAndCatalogBehavior
 * @mixin ParserBehavior
 */
class SiteController extends Controller
{
    public $layout = 'main.twig';

    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            ['class' => PagesAndCatalogBehavior::class],
            ['class' => ParserBehavior::class]
        ];
    }

    /**
     * @param string $alias
     * @return string
     */
    public function actionIndex($alias = 'index'): string
    {
        $model = Pages::find()->where(['alias' => $alias])->one();
        $brands = Brands::find()->where(['is_popular' => Brands::IS_POPULAR])->all();

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
    public function actionPage($alias): string
    {
        if( ! $model = $this->getCatalogOrPage($alias) ) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        try {
            $model->text = $this->parse($model);
        } catch (Exception $e) {
            $model->text = $e->getMessage();
        }

        return $this->render($model['template'], [
            'model' => $model
        ]);
    }

    /**
     * @return string
     */
    public function actionContacts(): string
    {
        return $this->render('contacts.twig');
    }

    /**
     * @return string
     */
    public function actionError(): string
    {
        return $this->render('error.twig');
    }

    /**
     * @param $action
     * @return bool
     * @throws ExitException
     * @throws BadRequestHttpException
     */
    public function beforeAction($action): bool
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        $chunks = explode('.',Yii::$app->request->hostName);
        $chunk = array_shift($chunks);

        $subdomain = Subdomains::findOne(['domain_name' => $chunk]);
        if( ! $subdomain && count($chunks) === 2) {
            Yii::$app->response->setStatusCode(404);
            Yii::$app->end();
        } elseif( ! $subdomain ) {
            $subdomain = Subdomains::findOne(['is_main' => Subdomains::IS_MAIN]);
        }

        Yii::$app->params['subdomain_cases'] = json_decode($subdomain['cases_json'], true);
        Yii::$app->params['phone'] = $subdomain->phone;
        Yii::$app->params['address'] = $subdomain->address;
        Yii::$app->params['contact_text'] = $subdomain->contact_text;
        Yii::$app->params['subdomains'] = ArrayHelper::map(Subdomains::find()->asArray()->all(), 'domain_name', static function($item){
            return json_decode($item['cases_json'], true);
        });
        return true;
    }
}
