<?php

namespace frontend\controllers;

use common\models\Brands;

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
        if(!$model = Brands::find()->where(['alias' => $alias])->with(['autoModels'])->one()){
            return parent::actionShow($alias);
        }

        return $this->render('auto.twig',[
            'model' => $model
        ]);
    }
}
