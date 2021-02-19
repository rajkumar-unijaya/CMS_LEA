<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%OTP_authentication}}`.
 */
class m210216_080640_create_OTP_authentication_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%OTP_authentication}}', [
            'id' => $this->primaryKey(),
            'otp' => 'int(11) NOT NULL',
            'ip' => 'varchar(50) NOT NULL',
            'email' => 'varchar(250) NOT NULL',
            'expired' => 'int(2) NOT NULL DEFAULT 0',
            'generated' => 'datetime NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'created_at' => 'datetime NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'timestamp DEFAULT CURRENT_TIMESTAMP',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%OTP_authentication}}');
    }
}
