<?php

namespace frontend\components;

use common\models\Brands;
use common\models\CatalogCategories;
use common\models\Products;
use Yii;
use yii\base\Behavior;
use yii\helpers\ArrayHelper;

/**
 * Class ProductsBehavior
 * @package frontend\components
 */
class ProductsBehavior extends Behavior
{
    private $ids = [];
    private $model;
    private $data;

    /**
     * @param CatalogCategories $catalog
     * @param $page
     * @param bool $brand
     */
    public function getProducts(CatalogCategories $catalog, $page, $brand = false): void
    {
        $this->model = $catalog;
        $this->ids[] = $catalog->id;
        $this->getCatalogCategories($catalog->catalogCategories);

        foreach ($this->model->productsVia as $product) {
            $this->ids[] = $product->category_id;
        }

        $products = new Products();

        $query = $products::find()
            ->where(['category_id' => $this->ids])
            ->andWhere(['subdomain_id' => Yii::$app->params['subdomain']->id]);

        if ($brand) {
            $productIds = $this->getProductsWithBrand($brand);

            $query->andWhere(['id' => $productIds]);
        }

        $count = clone $query;

        $products = $query
            ->with(['makers'])
            ->limit(Yii::$app->params['per_page'])
            ->offset($page)
            ->asArray()
            ->all();

        $this->data = [
            'products' => $products,
            'count' => $count->count(),
            'offset' => $page + Yii::$app->params['per_page'],
            'brand' => $brand
        ];
    }

    /**
     * @return mixed
     */
    public function json()
    {
        $this->data['products'] = $this->owner->renderAjax('@frontend/widgets/ProductsListForCategory/views/products_list_for_category.twig',[
            'model' => $this->data['products']
        ]);
        return $this->owner->asJson($this->data);
    }

    /**
     * @param $template
     * @return mixed
     */
    public function html(string $template)
    {
        return $this->owner->render($template, [
            'model' => $this->model,
            'products' => $this->data['products'],
            'count' => $this->data['count'],
            'brands' => $this->data['brand']
                ? Brands::findOne(['alias' => $this->data['brand']])
                : false,
        ]);
    }

    /**
     * @param $catalogCategories
     */
    private function getCatalogCategories($catalogCategories): void
    {
        foreach ($catalogCategories as $catalogCategory) {
            $this->ids[] = $catalogCategory->id;
            if($catalogCategories = $catalogCategory->catalogCategories){
                $this->getCatalogCategories($catalogCategories);
            }
        }
    }

    /**
     * @param $alias
     * @return array
     */
    private function getProductsWithBrand($alias): array
    {
        $brand = Brands::find()->where(['alias' => $alias])->with(['productBrands'])->asArray()->limit(1)->one();

        return ArrayHelper::getColumn($brand['productBrands'], 'product_id');
    }
}
