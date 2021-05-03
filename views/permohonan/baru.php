<?php

/* @var $this yii\web\View */

namespace app\widgets;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use Yii;
use wbraganca\dynamicform\DynamicFormWidget;
?>

<div class="container-fluid">
    <h3 style="padding-top: 1.5rem;">Media Sosial</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="../dashboard/index">Laman Utama</a></li>
            <li class="breadcrumb-item"><a href="../permohonan/mediasosial">Media Sosial</a></li>
            <li class="breadcrumb-item active">Permohonan Baru Media Sosial</a></li>
            
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
        <div class="col-lg-12">

           <?php $form = ActiveForm::begin(['id' => 'dynamic-form','options' => ['enctype' => 'multipart/form-data']]); ?>
           <?= $form->field($model, 'masterCaseInfoTypeId')->hiddenInput(['value' => $masterCaseInfoTypeId])->label(false); ?>
           
<h5 class="m-t-20" style="color:#337ab7" >Maklumat Permohonan Penyekatan</h5>
<hr>
          <div class="row">
						<div class="col-md-6">
							  <div class="form-group">
								    <label>Pilihan Mengisi <span class="text-danger">*</span></label>
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
                  <label>No. Laporan Polis </label>
                    <?= $form->field($model, 'report_no')->textInput(['placeholder' => 'No. Laporan Polis'])->label(false) ?>
                  <div class="help-block-report_no" id="invalid_report_no">No Laporan Polis already exists</div>   
          </div>

            <div class="col-md-6">
                <label>No. Kertas Siasatan<span class="text-danger">*</span> </label>
                <?= $form->field($model, 'investigation_no')->textInput(['placeholder' => 'No. Kertas Siasatan'])->label(false) ?> 
            </div>
            </div>
       <!--/span-->

       <br>
<!--Kesalahan-->
<label class="control-label">Kesalahan<span class="text-danger">*</span></label>
      <h6>Pilih Kesalahan</h6>
      <div class="row">
          <div class="col-md col-sm">
             <?= $form->field($model, 'offence_preselected')->dropDownList($offences,array('id'=>'mySideToSideSelect','class' => 'form-control','size' => 10,'multiple'=>'multiple','prompt' => 'Pilih Kesalahan'))->label(false); ?>
            <div class='control-label count-from'  style="margin:10px;">
            </div>
          </div>
      <div class="col-md-1 col-sm-12" style="margin: auto;">
      
      <button type="button" id="add_options" class="btn btn-sm waves-effect waves-light btn-info btn-block"> > </button>
      <button type="button" id="remove_options" class="btn btn-sm waves-effect waves-light btn-info btn-block">< </button> 
		
	
        
      </div> 
      <div class="col-md col-sm">
        <?php 
        $selectedNewOffences =  array();
        ?>
      <?= $form->field($model, 'offence')->dropDownList($selectedNewOffences,array('id' => 'mySideToSideSelect_to','class' => 'form-control','size' => 10,'multiple'=>'multiple','prompt' => 'Pilih Kesalahan'))->label(false); ?>
                  
      </div>
    </div>
 <!--Ringkasan Kes-->
           <div class="row">
           <div class="col-md-6">
                <label for="inputPassword3" >Ringkasan Kes </label>
                <div class="controls">
                <?= $form->field($model, 'case_summary')->textarea(['class' => 'form-control','rows' => "5"])->label(false); ?>
                <small class="text-muted" id="description">(maksimum 2000 character)</small>
                </div>
            </div>
            </div>
        <!--/span-->
        <br>

        <!--URL--> 
  <!-- rams start --><div class="row"> 
  <div class="col-sm-12">
  <!--<div class="panel panel-default">
        <div class="panel-body">-->
             <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 5, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelStatusSuspekSaksi[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'master_status_suspect_or_saksi_id',
                    'master_status_status_suspek_id',
                    'ic',
                    'name',
                    'others'
                    
                ],
            ]); ?>

            <div class="container-items"><!-- widgetContainer -->
            <?php foreach ($modelStatusSuspekSaksi as $i => $modelSuspekSaksi): //echo"<pre>";print_r($modelUrl);exit;?>
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                        <h5 class="panel-title pull-left">Status Suspek / Saksi</h5>
                        
                        <div class="pull-right">
                            <button type="button" class="add-item btn btn-success btn-xs"><i class="fa fa-plus"></i></button>
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div><hr>
                    <div class="panel-body">
                        
                        <!--<div class="row">
                            <div class="col-sm-6">
                                <?php // $form->field($modelUrl, '['.$i.']master_status_suspect_or_saksi_id')->dropDownList($masterSocialMedia,array('prompt' => 'Pilih Sosial Media','id' => $i.'social_media'))->label(false); ?>
                            </div>
                            <div class="col-sm-6">
                                <?php // $form->field($modelUrl, '['.$i.']url')->textInput(['id' => $i.'social_media_URL'])->label(false); ?>
                            </div>
                        </div>--><!-- .row -->
                        <!--/span-->
    <div class="form-group">
    <div class="row">
						<div class="col-sm-6">
							  <div class="form-group">
								   
                <?= $form->field($modelSuspekSaksi, '['.$i.']master_status_suspect_or_saksi_id')->dropDownList($suspectOrSaksi,array('prompt' => '--Pilih Suspek / Saksi--'))->label(false); ?>
							  </div>
						  </div>
              </div>     
                  <!--/span--><br>
                  <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            
                        <?= $form->field($modelSuspekSaksi, '['.$i.']master_status_status_suspek_id')->dropDownList($masterStatusSuspect,['prompt' => '--Pilih Status--'/*,'itemOptions'=>['class' => 'master_suspect_class']*/])->label(false);?>   
							            </div>
						          </div>
                    <div class="col-sm-6" id="others10">
                    <!--<textarea class="form-control" name="PermohonanForm[$i][others]"></textarea>-->
                    </div>
          </div>
    <!--/span--><br>
                <div class="row">
                    <div class="col-md-6">
                    <?= $form->field($modelSuspekSaksi, '['.$i.']ic')->textInput(['placeholder' => 'No. Kad Pengenalan'])->label(false);?> 
                    </div>
                    <div class="col-md-6"> 
                    <?= $form->field($modelSuspekSaksi, '['.$i.']name')->textInput(['placeholder' => 'Nama'])->label(false);?> 
                    </div>  
                </div>
    </div>
    <!--/span-->
                       
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
            <?php DynamicFormWidget::end(); ?>
            </div>
        </div>
    <!--</div>
    </div>-->
    <!-- rams end -->
<br>
    <!-- Surat Rasmi-->         
  <h5 class="m-t-20"style="color:#337ab7"> URL Terbabit / Email / Nama Pengguna Social Media / Etc.</h5>
      <hr>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
					  	<label>Surat Rasmi</label>
                  
						    <?=  $form->field($model, 'surat_rasmi')->fileInput()->label(false); ?>
                <small>(format file : .DOC, .DOCX, .JPG, .JPEG, .PNG, .PDF)</small>
						      <div id="fileList"></div>                     
				  	</div>
          </div>
</div>
  <!--Laporan Polis-->   
  <div class="row">       
          <div class="col-md-6">
            <div class="form-group">
					  	<label>Laporan Polis</label>
						    <?=  $form->field($model, 'laporan_polis')->fileInput()->label(false); ?>
                <small>(format file : .DOC, .DOCX, .JPG, .JPEG, .PNG, .PDF)</small>
						      <div id="fileList"></div>
               </div>      
				  	</div>
          </div>
        
<br>
            

                <!--URL--> 
  <!-- rams start --><div class="row"> 
  <div class="col-sm-12">
  <!--<div class="panel panel-default">
        <div class="panel-body">-->
             <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 15, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-url-item', // css class
                'deleteButton' => '.remove-url-item', // css class
                'model' => $modelUrl[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'master_social_media_id',
                    'url',
                    
                ],
            ]); ?>

            <div class="container-items"><!-- widgetContainer -->
            <?php foreach ($modelUrl as $j => $modelUrl): //echo"<pre>";print_r($modelUrl);exit;?>
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                        <h5 class="panel-title pull-left">URL</h5>
                        <div class="pull-right">
                            <button type="button" class="add-url-item btn btn-success btn-xs"><i class="fa fa-plus"></i></button>
                            <button type="button" class="remove-url-item btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
                        </div>
                        
                        <div class="clearfix"></div><hr>
                    </div>
                    
                    <div class="panel-body">
                        
                        <div class="row">
                            <div class="col-sm-4">
                                <?= $form->field($modelUrl, '['.$j.']master_social_media_id')->dropDownList($masterSocialMedia,array('prompt' => 'Pilih Sosial Media','id' => $j.'social_media'))->label(false); ?>
                            </div>
                            <div class="col-sm-8">
                                <?= $form->field($modelUrl, '['.$j.']url')->textInput(['id' => $i.'social_media_URL'])->label(false); ?>
                            </div>
                        </div><!-- .row -->
                       
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
            <?php DynamicFormWidget::end(); ?>
            </div>
        </div>
    <!--</div>
    </div>-->
    <!-- rams end -->
              <!--/span--><br>
              <h5 class="m-t-20"style="color:#337ab7"> Tujuan Permohonan</h5>
                <hr>
                <div class="row"> 
                            <!--<div class="col-lg-6">
                                <label class="custom-control custom-checkbox"
                                    style="display: inline-block; padding-right: 30px;">
                                    <input type="checkbox" class="custom-control-input" name="agensi_action_id" value="0">
                                    <span class="custom-control-label">Mengenalpasti pengendali akaun/laman sosial/laman web<br>
                                        
                                </label>
                            </div>-->
                            <div class="col-sm-12 m-t-20">
                                <label class="custom-control"style= "display: block;">
                                    <?= $form->field($model, 'application_purpose')->checkboxList($purposeOfApplication)->label(false);?> 
                                    <div class="row"> 
                                      <div class="col-sm-6">
                                      <input type="text" name="PermohonanForm[application_purpose_info]" placeholder="">
                                      </div>
                                </div>
                                </label>
                            </div>
                </div>
         

<br>
            <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="text-right">
                                <div class="form-group">
                                     <?= Html::submitButton('Hantar', ['class' => 'btn btn-success']) ?>
                                     <a href="../permohonan/mediasosial"
                                    class="btn waves-effect-light btn-danger btn-sm" data-toggle="tooltip"
                                    data-placement="left" title=""
                                    data-original-title="Click to cancel and back to the main page"><i
                                        class="ti-close"></i>
                                    Batal</a>
                                 </div>
                            </div>
                        </div>
                                 <div>

    <?php ActiveForm::end(); ?>
            </div>
          </div>
       
    </div>
</div>

<?php
//echo"<pre>";print_r($masterSocialMedia);
$script = <<< JS
$(document).ready(function() {
  var pausecontent=new Array();
  $("#choose_forself").hide();
  $("#application_purpose_info").hide();
  $("#invalid_report_no").hide();

  $('#permohonanform-for_self').change(function() { 
    if (this.value == 78) {
      $("#choose_forself").show();
    }
    else if (this.value == 79) {
      $("#choose_forself").hide();
    }
});

$("#add_options").click(function(){
    $("#mySideToSideSelect option:selected").remove().appendTo($("#mySideToSideSelect_to"));
});
$("#remove_options").click(function(){
    $("#mySideToSideSelect_to option:selected").remove().appendTo($("#mySideToSideSelect"));
});

$(".dynamicform_wrapper").on("beforeInsert", function(e, item) {
console.log("before insert");

});

var others_1 = 1;var others_2 = 1;var others_3 = 1;var others_4 = 1;var others_5 = 1;

$(".dynamicform_wrapper").on("afterInsert", function(e, item) {
//start check suspek/saksi 
  $('#permohonanstatussuspeksaksi-1-master_status_suspect_or_saksi_id').change(function(){ 
  if(this.value == 86 ||  this.value == 87)
  { 
    $("#permohonanstatussuspeksaksi-1-master_status_status_suspek_id option[value=60]").prop("selected", "selected");
  }
});

$('#permohonanstatussuspeksaksi-2-master_status_suspect_or_saksi_id').change(function(){ 
  if(this.value == 86 ||  this.value == 87)
  { 
    $("#permohonanstatussuspeksaksi-2-master_status_status_suspek_id option[value=60]").prop("selected", "selected");
  }
});

$('#permohonanstatussuspeksaksi-3-master_status_suspect_or_saksi_id').change(function(){ 
  if(this.value == 86 ||  this.value == 87)
  { 
    $("#permohonanstatussuspeksaksi-3-master_status_status_suspek_id option[value=60]").prop("selected", "selected");
  }
});

$('#permohonanstatussuspeksaksi-4-master_status_suspect_or_saksi_id').change(function(){ 
  if(this.value == 86 ||  this.value == 87)
  { 
    $("#permohonanstatussuspeksaksi-4-master_status_status_suspek_id option[value=60]").prop("selected", "selected");
  }
});

//end check suspek/saksi 
    //console.log("afterInsert");
    

//start check url
$('.dynamicform_wrapper').on('change','select[name="PermohonanUrl[1][master_social_media_id]"]', function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[1][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[1][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[1][url]"]').val(item_val.name);}
});

$('.dynamicform_wrapper').on('change','select[name="PermohonanUrl[2][master_social_media_id]"]', function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[2][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[2][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[2][url]"]').val(item_val.name);}
});
$('.dynamicform_wrapper').on('change','select[name="PermohonanUrl[3][master_social_media_id]"]', function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[3][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[3][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[3][url]"]').val(item_val.name);}
});
$('.dynamicform_wrapper').on('change','select[name="PermohonanUrl[4][master_social_media_id]"]', function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[4][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[4][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[4][url]"]').val(item_val.name);}
});
$('.dynamicform_wrapper').on('change','select[name="PermohonanUrl[5][master_social_media_id]"]', function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[5][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[5][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[5][url]"]').val(item_val.name);}
});
$('.dynamicform_wrapper').on('change','select[name="PermohonanUrl[6][master_social_media_id]"]', function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[6][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[6][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[6][url]"]').val(item_val.name);}
});
$('.dynamicform_wrapper').on('change','select[name="PermohonanUrl[7][master_social_media_id]"]', function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[7][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[7][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[7][url]"]').val(item_val.name);}
});
$('.dynamicform_wrapper').on('change','select[name="PermohonanUrl[8][master_social_media_id]"]', function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[8][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[8][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[8][url]"]').val(item_val.name);}
});
$('.dynamicform_wrapper').on('change','select[name="PermohonanUrl[9][master_social_media_id]"]', function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[9][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[9][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[9][url]"]').val(item_val.name);}
});
$('.dynamicform_wrapper').on('change','select[name="PermohonanUrl[10][master_social_media_id]"]', function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[10][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[10][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[10][url]"]').val(item_val.name);}
});
$('.dynamicform_wrapper').on('change','select[name="PermohonanUrl[11][master_social_media_id]"]', function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[11][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[11][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[11][url]"]').val(item_val.name);}
});
$('.dynamicform_wrapper').on('change','select[name="PermohonanUrl[12][master_social_media_id]"]', function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[12][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[12][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[12][url]"]').val(item_val.name);}
});
$('.dynamicform_wrapper').on('change','select[name="PermohonanUrl[13][master_social_media_id]"]', function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[13][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[13][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[13][url]"]').val(item_val.name);}
});
$('.dynamicform_wrapper').on('change','select[name="PermohonanUrl[14][master_social_media_id]"]', function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[14][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[14][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[14][url]"]').val(item_val.name);}
});
// end check url

//start check lain lain 
$('#permohonanstatussuspeksaksi-1-master_status_status_suspek_id').change(function(){ 
  if(this.value == 64 && others_2 < 2)
  { 
    $('#others-1-0').html('<textarea id="textarea_2" class="form-control" name="PermohonanStatusSuspekSaksi[1][others]"></textarea>');
    ++others_2;
  }
  else if(this.value != 64){ 
    $("#textarea_2").empty();
    $("#textarea_2").remove();
    others_2 = 1;
  }
  
});

$('#permohonanstatussuspeksaksi-2-master_status_status_suspek_id').change(function(){ 
  if(this.value == 64 && others_3 < 2)
  { 
    $('#others-2-0').html('<textarea id="textarea_3" class="form-control" name="PermohonanStatusSuspekSaksi[2][others]"></textarea>');
    ++others_3;
  }
  else{
    $("#textarea_3").empty();
    $("#textarea_3").remove();
    others_3 = 1;
  }
  
});

$('#permohonanstatussuspeksaksi-3-master_status_status_suspek_id').change(function(){ 
  if(this.value == 64 && others_4 < 2)
  { 
    $('#others-3-0').html('<textarea id="textarea_4" class="form-control" name="PermohonanStatusSuspekSaksi[3][others]"></textarea>');
    ++others_4;
  }
  else if(this.value != 64){
    $("#textarea_4").empty();
    $("#textarea_4").remove();
    others_4 = 1;
  }
  
});

$('#permohonanstatussuspeksaksi-4-master_status_status_suspek_id').change(function(){ 
  if(this.value == 64 && others_5 < 2)
  { 
    $('#others-4-0').html('<textarea id="textarea_5" class="form-control" name="PermohonanStatusSuspekSaksi[4][others]"></textarea>');
    ++others_5;
  }
  else{
    $("#textarea_5").empty();
    $("#textarea_5").remove();
    others_5 = 1;
  }
  
});

//end check lain lain
});

$(".dynamicform_wrapper").on("beforeDelete", function(e, item) {
    if (! confirm("Anda Pasti Ingin Memadam Data ini?")) {
        return false;
    }
    return true;
});

$(".dynamicform_wrapper").on("afterDelete", function(e) {
    console.log("Data Berjaya Dipadam!");
});

$(".dynamicform_wrapper").on("limitReached", function(e, item) {
    alert("Had Telah Dicapai");
});


$('#add').click(function(){ var newID =  ( $('#url_input_append > div').length);
if(newID <= 15)
{
  //$('#url_input_append').append('<div class="row"><div class="form-group field-permohonanform-master_social_media_id"><select id="permohonanform-master_social_media_id['+newID+']" class="form-control" name="PermohonanForm[master_social_media_id]['+newID+']"><option value="">--Pilih Social Media--</option><option value="1">twitter</option><option value="2">instagram</option><option value="3">tumblr</option><option value="4">facebook</option><option value="5">blog / website</option></select><div class="help-block"></div></div><div class="form-group field-permohonanform-url-'+newID+'"><input type="text" id="permohonanform-url-'+newID+'" class="form-control" name="PermohonanForm[url]['+newID+']"><div class="help-block"></div></div></div>');
  $('#url_input_append').append('<div class="row"><div class="col-lg-12"><div class="form-group field-permohonanform-master_social_media_id"><select id="social_media_'+newID+'" class="form-control" name="PermohonanForm[master_social_media_id]['+newID+']"><option value="">--Pilih Social Media--</option><option value="39">twitter</option><option value="40">instagram</option><option value="41">tumblr</option><option value="42">facebook</option><option value="43">blog / website</option><option value="99">Youtube</option><option value="100">Tiktok</option><option value="101">Others</option></select><div class="help-block"></div></div><div class="form-group field-permohonanform-url-'+newID+'"><input type="text" id="social_media_URL_'+newID+'" class="form-control" name="PermohonanForm[url]['+newID+']"><div class="help-block"></div></div></div></div>');
}
else{
  alert("Perhatian,maksimum hanya 15 data");
  return false;
}
});

$('#permohonanstatussuspeksaksi-0-master_status_suspect_or_saksi_id').change(function(){ 
  if(this.value == 86 ||  this.value == 87)
  { 
    $("#permohonanstatussuspeksaksi-0-master_status_status_suspek_id option[value=60]").prop("selected", "selected");
  }
});

$('#permohonanstatussuspeksaksi-0-master_status_status_suspek_id').change(function(){ 
  if(this.value == 64 && others_1 < 2)
  { 
    $('#others10').html('<textarea id="textarea_1" class="form-control" name="PermohonanStatusSuspekSaksi[0][others]"></textarea>');
    $('#others-0-0').html('<textarea id="textarea_1" class="form-control" name="PermohonanStatusSuspekSaksi[0][others]"></textarea>');
    ++others_1;
  }
  else{
    $("#textarea_1").empty();
    $("#textarea_1").remove();
    others_1 = 1;
  }
  
});

var URL_obj = [{id:39, name:"https://twitter.com/"}, {id:40, name:"https://www.instagram.com/"}, {id:41, name:"https://www.tumblr.com/"}, {id:42, name:"https://www.facebook.com/"}, {id:99, name:"https://www.youtube.com/"}, {id:100, name:"https://www.tiktok.com/"}];


$('.dynamicform_wrapper').on('change','select[name="PermohonanUrl[0][master_social_media_id]"]', function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[0][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[0][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[0][url]"]').val(item_val.name);}
});

$("input:checkbox[name='PermohonanForm[application_purpose][]']").click(function(){ 
        if (this.checked && $(this).val() == 91) { 
          $("#application_purpose_info").show();
        } else if(!this.checked && $(this).val() == 91) { 
          $("#application_purpose_info").hide();
        }
   });

   

    var valid = true;

});
JS; $this->registerJs($script, \yii\web\View::POS_END);

?>
