<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Url;
//use yii\bootstrap\ActiveForm;
use yii\widgets\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    
   <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">CMS 2.0</h3></div>
                                    <div  id="failed" class="info failedMsg">
                                        <?php //if(Yii::$app->session->hasFlash('failed')):
                                        echo Yii::$app->session->getFlash('failed');
                                        ?>

                                       
                                        <?php //endif; ?>  

                                    </div>
                                    <div class="card-body">
                                    
                                    <div class="float-left mb-2">
                                   
                                        
                                   
                                        <h4>Log In - LEA</h4>
                                    </div>
                                    <?php 
                                    $action = Url::to(['/auth/login']);
                                    $form =  ActiveForm::begin(['action' => $action, 'method' => 'post','id' => 'emailForm','enableClientValidation' => true])
                                    ?>
                                    <input id="model-field" name="EmailForm[type]" type="hidden" value="1">
                                        <div class="form-group"><?= $form->field($model, 'email')->label(false)->textInput(['id' => 'email','placeholder' => "Enter Your Email"]) ?>
                                        <!--<div class="input-group input-group-md">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                            </div>
                                            <input type="email" class="form-control" placeholder="E-mail address">
                                        </div>-->
                                        </div>
                                        
                                        

                                           <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0 float-right">
                                           <?= Html::submitButton('Seterusnya', ['class' => 'btn btn-primary']) ?>
                                                
                                            </div>
                                            <?php  ActiveForm::end() ?>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>    
</div>
<?php
$script = <<< JS
$(document).ready(function() {
    var valid = true;
    $('form').submit(function(ev){ 
        if($("#email").val() == "" || $("#email").val().length == 0)
        { 
            $("#failed").hide();
            $(".help-block").html('Enter your email address');
            valid = false;
            return valid;
        }
        else if(validateEmail($("#email").val()) === false)
        { 
            $("#failed").hide();
            $(".help-block").html('Enter valid email address');
            valid = false;
            return valid;
        }
        else{
            valid = true;
            return valid;   
        }
    return valid;
});
    
  
});
function validateEmail(email) {
  return email.endsWith('.gov.my');
}
JS; $this->registerJs($script, \yii\web\View::POS_END);

?>
