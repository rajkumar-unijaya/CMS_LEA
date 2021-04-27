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
class PermohonanStatusSuspekSaksi extends Model
{
    public $id;
    public $master_status_suspect_or_saksi_id;
    public $master_status_status_suspek_id;
    public $ic;
    public $name;
    public $others;
    
   /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            
        ];
    }

    

}
