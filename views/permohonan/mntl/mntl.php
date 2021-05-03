<?php

/* @var $this yii\web\View */

namespace app\widgets;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use Yii;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\jui\DatePicker;
?>

<div class="container-fluid">
    <h3 style="padding-top: 1.5rem;">Permohonan Baru MNTL</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Laman Utama</a></li>
            <li class="breadcrumb-item"><a href="../permohonan/mntl-list">Senarai MNTL</a></li>
            <li class="breadcrumb-item active">Permohonan Baru MNTL</li>
            
        </ol>
    </nav>
    <div class="card card-outline-info">
           <div class="card-body">
                                    <div  id="failed" class="info failedMsg">
                                        <?php if(Yii::$app->session->hasFlash('failed')):
                                         echo Yii::$app->session->getFlash('failed')[0];
                                        ?>
                                        <?php endif; ?>  
                                    </div>
        <div class="row">
        <div class="col-lg-12">

           <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
           
<h5 class="m-t-20" style="color:#337ab7" >Maklumat Permohonan Penyekatan</h5>
<hr>
          <div class="row">
						<div class="col-md-6">
							  <div class="form-group">
								    <label>Pilihan Mengisi <span class="text-danger">*</span></label>
                                    <?= $form->field($model, 'masterCaseInfoTypeId')->hiddenInput(['value' => $masterCaseInfoTypeId])->label(false); ?>
                    <?= $form->field($model, 'for_self')->dropDownList($newCase,array('prompt' => 'Pilih Pilihan'))->label(false);?>
							  </div>
						  </div>
              </div>
      <!--/name-->
      <br>
      
                      
                      
      <div id="choose_forself">
          <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                      <label class="control-label">Nama<span class="text-danger">*</span></label>
                      <div class="controls">
                      <?= $form->field($model, 'selfName')->textInput(['class' => 'form-control','placeholder' => 'Nama'])->label(false); ?>
                      </div>
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                      <label class="control-label">E-mel<span class="text-danger">*</span></label>
                      <div class="controls">
                      <?= $form->field($model, 'email')->textInput(['class' => 'form-control','placeholder' => 'E-mel'])->label(false); ?>
                      </div>
                  </div>
              </div>
              <!--/phone number-->
              </br>
              <div class="col-md-6">
                  <div class="form-group">
                      <label class="control-label">No. Telefon <span class="text-danger">*</span></label>
                      <div class="controls">
                      <?= $form->field($model, 'no_telephone')->textInput(['class' => 'form-control','placeholder' => 'No. Telefon'])->label(false); ?> 
                      </div>
                  </div>
              </div>
            </div> 
        </div>      
    <br>
           <div class="row">
              <div class="col-md-6">
                  <label>No. Laporan Polis</label>
                  <?= $form->field($model, 'report_no')->textInput(['placeholder' => 'No. Laporan Polis'])->label(false) ?>   
                     
          </div>

            <div class="col-md-6">
                <label>No. Kertas Siasatan<span class="text-danger">*</span> </label>
                <?= $form->field($model, 'investigation_no')->textInput(['placeholder' => 'No. Kertas Siasatan'])->label(false) ?> 
            </div>
            </div>
       <!--/span-->

       <br>

       <div class="row">
              <div class="col-md-6">
                  <label>No. Telefon <span class="text-danger">*</span> </label>
                  <?php  if(isset($phone_telco['phone_no']) && !empty($phone_telco['phone_no'])){$model->phone_number = $phone_telco['phone_no']; }?>
                <?= $form->field($model, 'phone_number')->textInput(['placeholder' => 'No. Telefon'])->label(false) ?>   
          </div>

            <div class="col-md-6">
                <label>Nama Telco<span class="text-danger">*</span> </label>
                <?php  if(isset($phone_telco['telco']) && !empty($phone_telco['telco'])){$model->telco_name = $phone_telco['telco'];} ?>
                <?= $form->field($model, 'telco_name')->textInput(['placeholder' => 'Nama Telco','readonly'=> true])->label(false) ?>   
            </div>
            </div>
       <!--/span-->

       <br>

       <div class="row">
              <div class="col-md-6">
                  <label>Tarikh daripada</label>
                  <?=  $form->field($model, 'date1',['inputOptions' => [
                                                    'form' => 'form-control',
                                                    'autocomplete' => 'off']])->widget(\yii\jui\DatePicker::className(),
                                                    [ 'dateFormat' => 'php:m/d/Y',
                                                    'clientOptions' => [
                                                        'changeYear' => true,
                                                        'changeMonth' => true,
                                                        //'yearRange' => '-50:-12',
                                                        'altFormat' => 'yy-mm-dd',
                                                    ]],['placeholder' => 'mm/dd/yyyy'])
                                                    ->textInput(['placeholder' => 'mm/dd/yyyy'])->label(false) ?>  
          </div>

            <div class="col-md-6">
                <label>Tarikh sehingga</label>
                <?=  $form->field($model, 'date2',['inputOptions' => [
                                                    'form' => 'form-control',
                                                    'autocomplete' => 'off']])->widget(\yii\jui\DatePicker::className(),
                                                    [ 'dateFormat' => 'php:m/d/Y',
                                                    'clientOptions' => [
                                                        'changeYear' => true,
                                                        'changeMonth' => true,
                                                        //'yearRange' => '-50:-12',
                                                        'altFormat' => 'yy-mm-dd',
                                                    ]],['placeholder' => 'mm/dd/yyyy'])
                                                    ->textInput(['placeholder' => 'mm/dd/yyyy'])->label(false) ?>  
            </div>
            </div>
       <!--/span-->

       <br>

  
<div class="row">
  <div class="col-md-12 col-12">
      <div class="text-right">
          <?= Html::submitButton('Hantar', ['class' => 'btn  waves-effect-light btn-info btn-sm btnSave']) ?>
              <a href="../permohonan/mntl-list"
                  class="btn waves-effect-light btn-danger btn-sm" data-toggle="tooltip"
                  data-placement="left" title=""
                  data-original-title="Click to cancel and back to the main page"><i
                      class="ti-close"></i>
                  Batal</a>
              
      </div>
  </div>
</div>

    <?php ActiveForm::end(); ?>
            </div>
          </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS
$(document).ready(function() {
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
  var pausecontent=new Array();
  $("#choose_forself").hide();
  $('#permohonanmntlform-for_self').change(function() { 
    if (this.value == 78) {
      $("#choose_forself").show();
    }
    else if (this.value == 79) {
      $("#choose_forself").hide();
    }
});
    var valid = true;

});
JS; $this->registerJs($script, \yii\web\View::POS_END);

?>
