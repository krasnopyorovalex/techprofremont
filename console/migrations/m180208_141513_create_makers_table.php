<?php

use yii\db\Migration;

/**
 * Handles the creation of table `makers`.
 */
class m180208_141513_create_makers_table extends Migration
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
        $this->createTable('makers', [
            'id' => $this->primaryKey(),
            'name' => $this->string(128)->notNull(),
            'alias' => $this->string()->notNull(),
        ],$tableOptions);

        $this->createIndex('{{%idx-makers-alias}}', '{{%makers}}', 'alias', true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('makers');
    }
}
