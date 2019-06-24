<?php

namespace core\repositories;

use common\models\BrandsOld;
use RuntimeException;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;

/**
 * Class BrandsRepository
 * @package core\repositories
 */
class BrandsRepository
{
    /**
     * @param $id
     * @return ActiveRecord
     */
    public function get($id): ActiveRecord
    {
        if ( ! $brand = BrandsOld::findOne($id)) {
            throw new NotFoundException('Brand is not found.');
        }
        return $brand;
    }

    /**
     * @return array
     */
    public function all(): array
    {
        if ( ! $brands = BrandsOld::find()->all()) {
            throw new NotFoundException('Brands is not found.');
        }
        return $brands;
    }

    /**
     * @param ActiveRecord $brand
     */
    public function save(ActiveRecord $brand): void
    {
        if ( ! $brand->save()) {
            throw new RuntimeException('Saving error.');
        }
    }

    /**
     * @param $id
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function remove($id): void
    {
        if ( ! BrandsOld::findOne($id)->delete()) {
            throw new RuntimeException('Removing error.');
        }
    }
}
