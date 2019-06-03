<?php

namespace frontend\widgets\FormOrder;

use frontend\widgets\FormOrder\form\FormOrder as Model;
use yii\base\Widget;

class FormOrder extends Widget
{

    public function run()
    {
        return $this->render('form_order.twig', ['modelForm' => new Model()]);
    }
}