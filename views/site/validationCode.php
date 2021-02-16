<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Validation Code';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    
   <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-body">
                                    <div class="float-left mb-2">
                                        <h3>Validation Code</h3>
                                    </div>
                                        <form>
                                            <div class="input-group validationspace">
                                            <span class="input-group-addon">
                                                <i class="glyphicon glyphicon-envelope"></i> 
                                            </span>
                                            <input class="form-control" name="validationCode[]" id="validation" type="text" />
                                            <input class="form-control" name="validationCode[]" id="validation" type="text" />
                                            <input class="form-control" name="validationCode[]" id="validation" type="text" />
                                            <input class="form-control" name="validationCode[]" id="validation" type="text" />
                                            <input class="form-control" name="validationCode[]" id="validation" type="text" />
                                            <input class="form-control" name="validationCode[]" id="validation" type="text" />
                                            </div>
                                            <div class="p-3 mb-2 bg-secondary text-white mt-4 ">  
             Sekiranya anda tidak terima kod, sila kik<br/> <strong>(HANTAR SEMULA)</strong> 
        </div>  
                                           <div class="form-group col text-center mt-5">
                                                <button class="btn btn-primary">Sahkan</button>
                                            </div>
                                        </form>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>    
</div>
