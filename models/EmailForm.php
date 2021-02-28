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
            //['email', 'email'],
            ['email', 'domainCheck'],
            ['email', 'string', 'max' => 255],
            
        ];
    }

   public function find_occurence_from_end($haystack, $needle, $num) {
         $actual = $haystack;
        
            for ($i=1; $i <=$num ; $i++) {
        
                # first loop return position of needle
                if($i == 1) {
                    $pos = strrpos($haystack, $needle);
                }
        
                # subsequent loops trim haystack to pos and return needle's new position
                if($i != 1) {
        
                    $haystack = substr($haystack, 0, $pos);
                    $pos = strrpos($haystack, $needle);
                    $realString = substr($actual,$pos);
        
                }
        
            }
        
            return $realString;
        
        }

    public function domainCheck($attribute, $params){ 
        $allDomains = [".gov.my"];
        $domain = $this->find_occurence_from_end($this->email, ".", 2);
         if(!in_array( $domain ,$allDomains ))
        {
            $this->addError($attribute,"Email is not valid");
        }
        
    }

    

    
}
