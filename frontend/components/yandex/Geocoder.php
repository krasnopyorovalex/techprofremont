<?php


namespace frontend\components\yandex;

use Yii;
use yii\helpers\Json;

/**
 * Class Geocoder
 * @package frontend\components\yandex
 */
class Geocoder
{
    private const API_URL = 'https://geocode-maps.yandex.ru/1.x/?';
    private const MONTH_DURATION = 2419200;

    /**
     * @param string $address
     * @return Point
     */
    public function load(string $address): Point
    {
        $cache = Yii::$app->cache;

        $result = $cache->getOrSet(md5($address), function () use ($address) {
            $params = [
                'format' => 'json',
                'geocode' => $address,
                'apikey' => Yii::$app->params['yandex.api.key']
            ];

            return $this->execute(self::API_URL . http_build_query($params));

        }, self::MONTH_DURATION);

        [$latitude, $longitude] = explode(' ', $result);

        return new Point($latitude, $longitude);
    }

    /**
     * @param $request
     * @return mixed
     */
    private function execute($request)
    {
        $result = Json::decode(file_get_contents($request));

        return $result['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos'];
    }
}
