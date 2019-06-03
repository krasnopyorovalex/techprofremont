<?php

namespace backend\components;

use common\models\AutoBrands;
use common\models\ProductsAutoVia;
use yii\base\Behavior;
use yii\helpers\ArrayHelper;

/**
 * Class MakeListAutoBehavior
 * @package backend\components
 */
class MakeListAutoBehavior extends Behavior
{

    const DELIMITER = '_';

    /**
     * @var array
     */
    private $makesList = [];

    /**
     * @return array
     */
    public function makeListAuto(): array
    {
        $autos = AutoBrands::find()->with(['autoModels' => function($query){
            return $query->with(['autoGenerations']);
        }])->asArray()->all();

        foreach ($autos as $auto){
            if($auto['autoModels']){
                foreach ($auto['autoModels'] as $model){
                    array_push($this->makesList, [
                        'id' => 'model' . self::DELIMITER . $model['id'],
                        'name' => $model['name'],
                        'brand' => $auto['name']
                    ]);
                    if($model['autoGenerations']){
                        foreach ($model['autoGenerations'] as $generation){
                            array_push($this->makesList, [
                                'id' => 'generation'. self::DELIMITER . $generation['id'],
                                'name' => '*** ' . $generation['name'],
                                'brand' => $auto['name']
                            ]);
                        }
                    }
                }
            }
        }

        return ArrayHelper::map($this->makesList,'id','name','brand');
    }

    /**
     * @param array $items
     * @return array
     */
    public function transformListAutoSelectedToSave(array $items = []): array
    {
        $items = array_map(function ($item){
            $chunks = explode(self::DELIMITER, $item);
            return [
                $chunks[0] => $chunks[1]
            ];
        }, (array) $items);

        return $items;
    }

    /**
     * @param array $items
     * @return array
     */
    public function transformListAutoSelectedAfterFind(array $items): array
    {
        return array_map(function ($item){
            /**
             * @var $item ProductsAutoVia
             */
            return $item->type . self::DELIMITER . $item->auto_id;
        }, (array) $items);
    }
}