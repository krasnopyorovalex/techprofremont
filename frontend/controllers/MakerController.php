<?php

namespace frontend\controllers;

use common\models\Makers;
use common\models\ProductsOriginalNumbers;
use frontend\components\MakerBehavior;
use yii\web\NotFoundHttpException;

/**
 * MakerController controller
 *
 * @mixin MakerBehavior
 */
class MakerController extends SiteController
{

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'class' => MakerBehavior::class
        ];
    }

    /**
     * @param $alias
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionShow($alias)
    {
        if( ! $model = Makers::find()->where(['alias' => $alias])->with(['products' => function($query){
            return $query->with(['maker']);
        }])->limit(1)->one() ){
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('maker.twig', [
            'model' => $model
        ]);
    }
}
