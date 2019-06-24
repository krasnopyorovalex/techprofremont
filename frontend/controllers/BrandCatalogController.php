<?php

namespace frontend\controllers;

use common\models\CatalogCategories;
use frontend\components\ProductsBehavior;
use Yii;
use yii\db\ActiveQuery;
use yii\web\NotFoundHttpException;
use Exception;

/**
 * BrandCatalog controller
 *
 * @mixin ProductsBehavior
 */
class BrandCatalogController extends SiteController
{

    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            'class' => ProductsBehavior::class
        ];
    }

    /**
     * @param $category
     * @param $brand
     * @param int $page
     * @return mixed
     */
    public function actionProductsWithBrand($category, $brand, $page = 0)
    {
        /**
         * @var $catalog CatalogCategories
         */
        $catalog = CatalogCategories::find()
            ->where(['alias' => $category])
            ->with(['parent','productCategories','brands', 'catalogCategoryBrands','catalogCategories' => static function (ActiveQuery $query){
                return $query->with(['brands','catalogCategories']);
            }, 'catalog' => static function(ActiveQuery $query) {
                return $query->with(['catalogCategories' => static function (ActiveQuery $query){
                    return $query->with(['brands']);
                }]);
            }])
            ->limit(1)
            ->one();

        try {
            $this->getProducts($catalog, $page, $brand);
        } catch (Exception $exception) {
            $catalog->text = $exception->getMessage();
        }

        if (Yii::$app->request->isPost) {
            return $this->json();
        }

        return $this->html('category_with_brand.twig');
    }

    /**
     * @param $subcategory
     * @param $brand
     * @param int $page
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionProductsWithBrandSubcategory($subcategory, $brand, $page = 0)
    {
        /**
         * @var $catalog CatalogCategories
         */
        $catalogCategories = CatalogCategories::find()->where(['alias' => $subcategory])->with([
            'parent',
            'catalogCategories',
            'brands' => static function(ActiveQuery $query) {
                return $query->asArray()->indexBy('id')->column();
            }
        ])->limit(1)->one();

        if ( !$catalogCategories && !in_array($brand, $catalogCategories->brands, true)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $page = is_numeric($brand) ? $brand : $page;
        $this->getProducts($catalogCategories, $page, $brand);

        if (Yii::$app->request->isPost) {
            return $this->json();
        }

        return $this->html('category_with_brand_sub.twig');
    }
}
