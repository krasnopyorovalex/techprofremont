<?php

namespace common\models;

use yii\db\ActiveQuery;

class Scopes extends ActiveQuery{

    /**
     * @return $this
     */
    public function publish()
    {
        return $this->andWhere(['publish' => MainModel::PUBLISH]);
    }

}