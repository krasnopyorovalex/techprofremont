<?php

use yii\db\Migration;

/**
 * Class m190615_061723_rename_auto_brands_table_to_brands_table
 */
class m190615_061723_rename_auto_brands_table_to_brands_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameTable('{{%brands}}', '{{%brands}}');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameTable('{{%brands}}', '{{%brands}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190615_061723_rename_auto_brands_table_to_brands_table cannot be reverted.\n";

        return false;
    }
    */
}
