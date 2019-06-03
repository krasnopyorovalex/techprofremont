<?php

namespace core\repositories;

use common\models\SubCategory;
use yii\db\ActiveRecord;

class SubCategoryRepository
{
    public function get($id): ActiveRecord
    {
        if (!$subCategory = SubCategory::find()->where(['id' => $id])->with(['category' => function($query){
            return $query->with(['catalog']);
        }])->one()) {
            throw new NotFoundException('Subcategory is not found.');
        }
        return $subCategory;
    }

    public function save(ActiveRecord $subCategory): void
    {
        if (!$subCategory->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove($id): void
    {
        if (!SubCategory::findOne($id)->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}