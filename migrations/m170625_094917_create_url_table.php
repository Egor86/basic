<?php

use yii\db\Migration;

/**
 * Handles the creation of table `url`.
 */
class m170625_094917_create_url_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('url', [
            'id' => $this->primaryKey(),
            'url' => $this->char(255)->notNull(),
            'title' => $this->char(255)->notNull(),
            'status_code' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('url');
    }
}
