<?php

namespace backend\modules\parser_csv;

use yii\base\Module;

/**
 * parser_csv module definition class
 */
class ParserCsv extends Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\parser_csv\controllers';

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        parent::init();

        $this->params['name'] = 'Парсер CSV';
    }
}
