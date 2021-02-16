<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * EmailForm is the model behind the login form.
 *
 * @property-read User|null $user This property is read-only.
 *
 */
class ValidationCodeForm extends Model
{
    public $validationCode;
    


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['validationCode'], 'required'],
            
        ];
    }
}
