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
    
   <div class="row justify-content-center-login">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-body">
                                    <div class="float-left mb-2">
                                    

                                        <div id="success" class="info noticationMsg">
                                        <?php if(Yii::$app->session->hasFlash('notification')):?>

                                            <?php echo Yii::$app->session->getFlash('notification')[0] ?>
                                            <?php endif;?>
                                        </div>

                                    <br>
                                    
                                    

                                    <div id="failed" class="info failedMsg">
                                    <?php if(Yii::$app->session->hasFlash('failed')):
                                        //echo Yii::$app->session->getFlash('failed')[0];exit;
                                        ?>

                                        <?php 
                                        echo Yii::$app->session->getFlash('failed')[0];
                                        ?>
                                        <?php endif;?>

                                    </div>

                                    
                                        <h3 class="text-muted m-t-10 m-b-40">Validation Code</h3>
                                    </div>
                                    <br>
                                    <?php 
                                    //$action = Url::to(['/auth/validation-code']);
                                    $form =  ActiveForm::begin(['action' => '',  'id' => 'otpvalidate', 'method' => 'post','enableClientValidation' => true])
                                    ?>
                                            <div class="input-group validationspace">
                                            <input class="form-control" onclick="this.select()"  name="validationCode[]" id="validation1" type="text" />
                                            <input class="form-control" onclick="this.select()"  name="validationCode[]" id="validation2" type="text" />
                                            <input class="form-control" onclick="this.select()" name="validationCode[]" id="validation3" type="text" />
                                            <input class="form-control" onclick="this.select()" name="validationCode[]" id="validation4" type="text" />
                                            <input class="form-control" onclick="this.select()" name="validationCode[]" id="validation5" type="text" />
                                            <input class="form-control" onclick="this.select()" name="validationCode[]" id="validation6" type="text" />
                                            <input class="form-control" onclick="this.select()" name="email" id="email" value="<?= $email;?>" type="hidden" />
                                            </div>
                                            
                                            <div class="p-3 mb-2 bg-secondary text-white mt-4 ">
                                            <?php if(Yii::$app->session->getFlash('otpDeviceList')):
                                             echo "OTP telah dihantar ke peranti <b>". implode(" and ",Yii::$app->session->getFlash('otpDeviceList'))."</b> berjaya<br>";
                                            endif;
                                            ?> 
                                        Sekiranya anda tidak terima kod, sila klik<br/> <strong>(HANTAR SEMULA)</strong> 
                                    </div>  
                                           <div class="form-group col text-center mt-5">
                                                <input type="submit" value = "Sahkan" id="submit" class="btn btn-primary">
                                                
                                                <span id="resend" class="btn btn-primary">Hantar Semula</span>
                                            </div>
                                            <?php  ActiveForm::end() ?>
                                            
                                            <div id="timer" class="timer">Time left = <span id="timer"></span></div>
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
timer(300);

$('form').submit(function(ev){  
    var isValid = true;
    var otpCode = "";
      $("input[name*='validationCode']").each(function() { 
        otpCode += $(this).val();
            if ($(this).val() == "") { 
                  isValid = false;
                  $("#success").hide();
                  document.getElementById("failed").innerHTML = 'Enter OTP';
            }
      });
      if(isValid)
      { 
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {  
        var jsonResponse = JSON.parse(this.responseText);
        if(jsonResponse.message === "notification"){
          document.location.href = '../dashboard/index';
        }
        else{ 
            document.getElementById("failed").innerHTML = jsonResponse.info;
            document.getElementById("failed").style.color = 'red';
            $('#failed').show();
            $('#success').hide();
            $("#validation1").val("");$("#validation2").val("");$("#validation3").val("");$("#validation4").val("");$("#validation5").val("");$("#validation6").val("");
            return isValid;
        }
      document.getElementById("demo").innerHTML = this.responseText;
    }
  };
  var params = "?email="+$('#email').val()+"&otp="+otpCode;
  xhttp.open("GET", "../auth/validation-code"+params, true);
  
  xhttp.send();
      }
    return false;
});

$("#resend").click(function(){
var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) { 
        var jsonResponse = JSON.parse(this.responseText);
        if(jsonResponse.message === "send"){
            $("#resend").hide();
            timer(300);
            $("#timer").show();
        document.getElementById("success").innerHTML = 'Sila periksa E-mel anda untuk Kod OTP';
        document.getElementById("success").style.color = 'green';
        $('#failed').hide();
        $('#success').show();
        $("#validation1").val("");$("#validation2").val("");$("#validation3").val("");$("#validation4").val("");$("#validation5").val("");$("#validation6").val("");
        }
        else{
            document.getElementById("success").innerHTML = 'OTP Gagal dihantar';
            document.getElementById("success").style.color = 'red';
            $('#failed').show();
            $('#success').hide();
            $("#validation1").val("");$("#validation2").val("");$("#validation3").val("");$("#validation4").val("");$("#validation5").val("");$("#validation6").val("");
        }
      document.getElementById("demo").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "../auth/resend?email="+$('#email').val(), true);
  xhttp.send();
  
});

$("#validation1").on("keyup", function(e){ 
  
if(document.getElementById("validation1").value.match(/^\d+$/)) {
  if($("#validation1").val().length == 1){
    $("#validation2").focus();
  }
  else{
    $('#success').hide();
    $('#failed').html("Masukkan Satu Nombor Sahaja");
    this.select();
    $("#validation1").val("");
  }
}
else{
  $('#success').hide();
  $('#failed').html("Masukkan Nombor Sahaja");
  this.select();$("#validation1").val("");
}
});


$("#validation2").on("keyup", function(e){ 
  if(ShiftTab() === true) { 
    this.select();
    $("#validation1").focus();
}
else if(document.getElementById("validation2").value.match(/^\d+$/)) {
  if($("#validation2").val().length == 1){
    $("#validation3").focus();
  }
  else{ 
    $('#success').hide();
    $('#failed').html("Masukkan Satu Nombor Sahaja");
    this.select();
    $("#validation2").val("");
  }
}
else{
  $('#success').hide();
  $('#failed').html("Masukkan Nombor Sahaja");
  this.select();$("#validation2").val("");
}
});

$("#validation3").on("keyup", function(e){ 
  if(ShiftTab() === true) { 
    this.select();
    $("#validation2").focus();
}
else if(document.getElementById("validation3").value.match(/^\d+$/)) {
  if($("#validation3").val().length == 1){
    $("#validation4").focus();
  }
  else{
    $('#success').hide();
    $('#failed').html("Masukkan Satu Nombor Sahaja");
    this.select();
    $("#validation3").val("");
  }
}
else{
  $('#success').hide();
  $('#failed').html("Masukkan Nombor Sahaja");
  this.select();$("#validation3").val("");
}
});


$("#validation4").on("keyup", function(){ 
  if(ShiftTab() === true) { 
    this.select();
    $("#validation3").focus();
}
else if(document.getElementById("validation4").value.match(/^\d+$/)) {
  if($("#validation4").val().length == 1){
    $("#validation5").focus();
  }
  else{
    $('#success').hide();
    $('#failed').html("Masukkan Satu Nombor Sahaja");
    this.select();
    $("#validation4").val("");
  }
}
else{
  $('#success').hide();
  $('#failed').html("Masukkan Nombor Sahaja");
  this.select();$("#validation4").val("");
}
});

$("#validation5").on("keyup", function(){ 
  if(ShiftTab() === true) { 
    this.select();
    $("#validation4").focus();
}
else if(document.getElementById("validation5").value.match(/^\d+$/)) {
  if($("#validation5").val().length == 1){
    $("#validation6").focus();
  }
  else{
    $('#success').hide();
    $('#failed').html("Masukkan Satu Nombor Sahaja");
    this.select();
    $("#validation5").val("");
  }
}
else{
  $('#success').hide();
  $('#failed').html("Masukkan Nombor Sahaja");
  this.select();$("#validation5").val("");
}
});

$("#validation6").on("keyup", function(){ 
  if(ShiftTab() === true) { 
    this.select();
    $("#validation5").focus();
}
else if(document.getElementById("validation6").value.match(/^\d+$/)) {
  if($("#validation6").val().length == 1){
    $("#validation6").focus();
  }
  else{
    $('#success').hide();
    $('#failed').html("Masukkan Satu Nombor Sahaja");
    this.select();
    $("#validation6").val("");
  }
}
else{
  $('#success').hide();
  $('#failed').html("Masukkan Nombor Sahaja");
  this.select();$("#validation6").val("");
}
});


});
 function isNumberKey(evt)
      { 
        var iKeyCode = (evt.which) ? evt.which : evt.keyCode
        if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
        {
          return false;
        }
         else{
          return true;
         }   

        
      }

      function ShiftTab(evt) {
        var e = event || evt; // for trans-browser compatibility
        var charCode = e.which || e.keyCode; // for trans-browser compatibility

        if (charCode === 9) {
            if (e.shiftKey) {
                $('#controlName').focus();
                return false;
            } else {
                   return true;
              }
       }
      }
JS; $this->registerJs($script, \yii\web\View::POS_END);

?>
