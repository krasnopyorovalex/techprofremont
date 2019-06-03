<?php

namespace core\repositories;

use common\models\Category;
use yii\db\ActiveRecord;

class CategoryRepository
{
    public function get($id): ActiveRecord
    {
        if (!$category = Category::find()->where(['id' => $id])->with(['catalog'])->one()) {
            throw new NotFoundException('Category is not found.');
        }
        return $category;
    }

    public function save(ActiveRecord $category): void
    {
        if (!$category->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove($id): void
    {
        if (!Category::findOne($id)->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}