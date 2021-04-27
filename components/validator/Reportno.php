<?php 
namespace app\components\validator;

use yii\validators\Validator;


class Reportno extends Validator
{
    public function init()
    {
        parent::init();
        $this->message = 'Invalid Report No.';
    }

    public function validateAttribute($model, $attribute)
    {
        return <<<JS
        deferred.push($.get("/check", {value: value}).done(function(data) {
            if ('' !== data) {
                messages.push(data);
            }
        }));
JS;
    }

    public function clientValidateAttribute($model, $attribute, $view)
    {
        return <<<JS
        deferred.push($.post("/permohonan/checkloporanno", {laporan_police: value}).done(function(data) { 
            if (data.strlength > 0 && 'success' == data.message) {
                messages.push(data.result);
            }
            return true;
        }));
JS;
    }
}
?>
