<?php

namespace core\repositories;

use common\models\CatalogCategories;
use yii\db\ActiveRecord;

class CatalogCategoriesRepository
{
    public function get($id): ActiveRecord
    {
        if (!$catalogCats = CatalogCategories::findOne($id)) {
            throw new NotFoundException('Catalog is not found.');
        }
        return $catalogCats;
    }

    public function save(ActiveRecord $catalogCats): void
    {
        if (!$catalogCats->save()) {
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
        if (!CatalogCategories::findOne($id)->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}