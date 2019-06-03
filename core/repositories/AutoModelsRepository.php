<?php

namespace core\repositories;

use common\models\AutoModels;
use yii\db\ActiveRecord;

class AutoModelsRepository
{
    public function get($id): ActiveRecord
    {
        if (!$brand = AutoModels::find()->where(['id' => $id])->with(['brand'])->one()) {
            throw new NotFoundException('Model is not found.');
        }
        return $brand;
    }

    public function save(ActiveRecord $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function remove($id): void
    {
        if (!AutoModels::findOne($id)->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}