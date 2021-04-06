<?php

namespace app\models;

use Yii;
use yii\base\Model;

class SearchForm extends Model
{
    public $phone_number;

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'phone_number' => 'Search'
        ];
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['phone_number'], 'required','message'=>'Masukkan Phone No.'],
            //[['phone_number'], 'integer', 'min' => 7, 'max' => 12,'message'=>'Masukkan No. Telefon Yang Sah'],
            
        ];
    }

    public function checkCountryCode($attribute, $params){ 
        $allDomains = [".gov.my"];
        $domain = $this->find_occurence_from_end($this->email, ".", 2);
         if(!in_array( $domain ,$allDomains ))
        {
            $this->addError($attribute,"Email is not valid");
        }
        
    }
}