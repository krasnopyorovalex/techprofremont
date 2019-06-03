<?php

namespace frontend\controllers;

use common\models\AutoModels;
use yii\web\NotFoundHttpException;

/**
 * AutoModel controller
 */
class AutoModelController extends SiteController
{

    /**
     * @param $catalog
     * @param $category
     * @param int $page
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionCategory($catalog, $category, $page = 0)
    {
        $autoBrand = $catalog;
        $autoModel = $category;
        if(!$model = AutoModels::find()->where(['alias' => $autoModel])->with(['brand'])->one()){
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('auto_models.twig',[
            'model' => $model
        ]);
    }
}
