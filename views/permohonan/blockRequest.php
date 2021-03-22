<?php

/* @var $this yii\web\View */

namespace app\widgets;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use Yii;
?>

<div class="container-fluid">
    <h1 style="padding-top: 1.5rem;">Blocking Request</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="../crawler/mntl-list">Blocking Request</a></li>
            
        </ol>
    </nav>
    <div class="card-body">
                                    <div  id="failed" class="info failedMsg">
                                        <?php if(Yii::$app->session->hasFlash('failed')):
                                         echo Yii::$app->session->getFlash('failed')[0];
                                        ?>
                                        <?php endif; ?>  
                                    </div>
        <div class="row">`
       
            <div class="col-lg-5">

           <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
           <?= $form->field($model, 'masterCaseInfoTypeId')->hiddenInput(['value' => $masterCaseInfoTypeId]); ?>
           <div class="row mb-3">
              <label for="inputEmail3" class="col-sm-4 col-form-label">Pilihan Mengisi</label>
              <div class="col-sm-8">
                    <?= $form->field($model, 'for_self')->radioList($newCase,array('class'=>'for_self'))->label(false); ?>
                    <div id="choose_forself">
                    <?= $form->field($model, 'email')->textInput(['placeholder' => 'email'])
                                    ->label(false) ?>
                    <?= $form->field($model, 'no_telephone')->textInput(['placeholder' => 'No. telephone'])
                                    ->label(false) ?>                
                    </div> 
              </div>
           </div>


           <div class="row mb-3">
                <label for="inputPassword3" class="col-sm-4 col-form-label">No Laporan Polis </label>
                <div class="col-sm-8">
                <?= $form->field($model, 'report_no')->textInput(['placeholder' => 'No Laporan Polis'])->label(false) ?>   
                </div>
            </div>

            <div class="row mb-3">
                <label for="inputPassword3" class="col-sm-4 col-form-label">No Kertas Siasatan </label>
                <div class="col-sm-8">
                <?= $form->field($model, 'investigation_no')->textInput(['placeholder' => 'No Kertas Siasata'])->label(false) ?> 
                </div>
            </div>

            <div class="row mb-3">
                <legend class="col-form-label col-sm-4 pt-0">Kesalahan</legend>
                <div class="col-sm-8">
                <?= $form->field($model, 'offence')->dropDownList($offences,array('multiple'=>'multiple','prompt' => '--Pilih Kesalahan--'))->label(false); ?>
                </div>
           </div>


            <div class="row mb-3">
                <label for="inputPassword3" class="col-sm-4 col-form-label">Ringkasan Kes </label>
                <div class="col-sm-8">
                <?= $form->field($model, 'case_summary')->textarea()->label(false); ?>
                </div>
            </div>

            <div class="row mb-3">
                <legend class="col-form-label col-sm-4 pt-0">Surat Rasmi</legend>
                <div class="col-sm-8">
                <?=  $form->field($model, 'surat_rasmi')->fileInput()->label(false); ?>
                </div>
            </div>

            <div class="row mb-3">
                <legend class="col-form-label col-sm-4 pt-0">Laporan Polis</legend>
                <div class="col-sm-8">
                <?= $form->field($model, 'laporan_polis')->fileInput(['accept' => 'image/*'])->label(false);?>   
                </div>
            </div>

            <div class="row mb-3">
                <legend class="col-form-label col-sm-4 pt-0">URL</legend>
                <div class="pull-right">
                <button type="button" id="add" class="add-item btn btn-success btn-xs">+</button>
            </div>
            <div class="col-sm-8" id="url_input_append">
                <?php
                for($i=0;$i<=4;$i++)
                {
                  ?>
                  <div class="row">
                  <?php
                echo $form->field($model, 'master_social_media_id['.$i.']')->dropDownList($masterSocialMedia,array('prompt' => '--Pilih Social Media--'))->label(false);
                echo $form->field($model, 'url['.$i.']')->textInput()->label(false); 
                ?>
                </div>
                <?php
                }
                ?> 
            </div>
            <div class="row mb-3">
                <legend class="col-form-label col-sm-4 pt-0">Tujuan Permohanan</legend>
                <div class="col-sm-8">
                <?= $form->field($model, 'application_purpose')->checkboxList($purposeOfApplication)->label(false);?> 
                <div id="application_purpose_info">
                <input type="text" name="BlockRequestForm[application_purpose_info]" placeholder="Tujuan Permohanan">
                </div>   
                </div>
            </div>
        </div>


    
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
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
  $("input[name='BlockRequestForm[for_self]']").change(function() {  //alert("ramstest = "+$("input[name='BlockRequestForm[for_self]']:checked").val());
    if (this.value == 6) {
      $("#choose_forself").show();
    }
    else if (this.value == 7) {
      $("#choose_forself").hide();
    }
});

$('#add').click(function(){ var newID =  ( $('#url_input_append > div').length);
if(newID <= 15)
{
  $('#url_input_append').append('<div class="row"><div class="form-group field-blockrequestform-master_social_media_id"><select id="blockrequestform-master_social_media_id['+newID+']" class="form-control" name="BlockRequestForm[master_social_media_id]['+newID+']"><option value="">--Pilih Social Media--</option><option value="1">twitter</option><option value="2">instagram</option><option value="3">tumblr</option><option value="4">facebook</option><option value="5">blog / website</option></select><div class="help-block"></div></div><div class="form-group field-blockrequestform-url-'+newID+'"><input type="text" id="blockrequestform-url-'+newID+'" class="form-control" name="BlockRequestForm[url]['+newID+']"><div class="help-block"></div></div></div>');
}
else{
  alert("Can't create new field");
  return false;
}
  
});


$("input:checkbox[name='BlockRequestForm[application_purpose][]']").click(function(){ 
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