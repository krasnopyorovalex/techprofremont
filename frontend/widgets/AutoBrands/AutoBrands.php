<?php

namespace frontend\widgets\AutoBrands;

use common\models\AutoBrands as Model;
use common\models\AutoModels;
use Yii;
use yii\base\Widget;

/**
 * Class AutoBrands
 * @package frontend\widgets\AutoBrands
 */
class AutoBrands extends Widget
{

    /**
     * @return string
     */
    public function run(): string
    {
        if (Yii::$app->request->get('generation')) {

            return $this->render('auto_brands.twig', [
                'brands' => []
            ]);

        }

        if ($model = Yii::$app->request->get('model')) {

            return $this->render('auto_generations.twig', [
                'data' => AutoModels::find()->where(['alias' => $model])->with(['brand', 'autoGenerations'])->asArray()->limit(1)->one()
            ]);

        }

        if ($brand = Yii::$app->request->get('brand')) {

            return $this->render('auto_models.twig', [
                'data' => Model::find()->where(['alias' => $brand])->with(['autoModels'])->asArray()->limit(1)->one()
            ]);

        }

        return $this->render('auto_brands.twig', [
            'brands' => Model::find()->asArray()->all()
        ]);
    }
}
