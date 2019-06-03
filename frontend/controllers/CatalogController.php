<?php

namespace frontend\controllers;

use common\models\CatalogCategories;
use yii\web\NotFoundHttpException;
use frontend\components\ProductsBehavior;

/**
 * CatalogBrand controller
 *
 * @mixin ProductsBehavior
 */
class CatalogController extends SiteController
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'class' => ProductsBehavior::class
        ];
    }

    /**
     * @param $category
     * @param int $page
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionShow($category, $page = 0)
    {
        /**
         * @var $model CatalogCategories
         */
        if( ! $model = CatalogCategories::find()->where(['alias' => $category])->with(['parent'])->limit(1)->one() ) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $this->getProducts($model, $page);

        if(\Yii::$app->request->isPost){
            return $this->json();
        }

        return $this->html('category.twig');
    }

    /**
     * @param $subcategory
     * @param int $page
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionShowSubCategory($subcategory, $page = 0)
    {
        /**
         * @var $model CatalogCategories
         */
        if( ! $model = CatalogCategories::find()->where(['alias' => $subcategory])->with(['parent'])->limit(1)->one() ) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $this->getProducts($model, $page);

        if(\Yii::$app->request->isPost){
            return $this->json();
        }

        return $this->html('sub_category.twig');
    }

    /**
     * @param $subsubcategory
     * @param int $page
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionShowSubSubCategory($subsubcategory, $page = 0)
    {
        /**
         * @var $model CatalogCategories
         */
        if( ! $model = CatalogCategories::find()->where(['alias' => $subsubcategory])->with(['parent'])->limit(1)->one() ) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $this->getProducts($model, $page);

        if(\Yii::$app->request->isPost){
            return $this->json();
        }

        return $this->html('sub_sub_category.twig');
    }

}
