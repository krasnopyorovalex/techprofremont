<?php
namespace frontend\services;

use Yii;
use yii\base\Model;

/**
 * Class SendService
 * @package frontend\services
 */
class SendService
{
    /**
     * @param Model $form
     * @return array
     */
    public function sendMessage(Model $form): array
    {
        if ( $form->load(Yii::$app->request->post()) && $form->validate() && $form->sendEmail(Yii::$app->params['email']) ) {
            return ['status' => 'success', 'message' => Yii::$app->params['success_send_form']];
        }

        return ['status' => 'error', 'message' => $form->getErrors('info') ? $form->getErrors('info')[0] : Yii::$app->params['error_send_form']];
    }

}
