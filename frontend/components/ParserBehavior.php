<?php

namespace frontend\components;

use frontend\widgets\BrandsList\BrandsList;
use Yii;
use yii\base\Behavior;

/**
 * Class ParserBehavior
 * @package frontend\components
 */
class ParserBehavior extends Behavior
{
    /**
     * @param $model
     * @return mixed
     * @throws \Exception
     */
    public function parse($model)
    {
        if (false !== strpos($model->text, '{brands}')) {
            $model->text = str_replace('<p>{brands}</p>', BrandsList::widget(), $model->text);
        }

        preg_match_all("/{subdomain_cases\|[a-z]+}/", $model->text, $matches);
        if (isset($matches[0]) && count($matches[0])) {
            foreach ($matches[0] as $item){
                [$key, $value] = explode('|', str_replace(['{','}'], '', $item));
                $model->text = str_replace($item, Yii::$app->params[$key][$value], $model->text);
            }
        }

        if (isset($model->text_seo)) {
            preg_match_all("/{subdomain_cases\|[a-z]+}/", $model->text_seo, $matches);
            if (isset($matches[0]) && count($matches[0])) {
                foreach ($matches[0] as $item){
                    [$key, $value] = explode('|', str_replace(['{','}'], '', $item));
                    $model->text_seo = str_replace($item, Yii::$app->params[$key][$value], $model->text_seo);
                }
            }
        }

        return $model;
    }
}
