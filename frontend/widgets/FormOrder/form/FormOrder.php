<?php

namespace frontend\widgets\FormOrder\form;

use Yii;
use yii\base\Model;

/**
 * FormOrder is the model behind the contact form.
 */
class FormOrder extends Model
{

    const SUBJECT = 'Поступила заявка';

    public $name;
    public $phone;
    public $info;
    public $agree;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'phone'], 'required'],
            ['info', 'validateInfo'],
            ['agree', 'required', 'requiredValue' => 1, 'message' => 'Отметьте, пожалуйста.']
        ];
    }

    public function validateInfo()
    {
        if (strstr($this->info, 'http')) {
            $this->addError('info', 'Нельзя вводить ссылки');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Ваше имя',
            'email' => 'Ваш email',
            'info' => 'Дополнительная информация',
            'agree' => 'Согласен на обработку персональных данных'
        ];
    }

    /**
     * @param $email
     * @return bool
     */
    public function sendEmail($email)
    {
        return Yii::$app->mailer->compose('order-form',['model' => $this])
            ->setTo($email)
            ->setFrom(['info@one-auto.ru' => $this->name])
            ->setSubject(self::SUBJECT)
            ->send();
    }
}
