<?php

namespace core\repositories;

use common\models\Products;
use yii\db\ActiveRecord;

class ProductsRepository
{
    public function get($id): ActiveRecord
    {
        if (!$product = Products::find()->where(['id' => $id])->limit(1)->one()) {
            throw new NotFoundException('Product is not found.');
        }
        return $product;
    }

    public function save(ActiveRecord $product): void
    {
        if (!$product->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    /**
     * @param $id
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove($id): void
    {
        if (!Products::findOne($id)->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}