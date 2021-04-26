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
class PermohonanUrl extends Model
{
    public $id;
    public $master_social_media_id;
    public $url;
    
   /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            
        ];
    }

    

}
