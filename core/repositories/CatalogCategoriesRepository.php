<?php

namespace core\repositories;

use common\models\CatalogCategories;
use yii\db\ActiveRecord;
use \RuntimeException;
use yii\db\StaleObjectException;

class CatalogCategoriesRepository
{
    public function get($id): ActiveRecord
    {
        if ( ! $catalogCategory = CatalogCategories::findOne($id)) {
            throw new NotFoundException('Catalog category is not found.');
        }

        return $catalogCategory;
    }

    public function save(ActiveRecord $catalogCats): void
    {
        if ( ! $catalogCats->save()) {
            throw new RuntimeException('Saving error.');
        }
    }

    /**
     * @param $id
     * @throws StaleObjectException
     * @throws \Throwable
     */
    public function remove($id): void
    {
        if ( ! CatalogCategories::findOne($id)->delete()) {
            throw new RuntimeException('Removing error.');
        }
    }
}
