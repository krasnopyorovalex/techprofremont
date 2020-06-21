<?php

use yii\db\Migration;

/**
 * Class m200620_155300_add_column_text_to_makers_table
 */
class m200620_155300_add_column_text_to_makers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%makers}}', 'text', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%makers}}', 'text');
    }
}
