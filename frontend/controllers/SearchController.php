<?php

namespace frontend\controllers;

use common\models\Pages;
use frontend\widgets\Search\form\FormSearch;
use yii\web\NotFoundHttpException;

/**
 * Search controller
 */
class SearchController extends SiteController
{

    /**
     * @param string $alias
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex($alias = 'search')
    {
        if( !$model = Pages::find()->where(['alias' => $alias])->one() ){
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $searchModel = new FormSearch();
        $products = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('search.twig',[
            'model' => $model,
            'products' => $products
        ]);
    }
    
}
