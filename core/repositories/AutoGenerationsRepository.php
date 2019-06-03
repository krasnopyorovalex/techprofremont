<?php

namespace core\repositories;

use common\models\AutoGenerations;
use yii\db\ActiveRecord;

class AutoGenerationsRepository
{
    public function get($id): ActiveRecord
    {
        if (!$brand = AutoGenerations::find()->where(['id' => $id])->with(['model' => function($query) {
            return $query->with(['brand']);
        }])->one()) {
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

    /**
     * @param $id
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove($id): void
    {
        if (!AutoGenerations::findOne($id)->delete()) {
            throw new \RuntimeException('Removing error.');
        }
    }
}