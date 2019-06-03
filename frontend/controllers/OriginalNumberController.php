<?php

namespace frontend\controllers;

use common\models\ProductsOriginalNumbers;
use frontend\components\OriginalNumberBehavior;
use yii\web\NotFoundHttpException;

/**
 * OriginalNumber controller
 *
 * @mixin OriginalNumberBehavior
 */
class OriginalNumberController extends SiteController
{

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'class' => OriginalNumberBehavior::class
        ];
    }

    /**
     * @param $number
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionShow($number)
    {
        if( ! $model = ProductsOriginalNumbers::find()->where(['number' => $number])->with(['product' => function($query){
            return $query->with(['maker']);
        }])->asArray()->all() ){
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $products = $this->getProducts($model);

        return $this->render('original_number.twig', [
            'model' => $model,
            'products' => $products
        ]);
    }
}
