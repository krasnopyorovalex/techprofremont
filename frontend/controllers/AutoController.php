<?php

namespace frontend\controllers;

use common\models\AutoBrands;
use common\models\AutoGenerations;
use common\models\AutoModels;
use common\models\Catalog;
use common\models\CatalogCategories;
use yii\web\NotFoundHttpException;

/**
 * Auto controller
 */
class AutoController extends SiteController
{
    /**
     * @param $brand
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionBrand($brand)
    {
        if( ! $model = AutoBrands::find()->where(['alias' => $brand])->with(['autoModels'])->limit(1)->one() ) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('auto_brand.twig', [
            'model' => $model
        ]);
    }

    /**
     * @param $model
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionModel($model)
    {
        if( ! $model = AutoModels::find()->where(['alias' => $model])->with(['brand', 'autoGenerations'])->limit(1)->one() ) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('auto_model.twig', [
            'model' => $model
        ]);
    }

    /**
     * @param $generation
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionGeneration($generation)
    {
        if( ! $model = AutoGenerations::find()->where(['alias' => $generation])->with(['model' => function($query){
            return $query->with(['brand']);
        }])->limit(1)->one() ) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $mainCatalog = Catalog::find()->where(['is_main' => 1])->with(['catalogCategories' => function($query){
            return $query->where(['parent_id' => null]);
        }])->asArray()->one();
        return $this->render('auto_generation.twig', [
            'model' => $model,
            'catalog' => $mainCatalog
        ]);
    }
}