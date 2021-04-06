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
class MntlPhoneNumberForm extends Model
{
    public $phone_number;
    
    

    
    
    


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['phone_number'], 'required','message'=>'Masukkan Phone No.']
        ];
    }

}
