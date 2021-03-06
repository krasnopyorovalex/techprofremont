<?php

namespace frontend\controllers;

use common\models\Makers;
use Yii;
use yii\db\ActiveQuery;
use yii\web\NotFoundHttpException;

/**
 * Class MakerController
 * @package frontend\controllers
 */
class MakerController extends SiteController
{
    /**
     * @param $alias
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionShow($alias): string
    {
        $maker = Makers::find()->where(['alias' => $alias])->with([
            'catalogCategories' => static function (ActiveQuery $query) {
                return $query->with(['products' => function (ActiveQuery $query) {
                    return $query->andWhere(['subdomain_id' => Yii::$app->params['subdomain']->id]);
                }, 'productsVia' => function (ActiveQuery $query) {
                    return $query->andWhere(['subdomain_id' => Yii::$app->params['subdomain']->id]);
                }]);
            }
        ])->limit(1)->one();

        if ( !$maker) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('maker.twig', [
            'model' => $maker
        ]);
    }
}
