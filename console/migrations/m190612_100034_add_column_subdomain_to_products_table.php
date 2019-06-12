<?php

use yii\db\Migration;

/**
 * Class m190612_100034_add_column_subdomain_to_products_table
 */
class m190612_100034_add_column_subdomain_to_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%products}}', 'subdomain_id', $this->integer()->after('category_id'));

        $this->createIndex('{{%idx-products-subdomain_id}}', '{{%products}}', 'subdomain_id');

        $this->addForeignKey('{{%fk-products-subdomain_id}}', '{{%products}}', 'subdomain_id', '{{%subdomains}}', 'id', 'SET NULL', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('{{%fk-products-subdomain_id}}', '{{%products}}');
        $this->dropIndex('{{%idx-products-subdomain_id}}', '{{%products}}');
        $this->dropColumn('{{%products}}', 'subdomain_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190612_100034_add_column_subdomain_to_products_table cannot be reverted.\n";

        return false;
    }
    */
}
