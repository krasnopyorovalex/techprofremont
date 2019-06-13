<?php

use yii\db\Migration;

/**
 * Class m190613_073406_modify_column_articul_to_working_hours_in_products_table
 */
class m190613_073406_modify_column_articul_to_working_hours_in_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('{{%products}}', 'articul', 'working_hours');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('{{%products}}', 'working_hours', 'articul');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190613_073406_modify_column_articul_to_working_hours_in_products_table cannot be reverted.\n";

        return false;
    }
    */
}
