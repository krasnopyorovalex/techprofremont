<?php

use yii\db\Migration;

/**
 * Class m190612_092650_modify_column_barcode_in_products_table
 */
class m190612_092650_modify_column_barcode_in_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('products', 'barcode', 'address');
        $this->alterColumn('products', 'address', $this->string(128));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('products', 'address', $this->string(64));
        $this->renameColumn('products', 'address', 'barcode');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190612_092650_modify_column_barcode_in_products_table cannot be reverted.\n";

        return false;
    }
    */
}
