<?php

use yii\db\Migration;

/**
 * Class m200620_165248_add_column_text_to_catalog_categories_table
 */
class m200620_165248_add_column_text_to_catalog_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%catalog_categories}}', 'text_seo', $this->text()->after('text'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%catalog_categories}}', 'text_seo');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200620_165248_add_column_text_to_catalog_categories_table cannot be reverted.\n";

        return false;
    }
    */
}
