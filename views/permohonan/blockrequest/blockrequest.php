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
            <li class="breadcrumb-item"><a href="../permohonan/block-request-list">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Blocking Request</li>
            
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
           <?= $form->field($model, 'masterCaseInfoTypeId')->hiddenInput(['value' => $masterCaseInfoTypeId])->label(false); ?>
           <div class="row mb-3">
              <label for="inputEmail3" class="col-sm-4 col-form-label">Pilihan Mengisi</label>
              <div class="col-sm-8">
                    <?= $form->field($model, 'for_self')->radioList($newCase,array('class'=>'for_self'))->label(false); ?>
                    <div id="choose_forself">
                    <?= $form->field($model, 'selfName')->textInput(['placeholder' => 'name'])->label(false) ?>
                    <?= $form->field($model, 'email')->textInput(['placeholder' => 'email'])->label(false) ?>
                    <div class="help-block-email" id="invalid_email"></div>
                    <?= $form->field($model, 'no_telephone')->textInput(['placeholder' => 'No. telephone'])->label(false) ?>                
                    </div> 
              </div>
           </div>


           <!--<div class="row mb-3">
                <label for="inputPassword3" class="col-sm-4 col-form-label">No Laporan Polis </label>
                <div class="col-sm-8">
                <?php //= $form->field($model, 'report_no')->textInput(['placeholder' => 'No Laporan Polis'])->label(false) ?>   
                </div>
            </div>-->

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
                <?=  $form->field($model, 'surat_rasmi')->fileInput()->label(false)->hint('Lampiran hendaklah png | jpg | jpeg | pdf'); ?>
                </div>
            </div>

            <div class="row mb-3">
                <legend class="col-form-label col-sm-4 pt-0">Laporan Polis</legend>
                <div class="col-sm-8">
                <?= $form->field($model, 'laporan_polis')->fileInput(['accept' => 'image/*'])->label(false)->hint('Lampiran hendaklah png | jpg | jpeg | pdf');?>   
                </div>
            </div>

            <!--<div class="row mb-3">
                <legend class="col-form-label col-sm-4 pt-0">Attachment URL</legend>
                <div class="col-sm-8">-->
                <?php //= $form->field($model, 'attachmentURL')->textInput(['placeholder' => 'URL'])->label(false) ?>
                <!--</div>
            </div>-->
            
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
                echo $form->field($model, 'master_social_media_id['.$i.']')->dropDownList($masterSocialMedia,array('prompt' => '--Pilih Social Media--','id' => 'social_media_'.$i))->label(false);
                echo $form->field($model, 'url['.$i.']')->textInput(['id' => 'social_media_URL_'.$i])->label(false); 
                ?>
                </div>
                <?php
                }
                ?> 
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
    if (this.value == 78) {
      $("#choose_forself").show();
    }
    else if (this.value == 79) {
      $("#choose_forself").hide();
    }
});

$('#add').click(function(){ var newID =  ( $('#url_input_append > div').length);
if(newID <= 15)
{
  $('#url_input_append').append('<div class="row"><div class="form-group field-blockrequestform-master_social_media_id"><select id="social_media_'+newID+'" class="form-control" name="BlockRequestForm[master_social_media_id]['+newID+']"><option value="">--Pilih Social Media--</option><option value="39">twitter</option><option value="40">instagram</option><option value="41">tumblr</option><option value="42">facebook</option><option value="43">blog / website</option><option value="99">Yourtube</option><option value="100">Tiktok</option><option value="101">Others</option></select><div class="help-block"></div></div><div class="form-group field-blockrequestform-url-'+newID+'"><input type="text" id="blockrequestform-url-'+newID+'" class="form-control" name="BlockRequestForm[url]['+newID+']"><div class="help-block"></div></div></div>');
                                 
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

var URL_obj = [{id:39, name:"https://twitter.com/"}, {id:40, name:"https://www.instagram.com/"}, {id:41, name:"https://www.tumblr.com/"}, {id:42, name:"https://www.facebook.com/"}, {id:99, name:"https://www.youtube.com/"}, {id:100, name:"https://www.tiktok.com/"}];

$('#social_media_0').on('change',function() {   
  if(URL_obj.find(item => item.id == $("#social_media_0").val())){ var item_val = URL_obj.find(item => item.id == $("#social_media_0").val()); $("#social_media_URL_0").val(item_val.name);}
});
$('#social_media_1').on('change',function() {   
  if(URL_obj.find(item => item.id == $("#social_media_1").val())){ var item_val = URL_obj.find(item => item.id == $("#social_media_1").val()); $("#social_media_URL_1").val(item_val.name);}
});
$('#social_media_2').on('change',function() {   
  if(URL_obj.find(item => item.id == $("#social_media_2").val())){ var item_val = URL_obj.find(item => item.id == $("#social_media_2").val()); $("#social_media_URL_2").val(item_val.name);}
});
$('#social_media_3').on('change',function() {   
  if(URL_obj.find(item => item.id == $("#social_media_3").val())){ var item_val = URL_obj.find(item => item.id == $("#social_media_3").val()); $("#social_media_URL_3").val(item_val.name);}
});
$('#social_media_4').on('change',function() {   
  if(URL_obj.find(item => item.id == $("#social_media_4").val())){ var item_val = URL_obj.find(item => item.id == $("#social_media_4").val()); $("#social_media_URL_4").val(item_val.name);}
});
$('#social_media_5').on('change',function() {   
  if(URL_obj.find(item => item.id == $("#social_media_5").val())){ var item_val = URL_obj.find(item => item.id == $("#social_media_5").val()); $("#social_media_URL_5").val(item_val.name);}
});
$('#social_media_6').on('change',function() {   
  if(URL_obj.find(item => item.id == $("#social_media_6").val())){ var item_val = URL_obj.find(item => item.id == $("#social_media_6").val()); $("#social_media_URL_6").val(item_val.name);}
});
$('#social_media_7').on('change',function() {   
  if(URL_obj.find(item => item.id == $("#social_media_7").val())){ var item_val = URL_obj.find(item => item.id == $("#social_media_7").val()); $("#social_media_URL_7").val(item_val.name);}
});
$('#social_media_8').on('change',function() {   
  if(URL_obj.find(item => item.id == $("#social_media_8").val())){ var item_val = URL_obj.find(item => item.id == $("#social_media_8").val()); $("#social_media_URL_8").val(item_val.name);}
});
$('#social_media_9').on('change',function() {   
  if(URL_obj.find(item => item.id == $("#social_media_9").val())){ var item_val = URL_obj.find(item => item.id == $("#social_media_9").val()); $("#social_media_URL_9").val(item_val.name);}
});
$('#social_media_10').on('change',function() {   
  if(URL_obj.find(item => item.id == $("#social_media_10").val())){ var item_val = URL_obj.find(item => item.id == $("#social_media_10").val()); $("#social_media_URL_10").val(item_val.name);}
});
$('#social_media_11').on('change',function() {   
  if(URL_obj.find(item => item.id == $("#social_media_11").val())){ var item_val = URL_obj.find(item => item.id == $("#social_media_11").val()); $("#social_media_URL_11").val(item_val.name);}
});
$('#social_media_12').on('change',function() {   
  if(URL_obj.find(item => item.id == $("#social_media_12").val())){ var item_val = URL_obj.find(item => item.id == $("#social_media_12").val()); $("#social_media_URL_12").val(item_val.name);}
});
$('#social_media_13').on('change',function() {   
  if(URL_obj.find(item => item.id == $("#social_media_13").val())){ var item_val = URL_obj.find(item => item.id == $("#social_media_13").val()); $("#social_media_URL_13").val(item_val.name);}
});
$('#social_media_14').on('change',function() {   
  if(URL_obj.find(item => item.id == $("#social_media_14").val())){ var item_val = URL_obj.find(item => item.id == $("#social_media_14").val()); $("#social_media_URL_14").val(item_val.name);}
});
$('#social_media_15').on('change',function() {   
  if(URL_obj.find(item => item.id == $("#social_media_15").val())){ var item_val = URL_obj.find(item => item.id == $("#social_media_15").val()); $("#social_media_URL_15").val(item_val.name);}
});

//new

$('#url_input_append').on('change','#social_media_1', function() { 
  if(URL_obj.find(item => item.id == $("#social_media_1").val())){ var item_val = URL_obj.find(item => item.id == $("#social_media_1").val()); $("#social_media_URL_1").val(item_val.name);}
});
$('#url_input_append').on('change','#social_media_2', function() { 
  if(URL_obj.find(item => item.id == $("#social_media_2").val())){ var item_val = URL_obj.find(item => item.id == $("#social_media_2").val()); $("#social_media_URL_2").val(item_val.name);}
});
$('#url_input_append').on('change','#social_media_3', function() { 
  if(URL_obj.find(item => item.id == $("#social_media_3").val())){ var item_val = URL_obj.find(item => item.id == $("#social_media_3").val()); $("#social_media_URL_3").val(item_val.name);}
});
$('#url_input_append').on('change','#social_media_4', function() { 
  if(URL_obj.find(item => item.id == $("#social_media_4").val())){ var item_val = URL_obj.find(item => item.id == $("#social_media_4").val()); $("#social_media_URL_4").val(item_val.name);}
});
$('#url_input_append').on('change','#social_media_5', function() { 
  if(URL_obj.find(item => item.id == $("#social_media_5").val())){ var item_val = URL_obj.find(item => item.id == $("#social_media_5").val()); $("#social_media_URL_5").val(item_val.name);}
});
$('#url_input_append').on('change','#social_media_6', function() { 
  if(URL_obj.find(item => item.id == $("#social_media_6").val())){ var item_val = URL_obj.find(item => item.id == $("#social_media_6").val()); $("#social_media_URL_6").val(item_val.name);}
});
$('#url_input_append').on('change','#social_media_7', function() { 
  if(URL_obj.find(item => item.id == $("#social_media_7").val())){ var item_val = URL_obj.find(item => item.id == $("#social_media_7").val()); $("#social_media_URL_7").val(item_val.name);}
});
$('#url_input_append').on('change','#social_media_8', function() { 
  if(URL_obj.find(item => item.id == $("#social_media_8").val())){ var item_val = URL_obj.find(item => item.id == $("#social_media_8").val()); $("#social_media_URL_8").val(item_val.name);}
});
$('#url_input_append').on('change','#social_media_9', function() { 
  if(URL_obj.find(item => item.id == $("#social_media_9").val())){ var item_val = URL_obj.find(item => item.id == $("#social_media_9").val()); $("#social_media_URL_9").val(item_val.name);}
});
$('#url_input_append').on('change','#social_media_10', function() { 
  if(URL_obj.find(item => item.id == $("#social_media_10").val())){ var item_val = URL_obj.find(item => item.id == $("#social_media_10").val()); $("#social_media_URL_10").val(item_val.name);}
});
$('#url_input_append').on('change','#social_media_11', function() { 
  if(URL_obj.find(item => item.id == $("#social_media_11").val())){ var item_val = URL_obj.find(item => item.id == $("#social_media_11").val()); $("#social_media_URL_11").val(item_val.name);}
});
$('#url_input_append').on('change','#social_media_12', function() { 
  if(URL_obj.find(item => item.id == $("#social_media_12").val())){ var item_val = URL_obj.find(item => item.id == $("#social_media_12").val()); $("#social_media_URL_12").val(item_val.name);}
});
$('#url_input_append').on('change','#social_media_13', function() { 
  if(URL_obj.find(item => item.id == $("#social_media_13").val())){ var item_val = URL_obj.find(item => item.id == $("#social_media_13").val()); $("#social_media_URL_13").val(item_val.name);}
});
$('#url_input_append').on('change','#social_media_14', function() { 
  if(URL_obj.find(item => item.id == $("#social_media_14").val())){ var item_val = URL_obj.find(item => item.id == $("#social_media_14").val()); $("#social_media_URL_14").val(item_val.name);}
});
$('#url_input_append').on('change','#social_media_15', function() { 
  if(URL_obj.find(item => item.id == $("#social_media_15").val())){ var item_val = URL_obj.find(item => item.id == $("#social_media_15").val()); $("#social_media_URL_15").val(item_val.name);}
});

    var valid = true;

   

});
JS; $this->registerJs($script, \yii\web\View::POS_END);

?>
