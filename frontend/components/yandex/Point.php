<?php


namespace frontend\components\yandex;


/**
 * Class Point
 * @package frontend\components\yandex
 */
class Point
{

    /**
     * @var float
     */
    private $latitude;
    /**
     * @var float
     */
    private $longitude;

    /**
     * Point constructor.
     * @param float $latitude
     * @param float $longitude
     */
    public function __construct(float $latitude, float $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @return string
     */
    public function getCoords(): string
    {
        return sprintf('%s,%s', $this->getLongitude(), $this->getLatitude());
    }
}
