<?php

use yii\db\Migration;

/**
 * Class m190613_064603_remove_column_maker_id_from_products_table
 */
class m190613_064603_remove_column_maker_id_from_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('{{%fk-products-maker_id}}', '{{%products}}');
        $this->dropColumn('{{%products}}', 'maker_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%products}}', 'maker_id', $this->integer()->after('subdomain_id'));
        $this->addForeignKey('{{%fk-products-maker_id}}', '{{%products}}', 'maker_id', '{{%makers}}', 'id', 'SET NULL', 'RESTRICT');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190613_064603_remove_column_maker_id_from_products_table cannot be reverted.\n";

        return false;
    }
    */
}
