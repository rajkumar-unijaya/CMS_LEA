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
class PermohonanMNTLForm extends Model
{
    public $masterCaseInfoTypeId;
    public $for_self;
    public $selfName;
    public $no_telephone;
    public $email;
    public $report_no;
    public $investigation_no;
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
            [['selfName'], 'required','message'=>'Masukkan name','when' => function ($model) { 
                return ($model->for_self == 78 ? true : false); 
            }, 'whenClient' => "function (attribute, value) {
                return $('input[type=\"radio\"][name=\"PermohonanMNTLForm[for_self]\"]:checked').val() == 78;
                }"],
            [['email'], 'required','message'=>'Masukkan email','when' => function ($model) { 
                 return ($model->for_self == 78 ? true : false); 
             }, 'whenClient' => "function (attribute, value) {
                 return $('input[type=\"radio\"][name=\"PermohonanMNTLForm[for_self]\"]:checked').val() == 78;
                 }"],
            [['email'],Domaincheck::className()],
            [['no_telephone'], 'required','message'=>'Masukkan No. telephone','when' => function ($model) { 
                 return ($model->for_self == 78 ? true : false);
             }, 'whenClient' => "function (attribute, value) {
                 return $('input[type=\"radio\"][name=\"PermohonanForm[for_self]\"]:checked').val() == 78;
                 }"],    
            [['report_no'],Reportno::className()],      
            [['investigation_no'],'required','message'=>'Masukkan No. Kertas Siasatan',
                 'when' => function($model) { return empty($model->report_no); }, 'whenClient' => "function (attribute, value) {
                    return $('#permohonanform-report_no').val().length == 0;
                    }"
               ],
            [['phone_number'], 'required','message'=>'Masukkan Phone No.'],  
             
            
            
        ];
    }

    public function scenarios() {
        $scenarios = parent::scenarios(); 
        $scenarios['create'] = ['for_self','selfName','email','no_telephone','report_no','investigation_no'];
        return $scenarios;
    
    }
}
