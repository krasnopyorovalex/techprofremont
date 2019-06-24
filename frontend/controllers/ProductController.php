<?php

namespace frontend\controllers;

use common\models\Products;
use frontend\components\yandex\Geocoder;
use yii\web\NotFoundHttpException;

/**
 * Class ProductController
 * @package frontend\controllers
 */
class ProductController extends SiteController
{
    /**
     * @var Geocoder
     */
    private $yandexGeocoder;

    /**
     * ProductController constructor.
     * @param $id
     * @param $module
     * @param Geocoder $yandexGeocoder
     * @param array $config
     */
    public function __construct($id, $module, Geocoder $yandexGeocoder, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->yandexGeocoder = $yandexGeocoder;
    }

    /**
     * @param $alias
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionShow($alias): string
    {
        $model = Products::find()->where(['alias' => $alias])->with(['makers'])->limit(1)->one();

        if ( !$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $point = $model->address
            ? $this->yandexGeocoder->load($model->address)
            : false;

        return $this->render('product.twig', [
            'model' => $model,
            'point' => $point
        ]);
    }
}
