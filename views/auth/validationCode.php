<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;


$this->title = 'Validation Code';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    
   <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-body">
                                    <div class="float-left mb-2">
                                    <?php if(Yii::$app->session->hasFlash('notification')):?>

                                        <div class="info noticationMsg">

                                            <?php echo Yii::$app->session->getFlash('notification')[0] ?>

                                        </div>

                                    <?php endif;?>
                                    <?php if(Yii::$app->session->hasFlash('failed')):
                                        //echo Yii::$app->session->getFlash('failed')[0];exit;
                                        ?>

                                    <div class="info failedMsg">

                                        <?php 
                                        echo Yii::$app->session->getFlash('failed')[0];
                                        ?>

                                    </div>

                                    <?php endif; ?>
                                    <?php if(Yii::$app->session->hasFlash('fillOTP')):
                                        //echo Yii::$app->session->getFlash('failed')[0];exit;
                                        ?>

                                    <div class="info failedMsg">

                                        <?php 
                                        echo Yii::$app->session->getFlash('fillOTP')[0];
                                        ?>

                                    </div>

                                    <?php endif; ?>

                                    <div id="success" class="info noticationMsg">

                                            

                                        </div>
                                    
                                        <h3>Validation Code</h3>
                                    </div>
                                    
                                    <?php 
                                    $action = Url::to(['/auth/validation-code']);
                                    $form =  ActiveForm::begin(['action' => $action,'options' => ['onsubmit' => 'validateForm()'],  'id' => 'otpvalidate', 'method' => 'post','enableClientValidation' => true])
                                    ?>
                                            <div class="input-group validationspace">
                                            <span class="input-group-addon">
                                                <i class="glyphicon glyphicon-envelope"></i> 
                                            </span>
                                            <input class="form-control"  name="validationCode[]" id="validation1" type="text" />
                                            <input class="form-control"  name="validationCode[]" id="validation2" type="text" />
                                            <input class="form-control" name="validationCode[]" id="validation3" type="text" />
                                            <input class="form-control" name="validationCode[]" id="validation4" type="text" />
                                            <input class="form-control" name="validationCode[]" id="validation5" type="text" />
                                            <input class="form-control" name="validationCode[]" id="validation6" type="text" />
                                            <input class="form-control" name="email" id="email" value="<?= $email;?>" type="hidden" />
                                            </div>
                                            
                                            <div class="p-3 mb-2 bg-secondary text-white mt-4 ">  
             Sekiranya anda tidak terima kod, sila kik<br/> <strong>(HANTAR SEMULA)</strong> 
        </div>  
                                           <div class="form-group col text-center mt-5">
                                                <input type="submit" value = "Sahkan" id="submit" class="btn btn-primary">
                                                
                                                <div id="resend" class="btn btn-primary">Resend</div>
                                            </div>
                                            <?php  ActiveForm::end() ?>
                                            
                                            <div id="timer">Time left = <span id="timer"></span></div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>    
</div>
<?php
$script = <<< JS
 $(document).ready(function() {
    let timerOn = true;
    $("#resend").hide();

function timer(remaining) {
  var m = Math.floor(remaining / 60);
  var s = remaining % 60;
  
  m = m < 10 ? '0' + m : m;
  s = s < 10 ? '0' + s : s;
  document.getElementById('timer').innerHTML = m + ':' + s;
  remaining -= 1;
  
  if(remaining >= 0 && timerOn) {
    setTimeout(function() {
        timer(remaining);
    }, 1000);
    return;
  }

  if(!timerOn) {
    // Do validate stuff here
    return;
  }

  $("#resend").show();
  $("#timer").hide();
}
timer(10);

$('#otpvalidate').submit(function(ev){ 
    var isValid = true;
      $("input[name*='validationCode']").each(function() {
            if ($(this).val() == "") {
                  isValid = false;
                  document.getElementById("success").innerHTML = 'Please fill OTP';
                  document.getElementById("success").style.color = 'red';
                  
            }
      });
    return isValid;
});

$("#resend").click(function(){
var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) { 
        var jsonResponse = JSON.parse(this.responseText);
        if(jsonResponse.message === "send"){
            $("#resend").hide();
            timer(10);
            $("#timer").show();
        document.getElementById("success").innerHTML = 'Please check your email for OTP';
        document.getElementById("success").style.color = 'green';
        }
        else{
            document.getElementById("success").innerHTML = 'OTP send failed';
            document.getElementById("success").style.color = 'red';
        }
      document.getElementById("demo").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "index.php?r=auth/resend&email="+$('#email').val(), true);
  xhttp.send();
  
});

$("#validation1").on("keypress", function(){ 
    
  if($("#validation1").val().length == 0){
    $("#validation2").focus();
}
});
$("#validation2").on("keypress", function(){ 
  if($("#validation2").val().length == 0){
    $("#validation3").focus();
  }
});
$("#validation3").on("keypress", function(){ 
  if($("#validation3").val().length == 0){
    $("#validation4").focus();
  }
});
$("#validation4").on("keypress", function(){ 
  if($("#validation4").val().length == 0){
    $("#validation5").focus();
  }
});
$("#validation5").on("keypress", function(){ 
  if($("#validation5").val().length == 0){
    $("#validation6").focus();
  }
});

 });
 function isNumberKey(evt)
      { 
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
JS; $this->registerJs($script, \yii\web\View::POS_END);

?>
