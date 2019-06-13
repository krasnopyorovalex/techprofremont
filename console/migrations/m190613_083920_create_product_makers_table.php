<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_makers}}`.
 */
class m190613_083920_create_product_makers_table extends Migration
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

        $this->createTable('{{%product_makers}}', [
            'product_id' => $this->integer()->notNull(),
            'maker_id' => $this->integer()->notNull()
        ], $tableOptions);

        $this->addPrimaryKey('pk-product_makers', '{{%product_makers}}', ['product_id', 'maker_id']);

        $this->addForeignKey('fk-product_makers-product', '{{%product_makers}}', 'product_id', '{{%products}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk-product_makers-maker', '{{%product_makers}}', 'maker_id', '{{%makers}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-product_makers-product', '{{%product_makers}}');
        $this->dropForeignKey('fk-product_makers-maker', '{{%product_makers}}');

        $this->dropTable('{{%product_brands}}');
    }
}
