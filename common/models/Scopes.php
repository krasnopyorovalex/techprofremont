<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * Class Scopes
 * @package common\models
 */
class Scopes extends ActiveQuery {

    /**
     * @return Scopes
     */
    public function publish(): self
    {
        return $this->andWhere(['publish' => MainModel::PUBLISH]);
    }
}
