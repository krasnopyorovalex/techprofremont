<?php

use yii\db\Migration;

/**
 * Class m190612_084521_add_column_advantages_to_products_table
 */
class m190612_084521_add_column_advantages_to_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('products', 'advantages', $this->string(64)->after('image'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('products', 'advantages');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190612_084521_add_column_advantages_to_products_table cannot be reverted.\n";

        return false;
    }
    */
}
