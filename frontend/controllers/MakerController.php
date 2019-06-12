<?php

namespace frontend\controllers;

use common\models\Makers;
use frontend\components\MakerBehavior;
use yii\db\ActiveQuery;
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
    public function behaviors(): array
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
    public function actionShow($alias): string
    {
        if( ! $model = Makers::find()->where(['alias' => $alias])->with(['products' => static function(ActiveQuery $query){
            return $query->with(['maker']);
        }])->limit(1)->one() ){
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('maker.twig', [
            'model' => $model
        ]);
    }
}
