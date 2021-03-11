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
    public $for_self;
    public $no_telephone;
    public $email;
    public $report_no;
    public $investigation_no;
    public $offence;
    public $case_summary;
    public $master_suspect_id;
    public $ic;
    public $name;
    public $suspect_ic;
    public $surat_rasmi;
    public $laporan_polis;
    public $url;
    public $application_purpose;
    
    


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['for_self'], 'required','message'=>'Pilih Pilihan Mengisi'],
            [['master_suspect_id'], 'required','message'=>'Pilih Status Suspek'],
            [['application_purpose'], 'required','message'=>'Pilih Tujuan Permohanan'],
            [['report_no'], 'required','message'=>'Masukkan No Laporan Polis atau No Kertas Siasatan',
                'when' => function($model) { return empty($model->investigation_no); }
              ],
            [['investigation_no'],'required','message'=>'Masukkan No Laporan Polis atau No Kertas Siasatan',
                'when' => function($model) { return empty($model->report_no); }
              ],
            [['email'], 'required','message'=>'Masukkan email','when' => function ($model) { 
                return $model->for_self == 6; 
            }, 'whenClient' => "function (attribute, value) {
        return $('input[name='PermohonanForm[for_self]']:checked').val() == 1;
    }"],
            [['no_telephone'], 'required','message'=>'Masukkan No. telephone','when' => function ($model) { 
                return $model->for_self == 6; 
            }],
            [['offence'], 'required','message'=>'Pilih kesalahan'],
            [['case_summary'], 'required','message'=>'Masukkan Ringkasan Kes'],
            [['surat_rasmi'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg,jpeg,pdf','message'=>'valid Surat Rasmi'],
            
        ];
    }
}
