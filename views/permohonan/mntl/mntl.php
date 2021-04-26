<?php

/* @var $this yii\web\View */

namespace app\widgets;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use Yii;
use yii\jui\DatePicker; //echo"<pre>";print_r($phone_telco);exit;
?>

<div class="container-fluid">
    <h1 style="padding-top: 1.5rem;">Permohonan Baru MNTL</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Laman Utama</a></li>
            <li class="breadcrumb-item"><a href="../crawler/mntl-list">Permohonan Baru MNTL</a></li>
            
        </ol>
    </nav>
    <div class="card-body">
                                    <div  id="failed" class="info failedMsg">
                                        <?php if(Yii::$app->session->hasFlash('failed')):
                                         echo Yii::$app->session->getFlash('failed')[0];
                                        ?>
                                        <?php endif; ?>  
                                    </div>
        <div class="row">
       
            <div class="col-lg-5">

           <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
           <?= $form->field($model, 'masterCaseInfoTypeId')->hiddenInput(['value' => $masterCaseInfoTypeId])->label(false); ?>
           <div class="row mb-3">
              <label for="inputEmail3" class="col-sm-4 col-form-label">Pilihan Mengisi</label>
              <div class="col-sm-8">
                    <?= $form->field($model, 'for_self')->radioList($newCase,array('class'=>'for_self'))->label(false); ?>
                    <div id="choose_forself">
                    <?= $form->field($model, 'email')->textInput(['placeholder' => 'E-mel'])
                                    ->label(false) ?>
                    <div class="help-block-email" id="invalid_email"></div>
                    <?= $form->field($model, 'no_telephone')->textInput(['placeholder' => 'No. Telefon'])
                                    ->label(false) ?>                
                    </div> 
              </div>
           </div>


           <div class="row mb-3">
                <label for="inputPassword3" class="col-sm-4 col-form-label">No. Laporan Polis </label>
                <div class="col-sm-8">
                <?= $form->field($model, 'report_no')->textInput(['placeholder' => 'No. Laporan Polis'])->label(false) ?>   
                </div>
            </div>

            <div class="row mb-3">
                <label for="inputPassword3" class="col-sm-4 col-form-label">No. Kertas Siasatan </label>
                <div class="col-sm-8">
                <?= $form->field($model, 'investigation_no')->textInput(['placeholder' => 'No. Kertas Siasatan'])->label(false) ?> 
                </div>
            </div>

            
           <div class="row mb-3">
                <label for="inputPassword3" class="col-sm-4 col-form-label">No. Telefon </label>
                <div class="col-sm-8">
                <?php  if(isset($phone_telco['phone_no']) && !empty($phone_telco['phone_no'])){$model->phone_number = $phone_telco['phone_no']; }?>
                <?= $form->field($model, 'phone_number')->textInput(['placeholder' => 'No. Telefon'])->label(false) ?>   
                </div>
            </div>

            <div class="row mb-3">
                <label for="inputPassword3" class="col-sm-4 col-form-label">Nama Telco</label>
                <div class="col-sm-8">
                <?php  if(isset($phone_telco['telco']) && !empty($phone_telco['telco'])){$model->telco_name = $phone_telco['telco'];} ?>
                <?= $form->field($model, 'telco_name')->textInput(['placeholder' => 'Nama Telco','readonly'=> true])->label(false) ?>   
                </div>
            </div>

            <div class="row mb-3">
                <label for="inputPassword3" class="col-sm-4 col-form-label">Tarikh daripada</label>
                <div class="col-sm-8">
                <?=  $form->field($model, 'date1',['inputOptions' => [
'autocomplete' => 'off']])->widget(\yii\jui\DatePicker::className(),
                                                    [ 'dateFormat' => 'php:m/d/Y',
                                                    'clientOptions' => [
                                                        'changeYear' => true,
                                                        'changeMonth' => true,
                                                        //'yearRange' => '-50:-12',
                                                        'altFormat' => 'yy-mm-dd',
                                                    ]],['placeholder' => 'mm/dd/yyyy'])
                                                    ->textInput(['placeholder' => 'mm/dd/yyyy'])->label(false) ?>
                <?php //= $form->field($model, 'date1')->textInput(['placeholder' => 'mm/dd/yyyy'])->label(false) ?> 
                </div>
            </div>


            <div class="row mb-3">
                <label for="inputPassword3" class="col-sm-4 col-form-label">Tarikh sehingga  </label>
                <div class="col-sm-8">
                <?=  $form->field($model, 'date2',['inputOptions' => [
'autocomplete' => 'off']])->widget(\yii\jui\DatePicker::className(),
                                                    [ 'dateFormat' => 'php:m/d/Y',
                                                    'clientOptions' => [
                                                        'changeYear' => true,
                                                        'changeMonth' => true,
                                                        //'yearRange' => '-50:-12',
                                                        'altFormat' => 'yy-mm-dd',
                                                    ]],['placeholder' => 'mm/dd/yyyy'])
                                                    ->textInput(['placeholder' => 'mm/dd/yyyy'])->label(false) ?>
                <?php //= $form->field($model, 'date2')->textInput(['placeholder' => 'mm/dd/yyyy'])->label(false) ?>                                     
                </div>
            </div>
            
            <div class="form-group cl-md-4">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>
           
        </div>


    
    

    <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS
$(document).ready(function() {
  $("#choose_forself").hide();
  $("#application_purpose_info").hide();
  $("input[name='PermohonanMNTLForm[for_self]']").change(function() {  //alert("ramstest = "+$("input[name='PermohonanMNTLForm[for_self]']:checked").val());
     if (this.value == 78) {
      $("#choose_forself").show();
    }
    else if (this.value == 79) {
      $("#choose_forself").hide();
    }
});

$("#permohonanmntlform-phone_number").keyup(function(event) {
    if($("#permohonanmntlform-phone_number").val().length >= 9 && $("#permohonanmntlform-phone_number").val().length <= 12)
    {
            event.preventDefault(); // stopping submitting
            $.ajax({
                url: $(location).attr('href'),
                type: 'post',
                dataType: 'json',
                data: {'phone_number' : $("#permohonanmntlform-phone_number").val()}
            })
            .done(function(response) { 
                if (response.success == "success") {
                 $("#permohonanmntlform-telco_name").val(response.telco);   
                 } 
                 else{
                    $("#date_registered").text('No records found');   
                    
                 }
                 
            })
            .fail(function() {
                console.log("error");
            });
    }
    else{
        $("#permohonanmntlform-telco_name").val(""); 
    }
       
        
        });


$('#add').click(function(){ var newID =  ( $('#url_input_append > div').length);
if(newID <= 15)
{
  $('#url_input_append').append('<div class="row"><div class="form-group field-PermohonanMNTLForm-master_social_media_id"><select id="PermohonanMNTLForm-master_social_media_id['+newID+']" class="form-control" name="PermohonanMNTLForm[master_social_media_id]['+newID+']"><option value="">--Pilih Social Media--</option><option value="1">twitter</option><option value="2">instagram</option><option value="3">tumblr</option><option value="4">facebook</option><option value="5">blog / website</option></select><div class="help-block"></div></div><div class="form-group field-PermohonanMNTLForm-url-'+newID+'"><input type="text" id="PermohonanMNTLForm-url-'+newID+'" class="form-control" name="PermohonanMNTLForm[url]['+newID+']"><div class="help-block"></div></div></div>');
}
else{
  alert("Can't create new field");
  return false;
}
  
});


$("input:checkbox[name='PermohonanMNTLForm[application_purpose][]']").click(function(){ 
        if (this.checked && $(this).val() == 24) { 
          $("#application_purpose_info").show();
        } else if(!this.checked && $(this).val() == 24) { 
          $("#application_purpose_info").hide();
        }
   });


    var valid = true;

   

});
JS; $this->registerJs($script, \yii\web\View::POS_END);

?>
