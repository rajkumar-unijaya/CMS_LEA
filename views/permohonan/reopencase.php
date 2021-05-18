<?php

/* @var $this yii\web\View */

namespace app\widgets;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use Yii;
use wbraganca\dynamicform\DynamicFormWidget;
?>
<?php 
$prevSuspekStatus = 0;
if(isset($mediaSocialResponse['case_info_status_suspek']) && count($mediaSocialResponse['case_info_status_suspek']) > 0)
{
  $prevSuspekStatus = count($mediaSocialResponse['case_info_status_suspek']); 
}
?>
<div class="container-fluid">
    <h3 style="padding-top: 1.5rem;">Sosial Media</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="../dashboard/index">Laman Utama</a></li>
        <li class="breadcrumb-item"><a href="../permohonan/mediasosial">Media Sosial</a></li>
            <li class="breadcrumb-item active">Permohonan Baru Sosial Media</a></li>
            
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

                      <h5 class="m-t-20" style="color:#337ab7" >Maklumat Permohonan Penyekatan</h5>
                      <hr>
                    
           <?= $form->field($model, 'master_case_info_type_id')->hiddenInput(['value' => $mediaSocialResponse['master_case_info_type_id']])->label(false); ?>
           <?=  Html::hiddenInput('PermohonanForm[id]', $mediaSocialResponse['id'],["id" => "permohonanId"]); ?>
           <?=  Html::hiddenInput('PermohonanForm[prev_case_info_status_suspek]', $prevSuspekStatus,["id" => "prev_case_info_status_suspek"]); ?>
           <br>

           <div class="row">
              <div class="col-md-6">
                  <label for="inputPassword3">No. Laporan Polis </label>
                  <?php  $model->report_no = $mediaSocialResponse['report_no']; ?>
                  <?= $form->field($model, 'report_no')->textInput(['placeholder' => 'No Laporan Polis','readonly' => true])->label(false) ?>           
                  <div class="help-block-report_no" id="invalid_report_no">No Laporan Polis already exists</div>
              </div>

            <div class="col-md-6">
                <label for="inputPassword3">No. Kertas Siasatan </label>
                <?php  $model->investigation_no = $mediaSocialResponse['investigation_no']; ?>
                    <?= $form->field($model, 'investigation_no')->textInput(['placeholder' => 'No. Kertas Siasatan','readonly' => true])->label(false) ?>           
                      
            </div>
            </div>
       <!--/span-->
       <!--Ringkasan Kes-->
          
       <div class="row">
                    <div class="col-md-6">
                          <label for="inputPassword3" >Ringkasan Kes </label>
                          <?php  $model->case_summary = $mediaSocialResponse['case_summary']; ?>
                          <?= $form->field($model, 'case_summary')->textarea()->label(false); ?>
                          <small class="text-muted" id="description">(maksimum 2000 character)</small>
                      </div>
                      </div>

                <!--/status suspect-->
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
                    <button type="button" id="add_options" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                    <button type="button" id="remove_options" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                </div> 
                <div class="col-md col-sm">
                <?= $form->field($model, 'offence')->dropDownList($prevSelectedOffences,array('id' => 'mySideToSideSelect_to','class' => 'form-control','size' => 10,'multiple'=>'multiple','options' => $offencesListRes))->label(false); ?>
                </div>
       </div>
       <br>

 <!-- rams start -->
 <div class="row"> 
 <div class="col-sm-12">
                            <!--<div class="panel panel-default">
                                  <div class="panel-body">-->
                            <?php DynamicFormWidget::begin([
                                    'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                                    'widgetBody' => '.container-items', // required: css class selector
                                    'widgetItem' => '.item', // required: css class
                                    'limit' => 5, // the maximum times, an element can be cloned (default 999)
                                    'min' => 1, // 0 or 1 (default 1)
                                    'insertButton' => '.add-item-suspek', // css class
                                    'deleteButton' => '.remove-item-suspek', // css class
                                    'model' => $modelStatusSuspekSaksi[0],
                                    'formId' => 'dynamic-form',
                                    'formFields' => [
                                        'master_social_media_id',
                                        'url',
                                        
                                    ],
                                ]); ?>

                                <div class="panel panel-info">
                                        <div class="panel-heading"style=" padding: 8px;">
                                           <b> Status Suspek / Saksi</b>
                                            
                                            <button type="button" class="pull-right add-item-suspek btn btn-success btn-xs"><i class="fa fa-plus"></i> </button>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="panel-body container-items"><!-- widgetContainer -->
                                            <?php 
                                            //foreach ($modelsAddress as $index => $modelAddress):
                                            foreach ($modelStatusSuspekSaksi as $i => $statusSuspekSaksi):?>
                                                <div class="item panel panel-default"><!-- widgetBody -->
                                                    <div class="panel-heading"style=" padding: 8px;">
                                                    <span class="panel-title-address">Status Suspek / Saksi : </span>
                                                        <button type="button" class="pull-right remove-item-suspek btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div class="panel-body">
                                                        <div class="form-group" style=" padding: 10px;">
                                                                  <div class="row">
                                                                      <div class="col-md-6">
                                                                        <div class="form-group">
                                                                        <?=  Html::hiddenInput('PermohonanStatusSuspekSaksi['.$i.'][caseInfoID]', $mediaSocialResponse['id']); ?>  
                                                                        <?=  Html::hiddenInput('PermohonanStatusSuspekSaksi['.$i.'][caseInfoStatusSuspekID]', $statusSuspekSaksi['id']); ?>
                                                                        <?= $form->field($statusSuspekSaksi, '['.$i.']master_status_suspect_or_saksi_id')->dropDownList($suspectOrSaksi,array('prompt' => '--Pilih Suspek / Saksi--'))->label(false); ?>
                                                                        </div>
                                                                      </div>
                                                                  </div>     
                                                                  <!--/span--><br>
                                                                  <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                
                                                                            <?= $form->field($statusSuspekSaksi, '['.$i.']master_status_status_suspek_id')->dropDownList($masterStatusSuspect,['prompt' => '--Pilih Status--'/*,'itemOptions'=>['class' => 'master_suspect_class']*/])->label(false);?>   
                                                                            </div>
                                                                          </div>
                                                                        <div class="col-md-6" id="others_<?= $i;?>">
                                                                        <?php $nameVal = "PermohonanForm[".$i."][others]";?>
                                                                        <textarea id="others_info_<?= $i;?>" class="form-control" name = <?= $nameVal;?>><?= $statusSuspekSaksi->others;?></textarea>
                                                                        </div>
                                                                  </div>
                                                                  <!--/span--><br>
                                                                  <div class="row">
                                                                      <div class="col-md-6">
                                                                      <?= $form->field($statusSuspekSaksi, '['.$i.']ic')->textInput(['placeholder' => 'No. Kad Pengenalan'])->label(false);?> 
                                                                      </div>
                                                                      <div class="col-md-6"> 
                                                                      <?= $form->field($statusSuspekSaksi, '['.$i.']name')->textInput(['placeholder' => 'Nama'])->label(false);?> 
                                                                      </div>  
                                                                  </div>
                                                          </div>
                                                      
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
              
                                                <?php DynamicFormWidget::end(); ?>
                      </div>
              </div>

          <br>  
    <!--</div>
    </div>-->
    <!-- rams end -->
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
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelUrl[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'master_social_media_id',
                    'url',
                    
                ],
            ]); ?>

<div class="panel panel-info">
        <div class="panel-heading"style=" padding: 8px;">
           <b> URL </b>
            
            <button type="button" class="pull-right add-item btn btn-success btn-xs"><i class="fa fa-plus"></i> </button>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body container-items"><!-- widgetContainer -->
            <?php 
            //foreach ($modelsAddress as $index => $modelAddress):
            foreach ($modelUrl as $index => $modelurl): ?>
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading"style=" padding: 8px;">
                        <span class="panel-title-address">URL: <?= ($index + 1) ?></span>
                        <button type="button" class="pull-right remove-item btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body"style=" padding: 10px;">
                        
                        <div class="row">
                            <div class="col-sm-4">
                            <?php $idVal = "PermohonanUrl[".$index."][caseInfoURLInvolvedId]";?>
                            <?=  Html::hiddenInput($idVal, $modelurl['id']); ?>
                                <?= $form->field($modelurl, "[{$index}]master_social_media_id")->dropDownList($masterSocialMedia,array('prompt' => 'Pilih Sosial Media','options' => array($modelurl['master_social_media_id'] => array('selected'=>true))))->label(false);?> 
                            </div>
                            <div class="col-sm-8">
                                <?= $form->field($modelurl, "[{$index}]url")->textInput(['value' => $modelurl['url'] ? $modelurl['url'] : ''])->label(false); ?>
                            </div>
                        </div><!-- end:row -->
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    
                                       <?php DynamicFormWidget::end(); ?>
                                       </div>
                                       </div>

    
 <!--/span--><br>
 <h5 class="m-t-20"style="color:#337ab7"> Tujuan Permohonan</h5>
                <hr>
                        <div class="row"> 
                            <div class="col-lg-12 m-t-20">
                                <label class="custom-control"
                                    style="display: inline-block; padding-right: 30px;">
                                    <?php  $model->application_purpose = explode(",",$mediaSocialResponse['master_status_purpose_of_application_id']); ?>
                                    <?= $form->field($model, 'application_purpose')->checkboxList($purposeOfApplication)->label(false);?> 
                                    <div class="col-lg-6"></div>
                                <div class="col-lg-6">
                                <div id="application_purpose_info">
                                <input type="text" style="width: 130%; min-height: 2.5rem;" name="PermohonanForm[application_purpose_info]" placeholder="" value="<?= $mediaSocialResponse['purpose_of_application_info']?>">
                                </div>
                                </div>
                                </label>
                                
                            </div>
                        </div>
         

<br>
              <div class="row">
                <div class="col-md-12 col-12">
                    <div class="text-right">
                    <?= Html::submitButton('Hantar', ['class' => 'btn  waves-effect-light btn-info btn-sm btnSave']) ?>
                    <button type="button" class="btn waves-effect-light btn-danger btn-sm" data-toggle="modal" data-target="#cancelModel">
                                    Batal
                                    </button>
                            
                    </div>
                </div>
            </div>
    <?php ActiveForm::end(); ?>
            </div>
            </div>
        </div>
    
</div>
<!-- popup cancel button -->
<div class="modal fade" id="cancelModel" tabindex="-1" role="dialog" aria-labelledby="cancelModel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      Sekiranya anda BATAL sebelum menyimpan, Maklumat yang diisi akan hilang.</div>
      <div class="modal-footer">
      <a href="../permohonan/mediasosial"><button type="button" class="btn btn-primary">Ya</button></a>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        
      </div>
    </div>
  </div>
</div>
<?php
$purposeOfApplicationIdValInfo = "";
$isSuratRasmiExists =  0;
$isLaporanPoliceExists =  0;
$statusSuspekCount =  0;
$bagipihak_dirisendiri = $mediaSocialResponse['bagipihak_dirisendiri'];
$purposeOfApplicationIdVal = explode(",",$mediaSocialResponse['master_status_purpose_of_application_id']);

if(isset($mediaSocialResponse['case_info_status_suspek']) && count($mediaSocialResponse['case_info_status_suspek']) > 0)
{ 
$countPrevSuspekStatus = count($mediaSocialResponse['case_info_status_suspek']);
}
if(isset($purposeOfApplicationIdVal[0]) && !isset($purposeOfApplicationIdVal[1]))
{
  $purposeOfApplicationIdValInfo = $purposeOfApplicationIdVal[0];
}
else{
  $purposeOfApplicationIdValInfo = $purposeOfApplicationIdVal[1];
}
if(!empty($mediaSocialResponse['surat_rasmi']))
{
$isSuratRasmiExists = 1;
}
if(!empty($mediaSocialResponse['laporan_polis']))
{
$isLaporanPoliceExists = 1;
}

$script = <<< JS
$(document).ready(function() { 
  $("#add_options").click(function(){
    $("#mySideToSideSelect option:selected").remove().appendTo($("#mySideToSideSelect_to"));
});
$("#remove_options").click(function(){
    $("#mySideToSideSelect_to option:selected").remove().appendTo($("#mySideToSideSelect"));
});
  $("#invalid_report_no").hide();
if($isSuratRasmiExists)
{
  $("#suratRasmiAttachmentIsNull").hide();
  $("#suratRasmiAttachmentNotNull").show();
}
else{
  $("#suratRasmiAttachmentIsNull").show();
  $("#suratRasmiAttachmentNotNull").hide();
}
if($isLaporanPoliceExists)
{
  $("#laporanPolisAttachmentIsNull").hide();
  $("#laporanPolisAttachmentNotNull").show();
  
}
else{
  $("#laporanPolisAttachmentIsNull").show();
  $("#laporanPolisAttachmentNotNull").hide();
}
  $("#deleteImg").click(function(){ 
    if (!confirm("Do you want to delete")){
      return false;
    }
    else{
      
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {  
        var jsonResponse = JSON.parse(this.responseText);
        if(jsonResponse.status == 200 && jsonResponse.success === "success"){ 
          $("#suratRasmiAttachmentIsNull").show();
          $("#suratRasmiAttachmentNotNull").hide();
          $("#suratRasmiImagePath").removeAttr('value');
           
        }
        else{   
          alert("attachment deletion failed. Please try again");
          return false;
        }
      document.getElementById("demo").innerHTML = this.responseText;
    }
  };
  var params = "?id="+ $("#permohonanId").val()+"&path="+$("#suratRasmiImagePath").val();
  xhttp.open("GET", "../permohonan/delete-surat-rasmi"+params, true);
  
  xhttp.send();
 
    }
  });
  
  $("#laporanPolisDeleteImg").click(function(){ 
    if (!confirm("Do you want to delete")){
      return false;
    }
    else{
      
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {  
        var jsonResponse = JSON.parse(this.responseText);
       // alert("rasmstest = "+JSON.stringify(jsonResponse));
        if(jsonResponse.status == 200 && jsonResponse.success === "success"){ 
          $("#laporanPolisAttachmentIsNull").show();
          $("#laporanPolisAttachmentNotNull").hide();
          $("#loparanImagePath").removeAttr('value');
           
        }
        else{  
          alert("attachment deletion failed. Please try again");
          return false;
        }
      document.getElementById("demo").innerHTML = this.responseText;
    }
  };
  var params = "?id="+ $("#permohonanId").val()+"&path="+$("#loparanImagePath").val();
  xhttp.open("GET", "../permohonan/delete-laporan-polis"+params, true);
  
  xhttp.send();
 
    }
  });
  $("#suratRasmiViesDownloadImg").click(function(){ 
    var params = "?name="+$('#suratRasmiImagePath').val();
    document.location.href = '../permohonan/surat-download'+params
    });
  $("#laporanPolisViesDownloadImg").click(function(){ 
    
  var params = "?name="+$('#loparanImagePath').val();
  document.location.href = '../permohonan/laporan-download'+params
  });
  if($purposeOfApplicationIdValInfo == 91)
  { 
   $("#application_purpose_info").show();
  }
  else{
    $("#application_purpose_info").hide();
  }

  

//start check url
var URL_obj = [{id:39, name:"https://twitter.com/"}, {id:40, name:"https://www.instagram.com/"}, {id:41, name:"https://www.tumblr.com/"}, {id:42, name:"https://www.facebook.com/"}, {id:99, name:"https://www.youtube.com/"}, {id:100, name:"https://www.tiktok.com/"}];
$('select[name="PermohonanUrl[0][master_social_media_id]"]').change(function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[0][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[0][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[0][url]"]').val(item_val.name);}
});
$('select[name="PermohonanUrl[1][master_social_media_id]"]').change(function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[1][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[1][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[1][url]"]').val(item_val.name);}
});
$('select[name="PermohonanUrl[2][master_social_media_id]"]').change(function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[2][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[2][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[2][url]"]').val(item_val.name);}
});
$('select[name="PermohonanUrl[3][master_social_media_id]"]').change(function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[3][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[3][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[3][url]"]').val(item_val.name);}
});
$('select[name="PermohonanUrl[4][master_social_media_id]"]').change(function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[4][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[4][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[4][url]"]').val(item_val.name);}
});
$('select[name="PermohonanUrl[5][master_social_media_id]"]').change(function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[5][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[5][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[5][url]"]').val(item_val.name);}
});
$('select[name="PermohonanUrl[6][master_social_media_id]"]').change(function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[6][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[6][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[6][url]"]').val(item_val.name);}
});
$('select[name="PermohonanUrl[7][master_social_media_id]"]').change(function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[7][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[7][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[7][url]"]').val(item_val.name);}
});
$('select[name="PermohonanUrl[8][master_social_media_id]"]').change(function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[8][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[8][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[8][url]"]').val(item_val.name);}
});
$('select[name="PermohonanUrl[9][master_social_media_id]"]').change(function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[9][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[9][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[9][url]"]').val(item_val.name);}
});
$('select[name="PermohonanUrl[10][master_social_media_id]"]').change(function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[10][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[10][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[10][url]"]').val(item_val.name);}
});
$('select[name="PermohonanUrl[11][master_social_media_id]"]').change(function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[11][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[11][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[11][url]"]').val(item_val.name);}
});
$('select[name="PermohonanUrl[12][master_social_media_id]"]').change(function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[12][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[12][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[12][url]"]').val(item_val.name);}
});
$('select[name="PermohonanUrl[13][master_social_media_id]"]').change(function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[13][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[13][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[13][url]"]').val(item_val.name);}
});
$('select[name="PermohonanUrl[14][master_social_media_id]"]').change(function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[14][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[14][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[14][url]"]').val(item_val.name);}
});
$('select[name="PermohonanUrl[15][master_social_media_id]"]').change(function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[15][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[15][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[15][url]"]').val(item_val.name);}
});



// end check url


//rams new
$(".dynamicform_wrapper").on("beforeInsert", function(e, item) {
console.log("before insert");
});

$(".dynamicform_wrapper").on("afterInsert", function(e, item) {

  $('select[name="PermohonanUrl[0][master_social_media_id]"]').change(function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[0][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[0][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[0][url]"]').val(item_val.name);}
});
$('select[name="PermohonanUrl[1][master_social_media_id]"]').change(function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[1][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[1][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[1][url]"]').val(item_val.name);}
});
$('select[name="PermohonanUrl[2][master_social_media_id]"]').change(function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[2][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[2][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[2][url]"]').val(item_val.name);}
});
$('select[name="PermohonanUrl[3][master_social_media_id]"]').change(function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[3][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[3][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[3][url]"]').val(item_val.name);}
});
$('select[name="PermohonanUrl[4][master_social_media_id]"]').change(function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[4][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[4][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[4][url]"]').val(item_val.name);}
});
$('select[name="PermohonanUrl[5][master_social_media_id]"]').change(function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[5][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[5][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[5][url]"]').val(item_val.name);}
});
$('select[name="PermohonanUrl[6][master_social_media_id]"]').change(function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[6][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[6][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[6][url]"]').val(item_val.name);}
});
$('select[name="PermohonanUrl[7][master_social_media_id]"]').change(function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[7][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[7][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[7][url]"]').val(item_val.name);}
});
$('select[name="PermohonanUrl[8][master_social_media_id]"]').change(function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[8][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[8][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[8][url]"]').val(item_val.name);}
});
$('select[name="PermohonanUrl[9][master_social_media_id]"]').change(function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[9][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[9][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[9][url]"]').val(item_val.name);}
});
$('select[name="PermohonanUrl[10][master_social_media_id]"]').change(function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[10][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[10][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[10][url]"]').val(item_val.name);}
});
$('select[name="PermohonanUrl[11][master_social_media_id]"]').change(function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[11][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[11][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[11][url]"]').val(item_val.name);}
});
$('select[name="PermohonanUrl[12][master_social_media_id]"]').change(function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[12][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[12][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[12][url]"]').val(item_val.name);}
});
$('select[name="PermohonanUrl[13][master_social_media_id]"]').change(function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[13][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[13][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[13][url]"]').val(item_val.name);}
});
$('select[name="PermohonanUrl[14][master_social_media_id]"]').change(function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[14][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[14][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[14][url]"]').val(item_val.name);}
});
$('select[name="PermohonanUrl[15][master_social_media_id]"]').change(function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[15][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[15][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[15][url]"]').val(item_val.name);}
});


  $('#permohonanstatussuspeksaksi-1-master_status_suspect_or_saksi_id').change(function(){ 
  if(this.value == 86 ||  this.value == 87)
  { 
    $("#permohonanstatussuspeksaksi-1-master_status_status_suspek_id option[value=60]").prop("selected", "selected");
    $("#others_info_01").empty();
    $("#others_info_01").remove();
  }
});

$('#permohonanstatussuspeksaksi-2-master_status_suspect_or_saksi_id').change(function(){ 
  if(this.value == 86 ||  this.value == 87)
  { 
    $("#permohonanstatussuspeksaksi-2-master_status_status_suspek_id option[value=60]").prop("selected", "selected");
    $("#others_info_02").empty();
    $("#others_info_02").remove();
  }
});

$('#permohonanstatussuspeksaksi-3-master_status_suspect_or_saksi_id').change(function(){
  if(this.value == 86 ||  this.value == 87)
  {
    $("#permohonanstatussuspeksaksi-3-master_status_status_suspek_id option[value=60]").prop("selected", "selected");
    $("#others_info_03").empty();
    $("#others_info_03").remove();
  }
});

$('#permohonanstatussuspeksaksi-4-master_status_suspect_or_saksi_id').change(function(){
  if(this.value == 86 ||  this.value == 87)
  {
    $("#permohonanstatussuspeksaksi-4-master_status_status_suspek_id option[value=60]").prop("selected", "selected");
    $("#others_info_04").empty();
    $("#others_info_04").remove();
  }
});

//start select pilih status
var others_0 = 1;var others_1 = 1;var others_2 = 1;var others_3 = 1;var others_4 = 1;
$('#permohonanstatussuspeksaksi-0-master_status_status_suspek_id').change(function(){ 
  if(this.value == 64 && others_0 < 2)
  { 
    $('#others_0').html('<textarea id="others_info_0" class="form-control" name="PermohonanStatusSuspekSaksi[0][others]"></textarea>');
    ++others_0;
  }
  else if(this.value != 64){ 
    $("#others_info_0").empty();
    $("#others_info_0").remove();
    others_0 = 1;
  }
  
});

$('#permohonanstatussuspeksaksi-1-master_status_status_suspek_id').change(function(){ 
  if(this.value == 64 && others_1 < 2)
  { 
    $('#others_01').html('<textarea id="others_info_01" class="form-control" name="PermohonanStatusSuspekSaksi[1][others]"></textarea>');
    ++others_1;
  }
  else if(this.value != 64){ 
    $("#others_info_01").empty();
    $("#others_info_01").remove();
    others_1 = 1;
  }
  
});
$('#permohonanstatussuspeksaksi-2-master_status_status_suspek_id').change(function(){
  if(this.value == 64 && others_2 < 2)
  { 
    $('#others_02').html('<textarea id="others_info_02" class="form-control" name="PermohonanStatusSuspekSaksi[2][others]"></textarea>');
    ++others_2;
  }
  else if(this.value != 64){ 
    $("#others_info_02").empty();
    $("#others_info_02").remove();
    others_2 = 1;
  }
  
});
$('#permohonanstatussuspeksaksi-3-master_status_status_suspek_id').change(function(){ 
  if(this.value == 64 && others_3 < 2)
  { 
    $('#others_03').html('<textarea id="others_info_03" class="form-control" name="PermohonanStatusSuspekSaksi[3][others]"></textarea>');
    ++others_3;
  }
  else if(this.value != 64){ 
    $("#others_info_03").empty();
    $("#others_info_03").remove();
    others_3 = 1;
  }
  
});
$('#permohonanstatussuspeksaksi-4-master_status_status_suspek_id').change(function(){ 
  if(this.value == 64 && others_4 < 2)
  { 
    $('#others_04').html('<textarea id="others_info_04" class="form-control" name="PermohonanStatusSuspekSaksi[4][others]"></textarea>');
    ++others_4;
  }
  else if(this.value != 64){ 
    $("#others_info_04").empty();
    $("#others_info_04").remove();
    others_4 = 1;
  }
  
});
//end select pilih status

    //console.log("afterInsert");
});

$(".dynamicform_wrapper").on("beforeDelete", function(e, item) {
    if (! confirm("Are you sure you want to delete this item?")) {
        return false;
    }
    return true;
});

$(".dynamicform_wrapper").on("afterDelete", function(e) {
    console.log("Deleted item!");
    //start select pilih status
var others_0 = 1;var others_1 = 1;var others_2 = 1;var others_3 = 1;var others_4 = 1;
$('#permohonanstatussuspeksaksi-0-master_status_status_suspek_id').change(function(){ 
  if(this.value == 64 && others_0 < 2)
  { 
    $('#others_0').html('<textarea id="others_info_0" class="form-control" name="PermohonanStatusSuspekSaksi[0][others]"></textarea>');
    ++others_0;
  }
  else if(this.value != 64){ 
    $("#others_info_0").empty();
    $("#others_info_0").remove();
    others_0 = 1;
  }
  
});



$('#permohonanstatussuspeksaksi-1-master_status_status_suspek_id').change(function(){ 
  if(this.value == 64 && others_1 < 2)
  { 
    $('#others_01').html('<textarea id="others_info_01" class="form-control" name="PermohonanStatusSuspekSaksi[1][others]"></textarea>');
    ++others_1;
  }
  else if(this.value != 64){ 
    $("#others_info_01").empty();
    $("#others_info_01").remove();
    others_1 = 1;
  }
  
});
$('#permohonanstatussuspeksaksi-2-master_status_status_suspek_id').change(function(){
  if(this.value == 64 && others_2 < 2)
  { 
    $('#others_02').html('<textarea id="others_info_02" class="form-control" name="PermohonanStatusSuspekSaksi[2][others]"></textarea>');
    ++others_2;
  }
  else if(this.value != 64){ 
    $("#others_info_02").empty();
    $("#others_info_02").remove();
    others_2 = 1;
  }
  
});
$('#permohonanstatussuspeksaksi-3-master_status_status_suspek_id').change(function(){ 
  if(this.value == 64 && others_3 < 2)
  { 
    $('#others_03').html('<textarea id="others_info_03" class="form-control" name="PermohonanStatusSuspekSaksi[3][others]"></textarea>');
    ++others_3;
  }
  else if(this.value != 64){ 
    $("#others_info_03").empty();
    $("#others_info_03").remove();
    others_3 = 1;
  }
  
});
$('#permohonanstatussuspeksaksi-4-master_status_status_suspek_id').change(function(){ 
  if(this.value == 64 && others_4 < 2)
  { 
    $('#others_04').html('<textarea id="others_info_04" class="form-control" name="PermohonanStatusSuspekSaksi[4][others]"></textarea>');
    ++others_4;
  }
  else if(this.value != 64){ 
    $("#others_info_04").empty();
    $("#others_info_04").remove();
    others_4 = 1;
  }
  
});
//end select pilih status
});

$(".dynamicform_wrapper").on("limitReached", function(e, item) {
    alert("Limit reached");
});
//rams end

//start select suspek/saksi
$('#permohonanstatussuspeksaksi-0-master_status_suspect_or_saksi_id').change(function(){ 
  if(this.value == 86 ||  this.value == 87)
  { 
    $("#permohonanstatussuspeksaksi-0-master_status_status_suspek_id option[value=60]").prop("selected", "selected");
    $("#others_info_0").empty();
    $("#others_info_0").remove();
  }
});
$('#permohonanstatussuspeksaksi-1-master_status_suspect_or_saksi_id').change(function(){ 
  if(this.value == 86 ||  this.value == 87)
  { 
    $("#permohonanstatussuspeksaksi-1-master_status_status_suspek_id option[value=60]").prop("selected", "selected");
    $("#others_info_1").empty();
    $("#others_info_1").remove();
  }
});
$('#permohonanstatussuspeksaksi-2-master_status_suspect_or_saksi_id').change(function(){ 
  if(this.value == 86 ||  this.value == 87)
  { 
    $("#permohonanstatussuspeksaksi-2-master_status_status_suspek_id option[value=60]").prop("selected", "selected");
    $("#others_info_2").empty();
    $("#others_info_2").remove();
  }
});

$('#permohonanstatussuspeksaksi-3-master_status_suspect_or_saksi_id').change(function(){ 
  if(this.value == 86 ||  this.value == 87)
  { 
    $("#permohonanstatussuspeksaksi-3-master_status_status_suspek_id option[value=60]").prop("selected", "selected");
    $("#others_info_3").empty();
    $("#others_info_3").remove();
  }
});

$('#permohonanstatussuspeksaksi-4-master_status_suspect_or_saksi_id').change(function(){ 
  if(this.value == 86 ||  this.value == 87)
  { 
    $("#permohonanstatussuspeksaksi-4-master_status_status_suspek_id option[value=60]").prop("selected", "selected");
    $("#others_info_4").empty();
    $("#others_info_4").remove();
  }
});
//end select suspek/saksi


//start select pilih status
var others_0 = 1;var others_1 = 1;var others_2 = 1;var others_3 = 1;var others_4 = 1;
$('#permohonanstatussuspeksaksi-0-master_status_status_suspek_id').change(function(){ 
  if(this.value == 64 && others_0 < 2)
  { 
    $('#others_0').html('<textarea id="others_info_0" class="form-control" name="PermohonanStatusSuspekSaksi[0][others]"></textarea>');
    ++others_0;
  }
  else if(this.value != 64){ 
    $("#others_info_0").empty();
    $("#others_info_0").remove();
    others_0 = 1;
  }
  
});

$('#permohonanstatussuspeksaksi-1-master_status_status_suspek_id').change(function(){ 
  if(this.value == 64 && others_1 < 2)
  { 
    $('#others_1').html('<textarea id="others_info_1" class="form-control" name="PermohonanStatusSuspekSaksi[1][others]"></textarea>');
    ++others_1;
  }
  else if(this.value != 64){ 
    $("#others_info_1").empty();
    $("#others_info_1").remove();
    others_1 = 1;
  }
  
});
$('#permohonanstatussuspeksaksi-2-master_status_status_suspek_id').change(function(){ 
  if(this.value == 64 && others_2 < 2)
  { 
    $('#others_2').html('<textarea id="others_info_2" class="form-control" name="PermohonanStatusSuspekSaksi[2][others]"></textarea>');
    ++others_2;
  }
  else if(this.value != 64){ 
    $("#others_info_2").empty();
    $("#others_info_2").remove();
    others_2 = 1;
  }
  
});
$('#permohonanstatussuspeksaksi-3-master_status_status_suspek_id').change(function(){ 
  if(this.value == 64 && others_3 < 2)
  { 
    $('#others_3').html('<textarea id="others_info_3" class="form-control" name="PermohonanStatusSuspekSaksi[3][others]"></textarea>');
    ++others_3;
  }
  else if(this.value != 64){ 
    $("#others_info_3").empty();
    $("#others_info_3").remove();
    others_3 = 1;
  }
  
});
$('#permohonanstatussuspeksaksi-4-master_status_status_suspek_id').change(function(){ 
  if(this.value == 64 && others_4 < 2)
  { 
    $('#others_4').html('<textarea id="others_info_4" class="form-control" name="PermohonanStatusSuspekSaksi[4][others]"></textarea>');
    ++others_4;
  }
  else if(this.value != 64){ 
    $("#others_info_4").empty();
    $("#others_info_4").remove();
    others_4 = 1;
  }
  
});
//end select pilih status


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
