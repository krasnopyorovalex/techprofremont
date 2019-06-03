<?php

use yii\db\Migration;

/**
 * Class m180329_134613_add_column_h1_to_catalog_categories_table
 */
class m180329_134613_add_column_h1_to_catalog_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('catalog_categories', 'h1', $this->string(512)->after('name'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('catalog_categories', 'h1');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180329_134613_add_column_h1_to_catalog_categories_table cannot be reverted.\n";

        return false;
    }
    */
}
