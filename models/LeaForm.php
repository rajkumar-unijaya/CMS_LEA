<?php

namespace app\models;

use yii\base\Model;

class LeaForm extends Model
{
  public $user_type;
  public $email;
  public $name;
  public $icno;
  public $email_type;
  public $unit_name;
  public $organization_name;
  public $branch;
  public $district;
  public $postcode;
  public $state;
  public $mobile_no;
  public $office_phone_no;
  public $telegram_id;
  public $notification;
  
  public function rules()
  {
    return  [
      [['email'], 'required','message' => "Masukkan email"],
      [['email'],'domainCheck'], 
      [['email'], 'required','message'=>'Masukkan email', 'whenClient' => "function (attribute, value) {
                if ($('#email').val().toLowerCase().indexOf('.gov.my') >= 0)
                {
                    $('#invalid_email').html('');
                    return true;
                }
                else if($('#email').val() != '')
                {
                    
                    $('#email').val('');
                    $('#invalid_email').html('alamat email tidak sah');
                    return false;
                }
                }"],
      [['email_type'],  'required','message' => "Masukkan email type"],
      [['name'], 'required', 'message' => "Masukkan nama"],
      [['icno'], 'required', 'message' => "Masukkan ic"],
      //[['unit_name'], 'required', 'message' => "Masukkan unit nama"],
      //[['organization_name'], 'required', 'message' => "Masukkan organization nama"],
      //[['branch'], 'required', 'message' => "Masukkan branch"],
      //[['city'], 'required', 'message' => "Masukkan city"],
      //[['postcode'], 'required', 'message' => "Masukkan postcode"],
      //[['state'], 'required', 'message' => "Masukkan state"],
      [['mobile_no'], 'required', 'message' => "Masukkan mobile No."],
      [['office_phone_no'], 'required', 'message' => "Masukkan office No."],
      [['telegram_id'], 'required', 'message' => "Masukkan telegram id"],
      [['notification'], 'required', 'message' => "Masukkan notification"]
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