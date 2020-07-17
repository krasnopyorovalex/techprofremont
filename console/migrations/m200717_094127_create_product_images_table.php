<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_images}}`.
 */
class m200717_094127_create_product_images_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_images}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'basename' => $this->char(32)->notNull(),
            'ext' => $this->string(5)->notNull(),
            'pos' => $this->integer()->notNull()->defaultValue(0)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product_images}}');
    }
}
