<?php

namespace frontend\widgets\Search;

use frontend\widgets\Search\form\FormSearch;
use yii\base\Widget;

class Search extends Widget
{
    public function run()
    {
        $model = new FormSearch;
        $model->load(\Yii::$app->request->queryParams);

        return $this->render('search.twig', [
            'model' => $model
        ]);
    }
}