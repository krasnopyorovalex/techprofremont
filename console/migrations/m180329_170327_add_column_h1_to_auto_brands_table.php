<?php

use yii\db\Migration;

/**
 * Class m180329_170327_add_column_h1_to_auto_brands_table
 */
class m180329_170327_add_column_h1_to_auto_brands_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('auto_brands', 'h1', $this->string(512)->after('name'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('auto_brands', 'h1');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180329_170327_add_column_h1_to_auto_brands_table cannot be reverted.\n";

        return false;
    }
    */
}
