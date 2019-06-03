<?php

namespace frontend\controllers;

use yii\web\Controller;
use yii\web\Response;

/**
 * Robots controller
 */
class RobotsController extends Controller
{

    public $layout = false;

    /**
     * @throws \yii\base\ExitException
     */
    public function actionTxt()
    {
        $response = \Yii::$app->response;
        $response->format = Response::FORMAT_RAW;
        $response->getHeaders()->set('Content-Type', 'text/plain; charset=UTF-8');
        $response->content =  $this->render('robots.twig');
        return \Yii::$app->end();
    }
    
}
