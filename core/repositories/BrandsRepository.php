<?php

namespace core\repositories;

use common\models\Brands;
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
        if (!$brand = Brands::findOne($id)) {
            throw new NotFoundException('Brand is not found.');
        }
        return $brand;
    }

    /**
     * @return ActiveRecord
     */
    public function all(): ActiveRecord
    {
        if ( ! $brands = Brands::find()->all()) {
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
        if ( ! Brands::findOne($id)->delete()) {
            throw new RuntimeException('Removing error.');
        }
    }
}
