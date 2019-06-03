<?php

use yii\db\Migration;

/**
 * Handles the creation of table `index_to_products_auto_via`.
 */
class m180330_112044_create_index_to_products_auto_via_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('idx-products_auto_via-auto_id','{{%products_auto_via}}','auto_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-products_auto_via-auto_id','{{%products_auto_via}}');
    }
}
