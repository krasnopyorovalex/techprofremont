<?php

namespace frontend\controllers;

use common\models\CatalogCategories;
use frontend\models\Products;
use yii\web\NotFoundHttpException;

/**
 * Product controller
 */
class ProductController extends SiteController
{

    /**
     * @param $alias
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionShow($alias)
    {
        if( ! $model = Products::find()->where(['alias' => $alias])->with(['category', 'productsOriginalNumbers'])->limit(1)->one() ){
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('product.twig', [
            'model' => $model,
            'sidebarMenuLinks' => CatalogCategories::find()->where(['catalog_id' => $model['category']['catalog_id']])->asArray()->all()
        ]);
    }
}
