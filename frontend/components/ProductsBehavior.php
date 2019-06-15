<?php

namespace frontend\components;

use common\models\Brands;
use common\models\AutoGenerations;
use common\models\AutoModels;
use common\models\CatalogCategories;
use common\models\Products;
use Yii;
use yii\base\Behavior;
use yii\db\ActiveQuery;
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
    private $conditions = [];

    /**
     * @param CatalogCategories $catalog
     * @param $page
     * @param null $brand
     * @param null $model
     * @param null $generation
     */
    public function getProducts(CatalogCategories $catalog, $page, $brand = null, $model = null, $generation = null): void
    {
        $this->model = $catalog;
        $this->ids[] = $catalog->id;
        $this->getCatalogCategories($catalog->catalogCategories);

        $query = Products::find()->where(['category_id' => $this->ids]);

        if ($productIds = $this->getProductsWithAuto($brand)) {
            $ids = array_map(static function ($id) {
                $key = key($id);
                return $id[$key];
            }, $productIds);
            $query->andWhere(['id' => $ids]);
        }

        $count = clone $query;

        $products = $query->with(['makers'])->limit(Yii::$app->params['per_page'])->offset($page)->asArray()->all();

        $this->data = [
            'products' => $products,
            'count' => $count->count(),
            'offset' => $page + Yii::$app->params['per_page'],
            'sidebarMenuLinks' => $catalog['catalog']['catalogCategories'],
            'brand' => $brand,
            'model' => $model,
            'generation' => $generation
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
            'sidebarMenuLinks' => $this->data['sidebarMenuLinks'],
            'brandAuto' => $this->data['brand']
                ? Brands::findOne(['alias' => $this->data['brand']])
                : false,
            'modelAuto' => $this->data['model']
                ? AutoModels::findOne(['alias' => $this->data['model']])
                : false,
            'generationAuto' => $this->data['generation']
                ? AutoGenerations::findOne(['alias' => $this->data['generation']])
                : false
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
     * @param $brand
     * @return array
     */
    private function getProductsWithAuto($brand): array
    {
        return [['product_id' => 0]];
    }

    /**
     * @param $rows
     */
    private function loadConditions($rows): void
    {
        array_map(function ($condition) {
            return array_push($this->conditions, [
                'type' => $condition->getType(),
                'auto_id' => $condition->id
            ]);
        }, $rows);
    }
}
