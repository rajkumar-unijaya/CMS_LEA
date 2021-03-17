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
class BlockRequestForm extends Model
{
    public $for_self;
    public $no_telephone;
    public $email;
    public $report_no;
    public $investigation_no;
    public $offence;
    public $case_summary;
    public $surat_rasmi;
    public $laporan_polis;
    public $master_social_media_id;
    public $url;
    public $application_purpose;
    
    
    


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
                return $('input[type=\"radio\"][name=\"BlockRequestForm[for_self]\"]:checked').val() == 6;
                }"],
           [['email'],'domainCheck'],      
           [['no_telephone'], 'required','message'=>'Masukkan No. telephone','when' => function ($model) { 
                return ($model->for_self == 6 ? true : false);
            }, 'whenClient' => "function (attribute, value) {
                return $('input[type=\"radio\"][name=\"BlockRequestForm[for_self]\"]:checked').val() == 6;
                }"],     
            [['report_no'], 'required','message'=>'Masukkan No Laporan Polis atau No Kertas Siasatan',
                'when' => function($model) { return empty($model->investigation_no); }
              ],
            [['investigation_no'],'required','message'=>'Masukkan No Laporan Polis atau No Kertas Siasatan',
                'when' => function($model) { return empty($model->report_no); }
              ],
            [['offence'], 'required','message'=>'Pilih kesalahan'],
            [['case_summary'], 'required','message'=>'Masukkan Ringkasan Kes'],  
            [['application_purpose'], 'required','message'=>'Pilih Tujuan Permohanan'],
            //[['surat_rasmi'], 'required','message'=>'Pilih Surat Rasmi'],
            [['surat_rasmi'], 'file',  'extensions' => 'png, jpg,jpeg,pdf','message'=>'valid Surat Rasmi'],
            
            
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
