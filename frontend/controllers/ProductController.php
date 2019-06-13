<?php

namespace frontend\controllers;

use common\models\CatalogCategories;
use common\models\Products;
use yii\web\NotFoundHttpException;

/**
 * Class ProductController
 * @package frontend\controllers
 */
class ProductController extends SiteController
{
    /**
     * @param $alias
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionShow($alias): string
    {
        if( ! $model = Products::find()->where(['alias' => $alias])->with(['category', 'makers'])->limit(1)->one() ){
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $catalogCategories = CatalogCategories::find()->where(['catalog_id' => $model['category']['catalog_id']])->asArray()->all();

        return $this->render('product.twig', [
            'model' => $model,
            'sidebarMenuLinks' => $catalogCategories
        ]);
    }
}
