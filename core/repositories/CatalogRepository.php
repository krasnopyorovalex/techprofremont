<?php

namespace core\repositories;

use common\models\Catalog;
use yii\db\ActiveRecord;

class CatalogRepository
{
    public function get($id): ActiveRecord
    {
        if (!$catalog = Catalog::findOne($id)) {
            throw new NotFoundException('Catalog is not found.');
        }
        return $catalog;
    }

    public function save(ActiveRecord $catalog): void
    {
        if (!$catalog->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove($id): void
    {
        if (!Catalog::findOne($id)->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}