<?php

namespace core\repositories;

use common\models\AutoBrands;
use yii\db\ActiveRecord;

class AutoBrandsRepository
{
    public function get($id): ActiveRecord
    {
        if (!$brand = AutoBrands::findOne($id)) {
            throw new NotFoundException('Brand is not found.');
        }
        return $brand;
    }

    public function save(ActiveRecord $brand): void
    {
        if (!$brand->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove($id): void
    {
        if (!AutoBrands::findOne($id)->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}