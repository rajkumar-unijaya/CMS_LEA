<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\components\validator\Domaincheck;
use app\components\validator\Reportno;

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
    public $offence_preselected;
    public $report_no;
    public $case_summary;
    public $surat_rasmi;
    public $laporan_polis;
    //public $attachmentURL;
    public $master_social_media_id;
    public $url;
    public $address_line1;
    public $address_line2;
    
    
    


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['for_self'], 'required','message'=>'Pilihan Mengisi'],
            [['selfName'], 'required','message'=>'Masukkan Nama','when' => function ($model) { 
                return ($model->for_self == 78 ? true : false);
            }, 'whenClient' => "function (attribute, value) { 
                return $('[name=\"BlockRequestForm[for_self]\"]').val() == 78;
                }"], 
            
                
            [['email'], 'required','message'=>'Masukkan email','when' => function ($model) { 
                 return ($model->for_self == 78 ? true : false); 
             }, 'whenClient' => "function (attribute, value) {
                return $('#blockrequestform-for_self').val() == 78;
                 }"],
            [['email'],Domaincheck::className()], 

            [['no_telephone'], 'required','message'=>'Masukkan No. telephone','when' => function ($model) { 
                 return ($model->for_self == 78 ? true : false);
             }, 'whenClient' => "function (attribute, value) { 
                return $('#blockrequestform-for_self').val() == 78;
                 }"],
            [['report_no'],Reportno::className()],       
            ['investigation_no','required','message'=>'Masukkan No Kertas Siasatan'],
            [['offence'], 'required','message'=>'Pilih kesalahan'],
            [['case_summary'], 'required','message'=>'Masukkan Ringkasan Kes'],  
            [['surat_rasmi'], 'file','skipOnEmpty' => true,  'extensions' => 'png, jpg,jpeg,pdf','message'=>'valid Surat Rasmi'],
            [['address_line1'], 'required','message'=>'asd1'],  
            [['address_line2'], 'required','message'=>'asd2'],  
            
            
        ];
    }

    public function scenarios() {
        $scenarios = parent::scenarios(); 
        $scenarios['createBlockRequest'] = ['for_self',/*'surat_rasmi','selfName','email','no_telephone',*/'report_no','investigation_no','offence','case_summary'/*,'address_line1','address_line2'*/];
        $scenarios['editBlockRequest'] = ['investigation_no','offence','case_summary'];
        $scenarios['reOpenBlockRequest'] = ['investigation_no','offence','case_summary'];
        return $scenarios;
    
    }
   
}
