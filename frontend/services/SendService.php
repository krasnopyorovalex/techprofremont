<?php
namespace frontend\services;

use yii\base\Model;

class SendService
{
    public function sendMessage(Model $form)
    {
        if ( $form->load(\Yii::$app->request->post()) && $form->validate() && $form->sendEmail(\Yii::$app->params['email']) ) {
            return ['status' => 'success', 'message' => \Yii::$app->params['success_send_form']];
        }
        return ['status' => 'error', 'message' => ($form->getErrors('info') ? $form->getErrors('info')[0] : \Yii::$app->params['error_send_form'])];
    }

}