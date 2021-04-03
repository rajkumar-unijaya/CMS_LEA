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
class PermohonanForm extends Model
{
    public $masterCaseInfoTypeId;
    public $for_self;
    public $no_telephone;
    public $selfName;
    public $email;
    public $report_no;
    public $investigation_no;
    public $offence;
    public $case_summary;
    public $master_status_suspect_or_saksi_id;
    public $master_status_status_suspek_id;
    public $ic;
    public $name;
    public $master_status_status_suspek_id_0;
    public $master_status_status_suspek_id_1;
    public $master_status_status_suspek_id_2;
    public $master_status_status_suspek_id_3;
    
    public $suspect_ic;
    public $surat_rasmi;
    public $laporan_polis;
    public $attachmentURL;
    public $master_social_media_id;
    public $url;
    public $application_purpose;
    public $application_purpose_info;
    

    
    
    


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
                return $('input[type=\"radio\"][name=\"PermohonanForm[for_self]\"]:checked').val() == 78;
                }"],
            [['email'], 'required','message'=>'Masukkan email','when' => function ($model) { 
                 return ($model->for_self == 78 ? true : false); 
             }, 'whenClient' => "function (attribute, value) {
                 return $('input[type=\"radio\"][name=\"PermohonanForm[for_self]\"]:checked').val() == 78;
                 }"],
            [['email'],'domainCheck'],     
            [['no_telephone'], 'required','message'=>'Masukkan No. telephone','when' => function ($model) { 
                 return ($model->for_self == 78 ? true : false);
             }, 'whenClient' => "function (attribute, value) {
                 return $('input[type=\"radio\"][name=\"PermohonanForm[for_self]\"]:checked').val() == 78;
                 }"],     
             [['report_no'], 'required','message'=>'Masukkan No Laporan Polis atau No Kertas Siasatan',
                 'when' => function($model) { return empty($model->investigation_no); }
               ],
             [['investigation_no'],'required','message'=>'Masukkan No Laporan Polis atau No Kertas Siasatan',
                 'when' => function($model) { return empty($model->report_no); }
               ],
             [['offence'], 'required','message'=>'Pilih kesalahan'],
             [['case_summary'], 'required','message'=>'Masukkan Ringkasan Kes'],  
             [['master_status_suspect_or_saksi_id'], 'required','message'=>'Pilih Status Suspek'],
             [['master_status_suspect_or_saksi_id'], 'required','message'=>'Pilih Status Suspek Option'],
             [['application_purpose'], 'required','message'=>'Pilih Tujuan Permohanan'],
             /*[['application_purpose_info'], 'required','message'=>'Masukkan Tujuan Permohanaddfdfn','when' => function ($model) { 
                 if($this->application_purpose[0] == 24 && empty($this->application_purpose_info))
                 {
                     return true;
                 }
                 
             }],*/
             [['surat_rasmi'], 'file','skipOnEmpty' => true, 'extensions' => 'png,jpg,jpeg,pdf','message'=>'valid Surat Rasmi'],
             //[['url'], 'anyOneURLRequired'],
             //['url','in', 'range' => [0], 'message'=>'Masukkan URL'] 
             //[['url'], 'each', 'rule' => ['string'],'message'=>'Masukkan URL'] 
        ];
    }

    public function scenarios() {
        $scenarios = parent::scenarios(); 
        $scenarios['create'] = ['for_self','selfName','email','no_telephone','report_no','investigation_no','offence','case_summary','master_status_suspect_or_saksi_id','application_purpose'];
        //$scenarios['edit'] = ['report_no','investigation_no','offence','case_summary','master_status_suspect_or_saksi_id','application_purpose'];
        $scenarios['edit'] = ['report_no','investigation_no','offence','case_summary','application_purpose'];
        $scenarios['reopen'] = ['offence','case_summary','master_status_suspect_or_saksi_id','application_purpose'];
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

   public function anyOneURLRequired($attribute, $params){ 
        $i = 0;
       foreach($this->url as $key =>$val)
       { 
           if(!empty($val))
           { 
               $i++;
           }
       }
       if($i == 0)
       {
        $this->addError($attribute,"Masukkan URL");
       }
    
}



}
