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
class PermohonanMNTLForm extends Model
{
    public $masterCaseInfoTypeId;
    public $for_self;
    public $no_telephone;
    public $email;
    public $report_no;
    public $investigation_no;
    public $tippoff_id;
    public $phone_number;
    public $telco_name;
    public $date1;
    public $date2;
    
    
    
    


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['for_self'], 'required','message'=>'Pilih Pilihan Mengisi'],
            
           [['email'], 'required','message'=>'Masukkan email','when' => function ($model) { 
                return ($model->for_self == 6 ? true : false); 
            }, 'whenClient' => "function (attribute, value) {
                return $('input[type=\"radio\"][name=\"PermohonanMNTLForm[for_self]\"]:checked').val() == 6;
                }"],
           [['email'],'domainCheck'], 
           [['no_telephone'], 'required','message'=>'Masukkan No. telephone','when' => function ($model) { 
                return ($model->for_self == 6 ? true : false);
            }, 'whenClient' => "function (attribute, value) {
                return $('input[type=\"radio\"][name=\"PermohonanMNTLForm[for_self]\"]:checked').val() == 6;
                }"],     
            [['report_no'], 'required','message'=>'Masukkan No Laporan Polis atau No Kertas Siasatan',
                'when' => function($model) { return empty($model->investigation_no); }
              ],
            [['investigation_no'],'required','message'=>'Masukkan No Laporan Polis atau No Kertas Siasatan',
                'when' => function($model) { return empty($model->report_no); }
              ],


            [['tippoff_id'], 'required','message'=>'Pilih No. TippOff'],
            [['phone_number'], 'required','message'=>'Masukkan Phone No.'],  
            [['telco_name'], 'required','message'=>'Pilih telco name'],
            [['date1'], 'required','message'=>'Pilih date1'],
            [['date2'], 'required','message'=>'Pilih date2'],
            
            
            
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
