<?php

namespace frontend\widgets\PaginateBtn;

use yii\base\Widget;

class PaginateBtn extends Widget
{
    public $count;

    public function run()
    {
        return $this->render('paginate_btn.twig', [
            'count' => $this->count
        ]);
    }
}