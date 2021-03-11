<?php

/* @var $this yii\web\View */

namespace app\widgets;

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
?>

<div class="container-fluid">
    <h1 style="padding-top: 1.5rem;">Permohonan Baru Sosial Media</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="../crawler/mntl-list">Permohonan Baru</a></li>
            
        </ol>
    </nav>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-5">

            <?php $form = ActiveForm::begin(['method' => 'post','id' => 'permohananBaru','enableClientValidation' => true,'options' => ['enctype' => 'multipart/form-data']]); ?>
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
      <?= $form->field($model, 'offence')->dropDownList($offences,array('prompt' => '--Pilih Kesalahan--'))->label(false); ?>
     </div>
  </div>
  <div class="row mb-3">
    <label for="inputPassword3" class="col-sm-4 col-form-label">Ringkasan Kes </label>
    <div class="col-sm-8">
    <?= $form->field($model, 'case_summary')->textarea()->label(false); ?>
    </div>
  </div>
  <div class="row mb-3">
    <legend class="col-form-label col-sm-4 pt-0">Status Suspek</legend>
    <div class="col-sm-8">
       <?= $form->field($model, 'master_suspect_id')->checkboxList($masterStatusSuspect, ['itemOptions'=>['class' => 'master_suspect_class']])->label(false);?>   
       <div class="pull-right">
      <button type="button" id="add_ic_name" class="add-item btn btn-success btn-xs">+</button>
    </div>
     </div>
     <div class="col-sm-4" ></div>
     <div class="col-sm-8" id="id_name">
     <div class="row">
     <div class="col-sm-4">
       <?= $form->field($model, 'ic[0]')->textInput(['placeholder' => 'IC'])->label(false);?> 
       </div>
     <div class="col-sm-4"> 
       <?= $form->field($model, 'name[0]')->textInput(['placeholder' => 'Name'])->label(false);?>  
      </div>  
       </div>
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
     echo $form->field($model, 'url['.$i.']')->textInput()->label(false); 
    }
    ?> 
    </div>
  </div>

  

  <div class="row mb-3">
    <legend class="col-form-label col-sm-4 pt-0">Tujuan Permohanan</legend>
    <div class="col-sm-8">
       <?= $form->field($model, 'application_purpose')->checkboxList($purposeOfApplication)->label(false);?>   
     </div>
  </div>
  


                <div class="form-group" style="padding-top: 20px;">
                    <?= Html::submitButton('Submit', [
                        'class' => 'btn btn-primary',
                        'name' => 'mntl-button'
                    ]) ?>
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
  $("input[name='PermohonanForm[for_self]']").change(function() {  //alert("ramstest = "+$("input[name='PermohonanForm[for_self]']:checked").val());
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
  $('#url_input_append').append('<div class="form-group field-permohonanform-url-'+newID+'"><input type="text" id="permohonanform-url-'+newID+'" class="form-control" name="PermohonanForm[url]['+newID+']"><div class="help-block"></div></div>');
}
else{
  alert("Can't create new field");
  return false;
}
  
});
$('#add_ic_name').click(function(){ var newIDInfo =  ( $('#id_name > div').length); 
  $('#id_name').append('<div class="row"><div class="col-sm-4"><div class="form-group field-permohonanform-ic-0"><input type="text" id="permohonanform-ic-0" class="form-control" name="PermohonanForm[ic]['+newIDInfo+']" placeholder="IC"><div class="help-block"></div></div></div><div class="col-sm-4"><div class="form-group field-permohonanform-name-0"><input type="text" id="permohonanform-name-0" class="form-control" name="PermohonanForm[name]['+newIDInfo+']" placeholder="Name"><div class="help-block"></div></div></div></div>');
});


    var valid = true;

   /* $('form').submit(function(ev){ 
      
      //alert("ramstest - "+$("input[name='Permohonan[for_self]']:checked").val());
      var selected_for_self = $("input[name='Permohonan[for_self]']:checked").val();
      if(selected_for_self == undefined)
        { 
          
            $(".help-block").html('Sila pilih Pilihan Mengisi');
            valid = false;
            return valid;
        }
      else
      {
        
        $("#choose_forself").show();
      }  
        if($("#report_no").val() == "" || $("#report_no").val().length == 0)
        { 
          
            $(".help-block").html('Enter report_no name');
            valid = false;
            return valid;
        }
        
        else{
          console.log($("#offence").val());
            valid = true;
            return valid;   
        }
    return valid;
}); */


});
JS; $this->registerJs($script, \yii\web\View::POS_END);

?>
