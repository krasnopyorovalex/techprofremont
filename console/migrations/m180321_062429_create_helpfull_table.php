<?php

use yii\db\Migration;

/**
 * Handles the creation of table `helpfull`.
 */
class m180321_062429_create_helpfull_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('helpfull', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer(),
            'name' => $this->string(512)->notNull(),
            'alias' => $this->string()->notNull(),
            'is_complete' => $this->smallInteger(1)->defaultValue(0)
        ], $tableOptions);

        $this->addForeignKey('fk-helpfull-parent', '{{%helpfull}}', 'parent_id', '{{%helpfull}}', 'id', 'SET NULL', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('helpfull');
    }
}
