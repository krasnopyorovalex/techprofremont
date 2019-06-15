<?php

use yii\db\Migration;

/**
 * Class m190612_093644_add_column_is_popular_to_auto_brands_table
 */
class m190612_093644_add_column_is_popular_to_auto_brands_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('brands', 'is_popular', $this->tinyInteger(1)->defaultValue(0)->unsigned());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('brands', 'is_popular');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190612_093644_add_column_is_popular_to_auto_brands_table cannot be reverted.\n";

        return false;
    }
    */
}
