<?php

namespace appsc\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `{{%building}}`.
 */
class M220218154221CreateBuildingTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%building}}', [
            'id' => $this->primaryKey(),
            
            'race' => $this->string()->notNull()->comment('P T Z'),
            'name' => $this->string(32)->notNull(),

            'mineCost' => $this->integer(),
            'gasCost' => $this->integer(),
            'timeCost' => $this->integer(),

            'hp' => $this->integer()->comment('生命值'),
            'shield' => $this->integer()->comment('护盾值'),
            'armor' => $this->integer()->comment('初始防御值'), // 无法升级

            'energy' => $this->string(32)->comment('能量'),

            'createdAt' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updatedAt' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%building}}');
    }
}
