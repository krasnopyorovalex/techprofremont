<?php

namespace frontend\controllers;

use common\models\CatalogCategories;
use Exception;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
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
    public function behaviors(): array
    {
        return ArrayHelper::merge(parent::behaviors(),[
            'class' => ProductsBehavior::class
        ]);
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
         * @var $catalogCategory CatalogCategories
         */
        $catalogCategory = CatalogCategories::find()
            ->where(['alias' => $category])
            ->with(['brands', 'productsVia' => function (ActiveQuery $query) {
                return $query->andWhere(['subdomain_id' => Yii::$app->params['subdomain']->id]);
            }, 'catalogCategoryBrands','catalogCategories' => static function (ActiveQuery $query){
                return $query->with(['brands','catalogCategories']);
            }, 'catalog' => static function(ActiveQuery $query) {
                return $query->with(['catalogCategories' => static function (ActiveQuery $query){
                    return $query->with(['brands']);
                }]);
            }])
            ->limit(1)
            ->one();

        if ( !$catalogCategory) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        try {
            $this->getProducts($catalogCategory, $page);
            $this->parse($catalogCategory);
        } catch (Exception $e) {
            $catalogCategory->text = $e->getMessage();
        }

        if (Yii::$app->request->isPost) {
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
        $model = CatalogCategories::find()->where(['alias' => $subcategory])->with(['parent'])->limit(1)->one();

        if ( !$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        try {
            $this->getProducts($model, $page);
            $this->parse($model);
        } catch (Exception $e) {
            $model->text = $e->getMessage();
        }

        if (Yii::$app->request->isPost) {
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
        $model = CatalogCategories::find()->where(['alias' => $subsubcategory])->with(['parent'])->limit(1)->one();
        if ( !$model) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        try {
            $this->getProducts($model, $page);
            $this->parse($model);
        } catch (Exception $e) {
            $model->text = $e->getMessage();
        }

        if (Yii::$app->request->isPost) {
            return $this->json();
        }

        return $this->html('sub_sub_category.twig');
    }
}
