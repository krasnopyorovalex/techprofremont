<?php

namespace backend\components;

use common\models\ProductBrands;
use yii\base\Behavior;
use yii\base\Component;
use yii\db\ActiveRecord;

/**
 * Class BrandBehavior
 * @package backend\components
 */
class BrandBehavior extends Behavior
{
    /**
     * @param Component $owner
     */
    public function attach($owner): void
    {
        parent::attach($owner);
        $owner->on(ActiveRecord::EVENT_AFTER_INSERT, [$this, 'onSaveRelation']);
        $owner->on(ActiveRecord::EVENT_AFTER_UPDATE, [$this, 'onSaveRelation']);
    }

    public function onSaveRelation(): void
    {
        if ($this->owner->bindingBrandsList) {

            $this->owner->unlinkAll('brands', true);

            $keys = array_keys(array_filter($this->owner->bindingBrandsList));

            array_map(function ($item) {
                return (new ProductBrands([
                    'product_id' => $this->owner->id,
                    'brand_id' => (int)$item
                ]))->save();
            }, $keys);
        }
    }
}
