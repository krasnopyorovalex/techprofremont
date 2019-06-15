<?php

use yii\db\Migration;

/**
 * Handles the dropping of table `{{%auto_generations}}`.
 */
class m190615_061212_drop_auto_generations_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('{{%fk-auto_generations-model_id}}', '{{%auto_generations}}');

        $this->dropIndex('{{%idx-auto_generations-alias}}', '{{%auto_generations}}');
        $this->dropIndex('{{%idx-auto_generations-model_id}}', '{{%auto_generations}}');

        $this->dropTable('{{%auto_generations}}');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('auto_generations', [
            'id' => $this->primaryKey(),
            'model_id' => $this->integer()->notNull(),
            'name' => $this->string(512)->notNull(),
            'alias' => $this->string()->notNull()
        ],$tableOptions);

        $this->createIndex('{{%idx-auto_generations-model_id}}', '{{%auto_generations}}', 'model_id');
        $this->createIndex('{{%idx-auto_generations-alias}}', '{{%auto_generations}}', 'alias', true);

        $this->addForeignKey('{{%fk-auto_generations-model_id}}', '{{%auto_generations}}', 'model_id', '{{%auto_models}}', 'id');

        $this->addColumn('auto_generations', 'h1', $this->string(512)->after('name'));
        $this->addColumn('auto_generations', 'image', $this->string(36));
    }
}
