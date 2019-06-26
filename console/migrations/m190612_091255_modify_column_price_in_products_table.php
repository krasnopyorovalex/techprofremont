<?php

use yii\db\Migration;

/**
 * Class m190612_091255_modify_column_price_in_products_table
 */
class m190612_091255_modify_column_price_in_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('products', 'price', 'phone');
        $this->alterColumn('products', 'phone', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('products', 'phone', $this->integer()->notNull()->defaultValue(0));
        $this->renameColumn('products', 'phone', 'price');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190612_091255_modify_column_price_in_products_table cannot be reverted.\n";

        return false;
    }
    */
}
