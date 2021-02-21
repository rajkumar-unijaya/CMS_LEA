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
class EmailForm extends Model
{
    public $email;
    


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            ['email', 'trim'],
            ['email', 'email'],
            //['email', 'domainCheck'],
            ['email', 'string', 'max' => 255],
            
        ];
    }

    /*public function domainCheck($attribute, $params){ 
        $allDomains = ["gov.my","irc.org"];
        $email_irc_org = strrchr($this->email, '@');
         $domain = substr($email_irc_org,1, );
         if(!in_array( $domain ,$allDomains ))
        {
            $this->addError($attribute,"Email is not valid");
        }
        
    }*/

    
}
