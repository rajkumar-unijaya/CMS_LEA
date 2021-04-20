<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\components\validator\DomainCheck;

/**
 * EmailForm is the model behind the login form.
 *
 * @property-read User|null $user This property is read-only.
 *
 */
class BlockRequestForm extends Model
{
    public $for_self;
    public $selfName;
    public $no_telephone;
    public $email;
    public $investigation_no;
    public $offence;
    public $case_summary;
    public $surat_rasmi;
    public $laporan_polis;
    //public $attachmentURL;
    public $master_social_media_id;
    public $url;
    //public $application_purpose;
    
    
    


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['for_self'], 'required','message'=>'Pilih Pilihan Mengisi'],
            
            [['selfName'], 'required','message'=>'Masukkan name','when' => function ($model) { 
                return ($model->for_self == 78 ? true : false); 
            }, 'whenClient' => "function (attribute, value) {
                return $('input[type=\"radio\"][name=\"BlockRequestForm[for_self]\"]:checked').val() == 78;
                }"],
            [['email'], 'required','message'=>'Masukkan email','when' => function ($model) { 
                 return ($model->for_self == 78 ? true : false); 
             }, 'whenClient' => "function (attribute, value) {
                 return $('input[type=\"radio\"][name=\"BlockRequestForm[for_self]\"]:checked').val() == 78;
                 }"],
            [['email'],Domaincheck::className()], 

            [['no_telephone'], 'required','message'=>'Masukkan No. telephone','when' => function ($model) { 
                 return ($model->for_self == 78 ? true : false);
             }, 'whenClient' => "function (attribute, value) {
                 return $('input[type=\"radio\"][name=\"BlockRequestForm[for_self]\"]:checked').val() == 78;
                 }"],    
            [['investigation_no'],'required','message'=>'Masukkan No Kertas Siasatan'],
            [['offence'], 'required','message'=>'Pilih kesalahan'],
            [['case_summary'], 'required','message'=>'Masukkan Ringkasan Kes'],  
            //[['application_purpose'], 'required','message'=>'Pilih Tujuan Permohanan'],
            //[['surat_rasmi'], 'required','message'=>'Pilih Surat Rasmi'],
            [['surat_rasmi'], 'file','skipOnEmpty' => true,  'extensions' => 'png, jpg,jpeg,pdf','message'=>'valid Surat Rasmi'],
            
            
        ];
    }

    public function scenarios() {
        $scenarios = parent::scenarios(); 
        $scenarios['create'] = ['for_self','surat_rasmi','selfName','email','no_telephone','investigation_no','offence','case_summary',/*'master_status_suspect_or_saksi_id',*/'application_purpose'];
        $scenarios['editBlockRequest'] = ['investigation_no','offence','case_summary'];
        $scenarios['reOpenBlockRequest'] = ['investigation_no','offence','case_summary'];
        return $scenarios;
    
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
