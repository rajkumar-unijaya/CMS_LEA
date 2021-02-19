<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "otp_authentication".
 *
 * @property int $id
 * @property int $otp
 * @property string $ip
 * @property string $email
 * @property int $expired
 * @property string $generated
 * @property string $created_at
 * @property string $updated_at
 */
class OtpAuthentication extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'otp_authentication';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['otp', 'ip', 'email'], 'required'],
            [['otp', 'expired'], 'integer'],
            [['generated', 'created_at', 'updated_at'], 'safe'],
            [['email'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'otp' => 'Otp',
            'ip' => 'Ip',
            'email' => 'Email',
            'expired' => 'Expired',
            'generated' => 'Generated',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
