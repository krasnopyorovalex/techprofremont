<?php

namespace core\repositories;

use common\models\Products;
use RuntimeException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class ProductsRepository
 * @package core\repositories
 */
class ProductsRepository
{
    /**
     * @param $id
     * @return ActiveRecord
     */
    public function get($id): ActiveRecord
    {
        if (!$product = Products::find()->where(['id' => $id])->with(['productCategories', 'category' => static function(ActiveQuery $query) {
            return $query->with(['parent']);
        }])->limit(1)->one()) {
            throw new NotFoundException('Product is not found.');
        }

        $product->fillBrands();

        return $product;
    }

    /**
     * @param ActiveRecord $product
     */
    public function save(ActiveRecord $product): void
    {
        if (!$product->save()) {
            throw new RuntimeException('Saving error.');
        }
    }

    /**
     * @param $id
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove($id): void
    {
        if (!Products::findOne($id)->delete()) {
            throw new RuntimeException('Removing error.');
        }
    }

    /**
     * @param $alias
     * @return array|Products|ActiveRecord|null
     */
    public function getByAlias($alias)
    {
        $product = Products::find()->where(['alias' => $alias])->with(['category' => static function(ActiveQuery $query) {
            return $query->with(['parent' => static function(ActiveQuery $query) {
                return $query->with(['makers']);
            },'makers']);
        }])->limit(1)->one();

        if ( !$product) {
            throw new NotFoundException('Product is not found.');
        }

        $product->fillMakers();

        return $product;
    }
}
