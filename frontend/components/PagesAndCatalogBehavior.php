<?php

namespace frontend\components;

use common\models\Catalog;
use common\models\Pages;
use yii\base\Behavior;

/**
 * Class PagesAndCatalogBehavior
 * @package frontend\components
 */
class PagesAndCatalogBehavior extends Behavior
{
    /**
     * @param $alias
     * @return array|bool|null|\yii\db\ActiveRecord
     */
    public function getCatalogOrPage($alias)
    {
        $model = Pages::find()
            ->where(['alias' => $alias])
            ->limit(1)
            ->one();

        return $model ?? Catalog::find()
                ->where(['alias' => $alias])
                ->with(['catalogCategories' => function($query){
                    return $query->where(['parent_id' => null]);
                }])
                ->limit(1)
                ->one();
    }

}