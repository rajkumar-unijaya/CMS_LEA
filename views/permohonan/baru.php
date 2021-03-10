<?php

/* @var $this yii\web\View */

namespace app\widgets;

use yii\helpers\Html;
use yii\widgets\ActiveForm;

// $this->title = 'Verification';
// $this->params['breadcrumbs'][] = $this->title;
?>
<!-- <div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        This is the <?= Html::encode($this->title) ?> page. You may modify the following file to customize its content
    </p>
</div> -->

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
              <?php 
    $list = [1 => 'Bagipihak', 2 => 'diri sendiri'];
    echo $form->field($model, 'for_self')->radioList($list,array('class'=>'for_self'))->label(false); ?>
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
      <?= $form->field($model, 'offence')->dropDownList(
			['a' => 'Item A', 'b' => 'Item B', 'c' => 'Item C']
			)->label(false); ?>
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
      <?= $form->field($model, 'case_summary')->dropDownList(['0' => 'Pilih','1' => 'Suspek', '2' => 'Saksi'])->label(false); ?>
       <?= $form->field($model, 'case_summary')->checkboxList($masterStatusSuspect)->label(false);?>   
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
    <?= $form->field($model, 'laporan_polis')->fileInput()->label(false);?>   
       
     </div>
  </div>
  <div class="row mb-3">
    <legend class="col-form-label col-sm-4 pt-0">URL</legend>
    <div class="col-sm-8">
    <?= $form->field($model, 'url')->textInput()->label(false) ?> 
       
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
  $("input[name='PermohonanForm[for_self]']").change(function() {  
    if (this.value == 1) {
      $("#choose_forself").show();
    }
    else if (this.value == 2) {
      $("#choose_forself").hide();
    }
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
