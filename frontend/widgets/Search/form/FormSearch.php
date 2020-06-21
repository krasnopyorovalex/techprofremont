<?php

namespace frontend\widgets\Search\form;

use yii\db\ActiveRecord;

/**
 * Class FormSearch
 * @package frontend\widgets\Search\form
 */
class FormSearch extends ActiveRecord
{
    private const TYPE_CATEGORY = 'category';
    private const TYPE_MAKER = 'maker';

    public $type;
    public $keyword;

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['type', 'keyword'], 'required'],
            ['type', 'in', 'range' => [self::TYPE_CATEGORY, self::TYPE_MAKER]]
        ];
    }

    /**
     * @return bool
     */
    public function isCategory(): bool
    {
        return $this->type === self::TYPE_CATEGORY;
    }
}
