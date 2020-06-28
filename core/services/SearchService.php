<?php

namespace core\services;

use common\models\Brands;
use common\models\CatalogCategories;
use common\models\Products;
use frontend\widgets\Search\form\FormSearch;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class SearchService
{
    /**
     * @param FormSearch $formSearch
     * @return array|ActiveRecord[]
     */
    public function search(FormSearch $formSearch)
    {
        $id = $formSearch->isCategory()
            ? $this->findByCategory($formSearch)
            : $this->findByBrand($formSearch);

        return Products::find()->where(['id' => $id])->limit(50)->all();
    }

    /**
     * @param FormSearch $formSearch
     * @return array
     */
    private function findByBrand(FormSearch $formSearch): array
    {
        $brands = Brands::find()
            ->select(['id'])
            ->where(['like', 'name', $formSearch->keyword])
            ->with(['products' => function (ActiveQuery $query) {
                return $query->select(['id'])
                    ->andWhere(['subdomain_id' => Yii::$app->params['subdomain']->id]);
            }])
            ->asArray()
            ->all();

        $idArray = [];
        foreach ($brands as $brand) {
            if ($brand['products']) {
                foreach ($brand['products'] as $product) {
                    $idArray[] = $product['id'];
                }
            }
        }

        return array_unique($idArray);
    }

    /**
     * @param FormSearch $formSearch
     * @return array
     */
    private function findByCategory(FormSearch $formSearch): array
    {
        $catalogCategories = CatalogCategories::find()
            ->select(['id', 'catalog_id'])
            ->where(['like', 'name', $formSearch->keyword])
            ->with(['products' => function (ActiveQuery $query) {
                return $query->select(['id', 'category_id'])
                    ->andWhere(['subdomain_id' => Yii::$app->params['subdomain']->id]);
            },'catalogCategories' => function (ActiveQuery $query) {
                return $query->select(['id', 'parent_id'])
                    ->with(['products' => function (ActiveQuery $query) {
                        return $query->select(['id', 'category_id'])
                            ->andWhere(['subdomain_id' => Yii::$app->params['subdomain']->id]);
                    }]);
            }])
            ->asArray()
            ->all();

        $idArray = [];
        foreach ($catalogCategories as $catalogCategory) {
            if ($catalogCategory['products']) {
                foreach ($catalogCategory['products'] as $product) {
                    $idArray[] = $product['id'];
                }
            }
            if ($catalogCategory['catalogCategories']) {
                foreach ($catalogCategory['catalogCategories'] as $catalogCategoryChild) {
                    if ($catalogCategoryChild['products']) {
                        foreach ($catalogCategoryChild['products'] as $productChild) {
                            $idArray[] = $productChild['id'];
                        }
                    }
                }
            }
        }

        return $idArray;
    }
}