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
<!-- ============================================================== -->
		<!-- Bread crumb and right sidebar toggle -->
		<!-- ============================================================== -->
		<div class="row page-titles">
			<div class="col-lg-12 col-8 align-self-center">
				<h1 class="text-themecolor" style="padding-top: 2rem;">Permohonan Penyekatan</h1>
        <nav aria-label="breadcrumb">
				<ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="../dashboard/index">Laman Utama</a></li>
					<li class="breadcrumb-item"><a href="../permohonan/block-request-list">Permohonan Penyekatan</a></li>
					<li class="breadcrumb-item active">Permohonan Penyekatan Baru</li>
				</ol>
        </nav>
			</div>
		</div>

   <!-- <h1 style="padding-top: 1.5rem;">Permintaan Sekatan</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../permohonan/block-request-list">Laman Utama</a></li>
            <li class="breadcrumb-item active" aria-current="page">Permintaan Sekatan</li>
            
        </ol>
    </nav>-->

    <div class="row">
			<div class="col-lg-12">
				

    <div class="card-body">
                                    <div  id="failed" class="info failedMsg">
                                        <?php if(Yii::$app->session->hasFlash('failed')):
                                         echo Yii::$app->session->getFlash('failed')[0];
                                        ?>
                                        <?php endif; ?>  
                                    </div>
       
  <div class="form-body">
<h4 class="m-t-20" style="color:#337ab7" >Maklumat Permohonan Penyekatan</h4>
<hr>
<?php $form = ActiveForm::begin(); ?>
           <?= $form->field($model, 'masterCaseInfoTypeId')->hiddenInput(['value' => $masterCaseInfoTypeId])->label(false); ?>
           
          <div class="row">
						<div class="col-md-6">
							  <div class="form-group">
								    <label>Pilihan Mengisi <span class="text-danger">*</span></label>
								      <?= $form->field($model, 'for_self')->dropDownList($newCase,array('prompt' => 'Pilih Pilihan'))->label(false);?>
							  </div>
						  </div>
              </div>
      <!--/span-->
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
              <!--<div class="col-md-6">
                  <div class="form-group">
                      <label class="control-label">E-mel<span class="text-danger">*</span></label>
                      <div class="controls">
                      <?= $form->field($model, 'email')->textInput(['class' => 'form-control','placeholder' => 'E-mel'])->label(false); ?>
                      </div>
                  </div>
              </div>
              </br>
              <div class="col-md-6">
                  <div class="form-group">
                      <label class="control-label">No. Telefon <span class="text-danger">*</span></label>
                      <div class="controls">
                      <?= $form->field($model, 'no_telephone')->textInput(['class' => 'form-control','placeholder' => 'No. Telefon'])->label(false); ?> 
                      </div>
                  </div>
              </div>-->
        </div>
      </div>
              
            
                  <br>
              
                      <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="text-right">
                            <?= Html::submitButton('Hantar', ['class' => 'btn  waves-effect-light btn-info btn-sm btnSave']) ?>
                                <a href="../block-request-list"
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
                                        </div></div>
<!-- end form design  -->

	
</div>

</div></div>

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
