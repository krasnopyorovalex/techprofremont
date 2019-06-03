<?php

namespace frontend\controllers;

use common\models\AutoBrands;

/**
 * AutoBrand controller
 */
class AutoBrandController extends CatalogController
{

    /**
     * @param $alias
     * @param int $page
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionShow($alias, $page = 0)
    {
        if(!$model = AutoBrands::find()->where(['alias' => $alias])->with(['autoModels'])->one()){
            return parent::actionShow($alias);
        }

        return $this->render('auto.twig',[
            'model' => $model
        ]);
    }
}
