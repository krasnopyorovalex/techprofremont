<?php

namespace frontend\widgets\AutoBrands;

use common\models\AutoBrands as Model;
use common\models\AutoModels;
use yii\base\Widget;

class AutoBrands extends Widget
{

    public function run()
    {
        if ( \Yii::$app->request->get('generation') ) {

            return $this->render('auto_brands.twig', [
                'brands' => []
            ]);

        } elseif ( $model = \Yii::$app->request->get('model') ) {

            return $this->render('auto_generations.twig', [
                'data' => AutoModels::find()->where(['alias' => $model])->with(['brand', 'autoGenerations'])->asArray()->limit(1)->one()
            ]);

        } elseif ( $brand = \Yii::$app->request->get('brand') ) {

            return $this->render('auto_models.twig', [
                'data' => Model::find()->where(['alias' => $brand])->with(['autoModels'])->asArray()->limit(1)->one()
            ]);

        } else {

            return $this->render('auto_brands.twig', [
                'brands' => Model::find()->asArray()->all()
            ]);

        }
    }
}