<?php

/* @var $this yii\web\View */

namespace app\widgets;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use Yii;//echo $mediaSocialResponse['id'];exit;
?>
<?php 
$prevSuspekStatus = 0;
if(isset($mediaSocialResponse['case_info_status_suspek']) && count($mediaSocialResponse['case_info_status_suspek']) > 0)
{
  $prevSuspekStatus = count($mediaSocialResponse['case_info_status_suspek']); 
}
?>
<div class="container-fluid">
    <h1 style="padding-top: 1.5rem;">Permohonan Baru Sosial Media</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="../crawler/mntl-list">Permohonan Baru Sosial Media</a></li>
            
        </ol>
    </nav>
    
  <div class="card-body">
                                    <div  id="failed" class="info failedMsg">
                                        <?php if(Yii::$app->session->hasFlash('failed')):
                                         echo Yii::$app->session->getFlash('failed')[0];
                                        ?>
                                        <?php endif; ?>  
                                    </div>

      <h4 class="m-t-20" style="color:#337ab7" >Maklumat Permohonan Penyekatan</h4>
      <hr>
<div class="row">
  <div class="col-lg-12">
                <?php //echo $mediaSocialResponse['case_no'];exit;?>
                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

           <div class="row">
              <div class="col-md-6">
                <label for="inputPassword3">No. Permohonan </label>
                
                <?= Html::input('text', 'case_no', $mediaSocialResponse['case_no'], ['class'=> 'form-control','readonly' => true]) ?>
                
              </div>
            </div>


           <?= $form->field($model, 'master_case_info_type_id')->hiddenInput(['value' => $mediaSocialResponse['master_case_info_type_id']])->label(false); ?>
           <?=  Html::hiddenInput('PermohonanForm[id]', $mediaSocialResponse['id'],["id" => "permohonanId"]); ?>
           <?=  Html::hiddenInput('PermohonanForm[prev_case_info_status_suspek]', $prevSuspekStatus,["id" => "prev_case_info_status_suspek"]); ?>
           <br>
           <div class="row">
              <div class="col-md-6">
                  <label for="inputPassword3">No. Laporan Polis </label>
                  <?php  $model->report_no = $mediaSocialResponse['report_no']; ?>
                    <?= $form->field($model, 'report_no')->textInput(['placeholder' => 'No Laporan Polis'])->label(false) ?>           
                    <div class="help-block-report_no" id="invalid_report_no">No Laporan Polis already exists</div>
              </div>

            <div class="col-md-6">
                <label for="inputPassword3">No. Kertas Siasatan </label>
                <?php  $model->report_no = $mediaSocialResponse['report_no']; ?>
                    <?= $form->field($model, 'report_no')->textInput(['placeholder' => 'No Laporan Polis'])->label(false) ?>           
                    <div class="help-block-report_no" id="invalid_report_no">No Laporan Polis already exists</div>   
            </div>
            </div>
       <!--/span-->
<!--Kesalahan-->
<label class="control-label">Kesalahan</label>
      <h5>Pilih Kesalahan</h5>
      <div class="row">
          <div class="col-md col-sm">

              <select id='search' multiple='multiple' name="from[]" class="form-control" size="10" style="font-size:14px;important!">
              <option value="">Seksyen 505 Kanun Keseksaan</option>
              <option value="">Seksyen 405 Kanun Keseksaan</option>
              <option value="">Seksyen 305 Kanun Keseksaan</option>
              <option value="">Seksyen 205 Kanun Keseksaan</option>
              <option value="">Seksyen 105 Kanun Keseksaan</option>
              <option value="">Seksyen 503 Kanun Keseksaan</option>
              <option value="">Seksyen 502 Kanun Keseksaan</option>
              <option value="">Seksyen 506 Kanun Keseksaan</option>
              </select>
            <div class='control-label count-from'  style="margin:10px;">
            </div>
          </div>
      <div class="col-md-1 col-sm-12" style="margin: auto;">
              <button type="button" id="search_rightSelected" class="btn btn-sm waves-effect waves-light btn-info btn-block"> > </button>
              <button type="button" id="search_leftSelected" class="btn btn-sm waves-effect waves-light btn-info btn-block">< </button> 
      </div> 
      <div class="col-md col-sm">
            <select name="aktiviti_kod[]" multiple="multiple" id="search_to" class="form-control"
                          size="10" multiple="multiple" required style="font-size:14px;important!"
                          data-validation-required-message="This field is required">
            </select>
                  <div class='control-label count-to'  style="margin:10px;">
                          0 Record
                  </div>
      </div>
    </div>

          <!-- code kesalahan -->


           <!-- <div class="row">
              <div class="col-md-6">
                <label>Kesalahan</label>
                <div class="col-sm-8">
                <?php 
                //$offencesList = array();
                //$i = 0;
                //foreach($mediaSocialResponse['case_offence'] as $key => $offenceInfo):
                 // $i++;
                  //$offencesList[$offenceInfo['offence_id']] = array("selected"=>true);
                  //echo Html::hiddenInput("PermohonanForm[offenceId][".$key."]", $offenceInfo['id']);
                //endforeach;
               // ?>
                 <?//= $form->field($model, 'offence')->dropDownList($offences,array('multiple'=>'multiple','prompt' => '--Pilih Kesalahan--','options' => $offencesList))->label(false); ?>
                </div>
           </div>
           </div> -->

 <!--Ringkasan Kes-->
          <br>
           <div class="row">
           <div class="col-md-6">
                <label for="inputPassword3" >Ringkasan Kes </label>
                <?php  $model->case_summary = $mediaSocialResponse['case_summary']; ?>
                <?= $form->field($model, 'case_summary')->textarea()->label(false); ?>
            </div>
            </div>

<!--/status suspect-->
         <br>
            <div class="row">
            <div class="col-md-6">
                <label class="col-form-label col-sm-4 pt-0">Status Suspek / Saksi</label>
                        <button type="button" id="add_ic_name" class="add-item btn btn-success btn-xs">+</button>
                </div>
            </div>
           <br>
<!--/span-->

            <?php 
            $count = 0;
            if(isset($mediaSocialResponse['case_info_status_suspek']) && count($mediaSocialResponse['case_info_status_suspek']) > 0)
            { //echo "<pre>";print_r($mediaSocialResponse['case_info_status_suspek']);exit;
            foreach($mediaSocialResponse['case_info_status_suspek'] as $key => $statusSuspectDbInfo):
            ?>
            <div class="col-lg-12" ></div>
            
            <!--<div class="col-sm-8" id="id_name_<?=$key;?>"-->
            <div class="col-lg-12" id="id_name">
                    <div class="row">
                    <div class="col-md-6">
                        <?=  Html::hiddenInput('PermohonanForm[caseInfoID]', $mediaSocialResponse['id']); ?>  
                        <?=  Html::hiddenInput('PermohonanForm[caseInfoStatusSuspekID]['.$key.']', $statusSuspectDbInfo['id']); ?>
                        <?php  $model->master_status_suspect_or_saksi_id[$key] = $statusSuspectDbInfo['master_status_suspect_or_saksi_id']; ?>
                        <?= $form->field($model, 'master_status_suspect_or_saksi_id['.$key.']')->dropDownList($suspectOrSaksi,array('prompt' => '--Pilih Suspek or Saksi--'))->label(false); ?>
                    </div>

                    <div class="col-md-6">
                        <?php  $model->master_status_status_suspek_id[$key] = $statusSuspectDbInfo['master_status_status_suspek_id']; ?>
                        <?= $form->field($model, 'master_status_status_suspek_id['.$key.']')->dropDownList($masterStatusSuspect,['prompt' => '--Pilih Option--'/*,'itemOptions'=>['class' => 'master_suspect_class']*/])->label(false);?>   
                    </div>
                    </div>
                    <br>
                  <div class="row">
                      <div class="col-md-6">
                          <?php  $model->ic[$key] = $statusSuspectDbInfo['ic']; ?>
                          <?= $form->field($model, 'ic['.$key.']')->textInput(['placeholder' => 'IC'])->label(false);?> 
                      </div>
                      <div class="col-md-6" id="add_text_areabox-<?=$key;?>"> 
                          <?php  $model->name[$key] = $statusSuspectDbInfo['name']; ?>
                          <?= $form->field($model, 'name['.$key.']')->textInput(['placeholder' => 'Name'])->label(false);?>  
                      </div> </div>
                            <?php 
                            if($statusSuspectDbInfo['master_status_status_suspek_id'] == 64)
                            {
                            ?>
                    <br>  
                    <div class="row">
                      <div class="col-md-6">
                        <div id="status_suspek_others_<?= $key;?>"><textarea class="form-control" name="PermohonanForm[others][<?= $key?>]"><?= $statusSuspectDbInfo['others'];?></textarea></div><div class="clearfix" id="clearfix_<?= $key;?>"></div> 
                            <?php 
                            }
                            ?>
                        </div>
                        </div>
                    </div>
            <?php 
            $count++;
            endforeach;
          }
          else{ 
            ?>

            <br>
            <div class="col-md-6" ></div>
            <div class="col-md-6" id="id_name">
                    <div class="row"> 
                    <div class="col-md-6" >
                    <?=  Html::hiddenInput('PermohonanForm[caseInfoID]', $mediaSocialResponse['id']); ?>                                 
                    <select name="PermohonanForm[new_master_status_suspect_or_saksi_id][0]" class="form-control" id="new_master_status_suspect_or_saksi_id_0">
                    <option value="">--Pilih Option--</option>
                    <?php foreach($suspectOrSaksi as $key => $val){?>
                      <option value="<?= $key ?>"><?= $val ?></option>
                      <?php } ?>
                    </select>
                    </div>
                    </div>

                    <div class="row">  
                    <div class="col-md-6" >                                                                             
                    <select name="PermohonanForm[new_master_status_status_suspek_id][0]" class="form-control" id="new_master_status_status_suspek_id_0">
                    <option value="">--Pilih Option--</option>
                    <?php foreach($masterStatusSuspect as $key => $val){?>
                      <option value="<?= $key ?>"><?= $val ?></option>
                      <?php } ?>
                    </select>
                    </div>
                    </div>

                    <div class="row">
                    <div class="col-md-6">
                    <?= Html::input('text', 'PermohonanForm[new_ic][0]', '', ['class'=> 'form-control','id' => "new_ic_0","placeholder"=>"IC"]) ?>
                    </div>
                    <div class="col-md-6"  id="new_add_text_areabox-0"> 
                    <?= Html::input('text', 'PermohonanForm[new_name][0]', '', ['class'=> 'form-control','id' => "new_name_0","placeholder"=>"Name"]) ?>
                    </div>  
                </div>
            </div>
            <?php 
          }
            ?>
    <br>
    <h4 class="m-t-20"style="color:#337ab7"> URL Terbabit/Email/ Nama Pengguna Social Media/Etc.</h4>
      <hr>
      <br>
            <div class="row mb-3">
            <label class="col-form-label col-sm-4 pt-0">Surat Rasmi</label>
                
                <div class="col-sm-4" id="suratRasmiAttachmentIsNull">
                <?= $form->field($model, 'surat_rasmi')->fileInput()->label(false)->hint('Lampiran hendaklah png | jpg | jpeg | pdf');?>
                </div>
                <br>
              
                <div id="suratRasmiAttachmentNotNull">
                    <div class="col-sm-4" id="surat_rasmi_img_del">
                    <input type="hidden" id="suratRasmiImagePath" name="PermohonanForm[surat_rasmi_last_attachment]" value="<?php echo $mediaSocialResponse['surat_rasmi'];?>">
                    <?= Html::button("Padam",['class'=>'btn btn-primary deleteImg',"id" => "deleteImg"]);?>
                    </div>
                
                    <div class="col-sm-4 text-right" id="surat_rasmi_img_download">
                    <?= Html::button("Muat Turun | Papar",['class'=>'btn btn-primary',"id" => "suratRasmiViesDownloadImg"]);?>
                    </div>
                </div>

            </div>
<br>
            <div class="row mb-3">
                <label class="col-form-label col-sm-4 pt-0">Laporan Polis</label>
                
              <div class="col-sm-4" id="laporanPolisAttachmentIsNull">
                <?= $form->field($model, 'laporan_polis')->fileInput(['accept' => 'image/*'])->label(false)->hint('Lampiran hendaklah png | jpg | jpeg | pdf');?>
                
              </div>

              <!--<div class="row mb-3">
                <legend class="col-form-label col-sm-4 pt-0">Attachment URL</legend>
                <div class="col-sm-4">
                <?php  //$model->attachmentURL = $mediaSocialResponse['attachment_url']; ?>
                <?php //= $form->field($model, 'attachmentURL')->textInput(['placeholder' => 'https://example.com','class'=>'form-controller'])->label(false) ?>
                </div>
              </div>-->
                
              <div id="laporanPolisAttachmentNotNull">
                <div class="col-sm-4" id="laporan_polis_img_del">
                <input type="hidden" id="loparanImagePath" name="PermohonanForm[laporan_polis_last_attachment]" value="<?php echo $mediaSocialResponse['laporan_polis'];?>"> 
                <?= Html::button("Padam",['class'=>'btn btn-primary',"id" => "laporanPolisDeleteImg"]);?>
                </div>
                
               
                <div class="col-sm-4 text-right" id="laporan_polis_img_download">
                <?= Html::button("Muat Turun | Papar",['class'=>'btn btn-primary',"id" => "laporanPolisViesDownloadImg"]);?>
                </div>
              </div>     
            </div>

            <br>
                    <div class="row">
                    <div class="col-md-6">
                    <legend class="col-form-label col-sm-4 pt-0">URL</legend>
               
                     <button type="button" id="add" class="add-item btn btn-success btn-xs">+</button>
                    </div>
                    </div>
                            <?php if(count($mediaSocialResponse['case_info_url_involved']) > 0 ){?>
<br>
                        <div class="row">
                           <div class="col-md-6" id="url_input_append">
                              <?php
               
                              //for($i=0;$i<=4;$i++)
                              //{
                                $k = 0;
                                foreach($mediaSocialResponse['case_info_url_involved'] as $key => $URLDbInfo):
                                $model->master_social_media_id[$key] = $URLDbInfo['master_social_media_id'];
                                $model->url[$key] = $URLDbInfo['url'];
                                ?>
                                
                                <?=  Html::hiddenInput('PermohonanForm[caseInfoURLInvolvedId]['.$key.']', $URLDbInfo['id']); ?>
                                <?php
                                echo $form->field($model, 'master_social_media_id['.$key.']')->dropDownList($masterSocialMedia,array('prompt' => '--Pilih Social Media--','id' => 'social_media_'.$k))->label(false);
                                echo $form->field($model, 'url['.$key.']')->textInput(['id' => 'social_media_URL_'.$k])->label(false); 
                                ?>
                                
                                <?php
                                $k++;
                                endforeach;
                                //}
                                ?> 
                            </div>
                        </div>
                          <?php } else { ?>
                            <div class="row">
                                  <div class="col-md-6" id="url_input_append">
                                      <?php
                                      for($i=0;$i<=4;$i++)
                                      {
                                        ?>
                                     <div class="row">
                                        <?php                    
                                      echo $form->field($model, 'new_master_social_media_id['.$i.']')->dropDownList($masterSocialMedia,array('prompt' => '--Pilih Social Media--','id' => 'social_media_'.$i))->label(false);
                                      echo $form->field($model, 'new_url['.$i.']')->textInput(['id' => 'social_media_URL_'.$i])->label(false); 
                                      ?>
                                    </div>
                                    <?php
                                    }
                                    ?> 
                                 </div>
                                <?php } ?>
                            </div>
                            
<br>
            <div class="row mb-3">
                <legend class="col-form-label col-sm-4 pt-0">Tujuan Permohanan</legend>
                <div class="col-sm-8">
                <?php  $model->application_purpose = explode(",",$mediaSocialResponse['master_status_purpose_of_application_id']); ?>
                <?= $form->field($model, 'application_purpose')->checkboxList($purposeOfApplication)->label(false);?>  
                <div id="application_purpose_info">
               
                <input type="text" name="PermohonanForm[application_purpose_info]" placeholder="Tujuan Permohanan" value="<?= $mediaSocialResponse['purpose_of_application_info']?>">
                </div> 
                </div>
            </div>
        </div>


    
    <div class="form-group">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<?php
$purposeOfApplicationIdValInfo = "";
$isSuratRasmiExists =  0;
$isLaporanPoliceExists =  0;
$statusSuspekCount = $count ? $count : 0;
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
  
  var statusSuspekCount = $statusSuspekCount-1;
 var newURLVal = 0;
$('#add').click(function(){ var newID =  ( $('#url_input_append > div').length);
if(newID < 15)
{
  //$('#url_input_append').append('<div class="row"><div class="form-group field-permohonanform-master_social_media_id"><select id="permohonanform-master_social_media_id['+newURLVal+']" class="form-control" name="PermohonanForm[new_master_social_media_id]['+newURLVal+']"><option value="">--Pilih Social Media--</option><option value="1">twitter</option><option value="2">instagram</option><option value="3">tumblr</option><option value="4">facebook</option><option value="5">blog / website</option></select><div class="help-block"></div></div><div class="form-group field-permohonanform-url-'+newURLVal+'"><input type="text" id="permohonanform-url-'+newURLVal+'" class="form-control" name="PermohonanForm[new_url]['+newURLVal+']"><div class="help-block"></div></div></div>');
  $('#url_input_append').append('<div class="row"><div class="form-group field-permohonanform-master_social_media_id"><select id="new_social_media_'+newURLVal+'" name="PermohonanForm[new_master_social_media_id]['+newURLVal+']"><option value="">--Pilih Social Media--</option><option value="39">twitter</option><option value="40">instagram</option><option value="41">tumblr</option><option value="42">facebook</option><option value="43">blog / website</option><option value="99">Youtube</option><option value="100">Tiktok</option><option value="101">Others</option></select><div class="help-block"></div></div><div class="form-group field-permohonanform-url-'+newURLVal+'"><input type="text" id="new_social_media_URL_'+newURLVal+'" class="form-control" name="PermohonanForm[new_url]['+newURLVal+']"><div class="help-block"></div></div></div>');
  ++newURLVal;
}
else{
  alert("Can't create new field");
  return false;
}
  
});
var prevVal = "no";
var newValStart = 0;
if($("#prev_case_info_status_suspek").val() > 0)
{
  prevVal = "yes";
}

var new_suspek_increment_val = $("#prev_case_info_status_suspek").val();
$('#add_ic_name').click(function(){ //alert(new_suspek_increment_val);return false;
  
 // new_suspek_increment_val = $("#prev_case_info_status_suspek").val();
  if(prevVal == "no" && new_suspek_increment_val <= 3)
{
  ++new_suspek_increment_val;
  $('#id_name').append('<div class="row"><div class="form-group field-permohonanform-master_status_suspect_or_saksi_id-'+new_suspek_increment_val+' required"><select name="PermohonanForm[new_master_status_suspect_or_saksi_id]['+new_suspek_increment_val+']" class="form-control" id="permohonanform-new_master_status_suspect_or_saksi_id-'+new_suspek_increment_val+'"><option value="">--Pilih Option--</option><option value="86">Suspect</option><option value="87">Witness</option></select><div class="help-block"></div></div></div><div class="row"><div class="form-group field-permohonanform-master_status_status_suspek_id-'+new_suspek_increment_val+'"><select name="PermohonanForm[new_master_status_status_suspek_id]['+new_suspek_increment_val+']" class="form-control" id="new_master_status_status_suspek_id_'+new_suspek_increment_val+'"><option value="">--Pilih Option--</option><option value="60">Tiada maklumat mengenai suspek/sakhi</option><option value="61">Identiti suspek(Nama dan KPT) sudah dikenalpasti</option><option value="62">Suspek telah ditahan</option><option value="63">Suspek dibebaskan dengan jaminan</option><option value="64">Lain-lain sila nyatakan</option></select><div class="help-block"></div></div></div><div class="row"><div class="col-sm-4"><div class="form-group field-permohonanform-ic-0"><input type="text" id="new_ic_'+new_suspek_increment_val+'" class="form-control" name="PermohonanForm[new_ic]['+new_suspek_increment_val+']" placeholder="IC"><div class="help-block"></div></div></div><div class="col-sm-4"  id="new_add_text_areabox-'+new_suspek_increment_val+'"><div class="form-group field-permohonanform-name-0"><input type="text" id="new_name_'+new_suspek_increment_val+'" class="form-control" name="PermohonanForm[new_name]['+new_suspek_increment_val+']" placeholder="Name"><div class="help-block"></div></div></div></div>');  
}
else if(prevVal == "yes" && new_suspek_increment_val < 5)
{ 
  $('#id_name').append('<div class="row"><div class="form-group field-permohonanform-master_status_suspect_or_saksi_id-'+newValStart+' required"><select name="PermohonanForm[new_master_status_suspect_or_saksi_id]['+newValStart+']" class="form-control" id="permohonanform-new_master_status_suspect_or_saksi_id-'+newValStart+'"><option value="">--Pilih Option--</option><option value="86">Suspect</option><option value="87">Witness</option></select><div class="help-block"></div></div></div><div class="row"><div class="form-group field-permohonanform-master_status_status_suspek_id-'+newValStart+'"><select name="PermohonanForm[new_master_status_status_suspek_id]['+newValStart+']" class="form-control" id="new_master_status_status_suspek_id_'+newValStart+'"><option value="">--Pilih Option--</option><option value="60">Tiada maklumat mengenai suspek/sakhi</option><option value="61">Identiti suspek(Nama dan KPT) sudah dikenalpasti</option><option value="62">Suspek telah ditahan</option><option value="63">Suspek dibebaskan dengan jaminan</option><option value="64">Lain-lain sila nyatakan</option></select><div class="help-block"></div></div></div><div class="row"><div class="col-sm-4"><div class="form-group field-permohonanform-ic-0"><input type="text" id="new_ic_'+newValStart+'" class="form-control" name="PermohonanForm[new_ic]['+newValStart+']" placeholder="IC"><div class="help-block"></div></div></div><div class="col-sm-4" id="new_add_text_areabox-'+newValStart+'"><div class="form-group field-permohonanform-name-0"><input type="text" id="new_name_'+newValStart+'" class="form-control" name="PermohonanForm[new_name]['+newValStart+']" placeholder="Name"><div class="help-block"></div></div></div></div>');  
  ++newValStart;
  ++new_suspek_increment_val;
}
else{
  alert("Can't create new field");
  return false;
}

  //alert(++new_suspek_increment_val);//var asd = "#id_name_"+statusSuspekCount; var newSuspek = statusSuspekCount+1; var newIDInfo =  ($(asd+' > div').length); newIdVal = (newIDInfo / 2)+1; alert(newIdVal);
  /*if(newIdVal < 5)
{
  $(asd).append('<div class="row"><div class="form-group field-permohonanform-master_status_suspect_or_saksi_id-'+newSuspek+' required"><select id="permohonanform-master_status_suspect_or_saksi_id-'+newSuspek+'" class="form-control" name="PermohonanForm[master_status_suspect_or_saksi_id]['+newSuspek+']"><option value="">--Pilih Suspek or Saksi--</option><option value="14">Suspek</option><option value="15">Saksi</option></select><div class="help-block"></div></div></div><div class="row"><div class="form-group field-permohonanform-master_status_status_suspek_id-'+newSuspek+'"><select id="permohonanform-master_status_status_suspek_id-'+newSuspek+'" class="form-control" name="PermohonanForm[master_status_status_suspek_id]['+newSuspek+']"><option value="">--Pilih Option--</option><option value="18">Tiada maklumat mengenai suspek/sakhi</option><option value="19">Identiti suspek(Nama dan KPT) sudah dikenalpasti, tetapi belum ditahan</option><option value="20">Suspek telah ditahan</option><option value="21">Suspek dibebaskan dengan jaminan</option><option value="22">Lain-lain sila nyatakan</option></select><div class="help-block"></div></div></div><div class="row"><div class="col-sm-4"><div class="form-group field-permohonanform-ic-0"><input type="text" id="permohonanform-ic-0" class="form-control" name="PermohonanForm[ic]['+newSuspek+']" placeholder="IC"><div class="help-block"></div></div></div><div class="col-sm-4" id="add_text_areabox-'+newSuspek+'"><div class="form-group field-permohonanform-name-0"><input type="text" id="permohonanform-name-0" class="form-control" name="PermohonanForm[name]['+newSuspek+']" placeholder="Name"><div class="help-block"></div></div></div></div>');
}
else{
  alert("Can't create new field");
  
}*/return false;
});
var others_1 = 1;var others_2 = 1;var others_3 = 1;var others_4 = 1;var others_5 = 1;
$('#permohonanform-master_status_status_suspek_id-0').change(function(){ alert(this.value+' - '+others_1);  var newIDInfo =  ($('#id_name > div').length); newIdVal = (newIDInfo / 2)-1; //alert($('select[name="PermohonanForm[master_status_status_suspek_id][0]"]').val());
  if(this.value == 64 && others_1 < 2)
  { 
    $('#add_text_areabox-0').after('<div class="col-lg-8" id="status_suspek_others_0"><textarea class="form-control" name="PermohonanForm[others][0]"></textarea></div><div class="clearfix" id="clearfix_0"></div>');
    ++others_1;
  }
  else{
    $("#status_suspek_others_0").empty();
    $("#status_suspek_others_0").remove();
    $("#clearfix_0").remove();
    others_1 = 1;
  }
});
$('#permohonanform-master_status_status_suspek_id-1').change(function() {  var newIDInfo =  ($('#id_name > div').length); newIdVal = (newIDInfo / 2)-1; //alert($('select[name="PermohonanForm[master_status_status_suspek_id][0]"]').val());
  if(this.value == 64 && others_2 < 2){
$('#add_text_areabox-1').after('<div class="col-lg-8" id="status_suspek_others_1"><textarea  class="form-control" name="PermohonanForm[others][1]"></textarea></div><div class="clearfix"></div><div class="clearfix" id="clearfix_1"></div>');
++others_2;
  }
  else{
    $("#status_suspek_others_1").empty();
    $("#status_suspek_others_1").remove();
    $("#clearfix_1").remove();
    others_2 = 1;
  }
});
$('#permohonanform-master_status_status_suspek_id-2').change(function() {  var newIDInfo =  ($('#id_name > div').length); newIdVal = (newIDInfo / 2)-1; //alert($('select[name="PermohonanForm[master_status_status_suspek_id][0]"]').val());
  if(this.value == 64 && others_3 < 2){
$('#add_text_areabox-2').after('<div class="col-lg-8" id="status_suspek_others_2"><textarea class="form-control" name="PermohonanForm[others][2]"></textarea></div><div class="clearfix"  id="clearfix_2"></div>');
++others_3;
  }
  else{
    $("#status_suspek_others_2").empty();
    $("#status_suspek_others_2").remove();
    $("#clearfix_1").remove();
    others_3 = 1;
  }
});
$('#permohonanform-master_status_status_suspek_id-3').change( function() {  var newIDInfo =  ($('#id_name > div').length); newIdVal = (newIDInfo / 2)-1; //alert($('select[name="PermohonanForm[master_status_status_suspek_id][0]"]').val());
  if(this.value == 64 && others_4 < 2){
$('#add_text_areabox-3').after('<div class="col-lg-8"  id="status_suspek_others_3"><textarea class="form-control" name="PermohonanForm[others][3]"></textarea></div><div class="clearfix"  id="clearfix_3"></div>');
++others_4;
  }
  else{
    $("#status_suspek_others_3").empty();
    $("#status_suspek_others_3").remove();
    $("#clearfix_1").remove();
    others_3 = 1;
  }
});
$('#permohonanform-master_status_status_suspek_id-4').change( function() {  var newIDInfo =  ($('#id_name > div').length); newIdVal = (newIDInfo / 2)-1; //alert($('select[name="PermohonanForm[master_status_status_suspek_id][0]"]').val());
  if(this.value == 64  && others_5 < 2){
$('#add_text_areabox-4').after('<div class="col-lg-8"  id="status_suspek_others_4"><textarea class="form-control" name="PermohonanForm[others][4]"></textarea></div><div class="clearfix"  id="clearfix_4"></div>');
++others_5;
  }
  else{
    $("#status_suspek_others_4").empty();
    $("#status_suspek_others_4").remove();
    $("#clearfix_4").remove();
    others_4 = 1;
  }
});


// new suspek dynamic filed if user choose others then text area box show in new suspek fileds
var new_others_1 = 1;var new_others_2 = 1;var new_others_3 = 1;var new_others_4 = 1;var new_others_5 = 1;

$('#id_name').on('change','#new_master_status_status_suspek_id_0', function() {  
  if(this.value == 64  && new_others_1 < 2){
$('#new_add_text_areabox-0').after('<div class="col-lg-8" id="new_status_suspek_others_0"><textarea  class="form-control" name="PermohonanForm[new_others][0]"></textarea></div><div class="clearfix" id="clearfix_0"></div>');
++new_others_1;
  }
  else{
    //$("#new_status_suspek_others_0").remove();
    $("#new_status_suspek_others_0").empty();
    $("#new_status_suspek_others_0").remove();
    $("#clearfix_0").remove();
    new_others_1 = 1;
  }
});

$('#id_name').on('change','#new_master_status_status_suspek_id_1', function() { 
  if(this.value == 64  && new_others_2 < 2){
$('#new_add_text_areabox-1').after('<div class="col-lg-8" id="new_status_suspek_others_1"><textarea class="form-control" name="PermohonanForm[new_others][1]"></textarea></div><div class="clearfix" id="clearfix_1"></div>');
++new_others_2;
  }
  else{
    $("#new_status_suspek_others_1").empty();
    $("#new_status_suspek_others_1").remove();
    $("#clearfix_1").remove();
    new_others_2 = 1;
  }
});

$('#id_name').on('change','#new_master_status_status_suspek_id_2', function() { 
  if(this.value == 64  && new_others_3 < 2){
$('#new_add_text_areabox-2').after('<div class="col-lg-8" id="new_status_suspek_others_2"><textarea  class="form-control" name="PermohonanForm[new_others][2]"></textarea></div><div class="clearfix" id="clearfix_2"></div>');
++new_others_3;
  }
  else{
    $("#new_status_suspek_others_2").empty();
    $("#new_status_suspek_others_2").remove();
    $("#clearfix_2").remove();
    new_others_3 = 1;
  }
});

$('#id_name').on('change','#new_master_status_status_suspek_id_3', function() { 
  if(this.value == 64  && new_others_4 < 2){
$('#new_add_text_areabox-3').after('<div class="col-lg-8" id="new_status_suspek_others_3"><textarea  class="form-control" name="PermohonanForm[new_others][3]"></textarea></div><div class="clearfix" id="clearfix_3"></div>');
++new_others_4;
  }
  else{
    $("#new_status_suspek_others_3").empty();
    $("#new_status_suspek_others_3").remove();
    $("#clearfix_3").remove();
    new_others_4 = 1;
  }
});

$('#id_name').on('change','#new_master_status_status_suspek_id_4', function() { 
  if(this.value == 64  && new_others_5 < 2){
$('#new_add_text_areabox-4').after('<div class="col-lg-8" id="new_status_suspek_others_4"><textarea  class="form-control" name="PermohonanForm[new_others][4]"></textarea></div><div class="clearfix" id="clearfix_4"></div>');
++new_others_5;
  }
  else{
    $("#new_status_suspek_others_4").empty();
    $("#new_status_suspek_others_4").remove();
    $("#clearfix_4").remove();
    new_others_5 = 1;
  }
});



$('#new_master_status_status_suspek_id_2').change( function() { 
  if(this.value == 64  && new_others_3 < 2){
$('#new_add_text_areabox-2').after('<div class="col-lg-8"><textarea id="new_status_suspek_others_2" class="form-control" name="PermohonanForm[new_others][2]"></textarea></div><div class="clearfix"></div>');
++new_others_3;
  }
  else{
    $("#new_status_suspek_others_2").remove();
    new_others_3 = 1;
  }
});

$('#new_master_status_status_suspek_id_3').change( function() { 
  if(this.value == 64  && new_others_4 < 2){
$('#new_add_text_areabox-3').after('<div class="col-lg-8"><textarea id="new_status_suspek_others_3" class="form-control" name="PermohonanForm[new_others][3]"></textarea></div><div class="clearfix"></div>');
++new_others_4;
  }
  else{
    $("#new_status_suspek_others_3").remove();
    new_others_4 = 1;
  }
});

$('#new_master_status_status_suspek_id_4').change( function() { 
  if(this.value == 64  && new_others_5 < 2){
$('#new_add_text_areabox-4').after('<div class="col-lg-8"><textarea id="new_status_suspek_others_4" class="form-control" name="PermohonanForm[new_others][4]"></textarea></div><div class="clearfix"></div>');
++new_others_5;
  }
  else{
    $("#new_status_suspek_others_4").remove();
    new_others_5 = 1;
  }
});

$('#new_master_status_suspect_or_saksi_id_0').change(function(){
  if(this.value == 86 ||  this.value == 87)
  { 
    $("#new_master_status_status_suspek_id_0 option[value=60]").prop("selected", "selected");
  }
});

$('#id_name').on('change','#permohonanform-new_master_status_suspect_or_saksi_id-1', function() {  
if(this.value == 86 ||  this.value == 87)
{ 
$("#new_master_status_status_suspek_id_1 option[value=60]").prop("selected", "selected");
}  
});

$('#id_name').on('change','#permohonanform-new_master_status_suspect_or_saksi_id-2', function() {  
if(this.value == 86 ||  this.value == 87)
{ 
$("#new_master_status_status_suspek_id_2 option[value=60]").prop("selected", "selected");
}  
});

$('#id_name').on('change','#permohonanform-new_master_status_suspect_or_saksi_id-3', function() {  
if(this.value == 86 ||  this.value == 87)
{ 
$("#new_master_status_status_suspek_id_3 option[value=60]").prop("selected", "selected");
}  
});

$('#id_name').on('change','#permohonanform-new_master_status_suspect_or_saksi_id-4', function() {  
if(this.value == 86 ||  this.value == 87)
{ 
$("#new_master_status_status_suspek_id_4 option[value=60]").prop("selected", "selected");
}  
});



$('#permohonanform-master_status_suspect_or_saksi_id-0').change(function(){
  if(this.value == 86 ||  this.value == 87)
  { 
    $("#permohonanform-master_status_status_suspek_id-0 option[value=60]").prop("selected", "selected");
  }
});

$('#id_name').on('change','#permohonanform-master_status_suspect_or_saksi_id-1', function() {  
                            
  if(this.value == 86 ||  this.value == 87)
  { 
    $("#permohonanform-master_status_status_suspek_id-1 option[value=60]").prop("selected", "selected");
  }  
});

  $('#permohonanform-master_status_suspect_or_saksi_id-1').change(function() {                              
  if(this.value == 86 ||  this.value == 87)
  { 
  $("#permohonanform-master_status_status_suspek_id-1 option[value=60]").prop("selected", "selected");
  }  
  });

$('#id_name').on('change','#permohonanform-master_status_suspect_or_saksi_id-2', function() {  
  if(this.value == 86 ||  this.value == 87)
  { 
    $("#permohonanform-master_status_status_suspek_id-2 option[value=60]").prop("selected", "selected");
  }  
});
  $('#permohonanform-master_status_suspect_or_saksi_id-2').change(function() {                              
  if(this.value == 86 ||  this.value == 87)
  { 
  $("#permohonanform-master_status_status_suspek_id-2 option[value=60]").prop("selected", "selected");
  }  
  });
$('#id_name').on('change','#permohonanform-master_status_suspect_or_saksi_id-3', function() {  
  if(this.value == 86 ||  this.value == 87)
  { 
    $("#permohonanform-master_status_status_suspek_id-3 option[value=60]").prop("selected", "selected");
  }  
});
  $('#permohonanform-master_status_suspect_or_saksi_id-3').change(function() {                              
  if(this.value == 86 ||  this.value == 87)
  { 
  $("#permohonanform-master_status_status_suspek_id-3 option[value=60]").prop("selected", "selected");
  }  
  });
$('#id_name').on('change','#permohonanform-master_status_suspect_or_saksi_id-4', function() {  
  if(this.value == 86 ||  this.value == 87)
  { 
    $("#permohonanform-master_status_status_suspek_id-4 option[value=60]").prop("selected", "selected");
  }  
});

  $('#permohonanform-master_status_suspect_or_saksi_id-4').change(function() {                              
  if(this.value == 86 ||  this.value == 87)
  { 
  $("#permohonanform-master_status_status_suspek_id-4 option[value=60]").prop("selected", "selected");
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

$('#url_input_append').on('change','#new_social_media_0', function() { 
  if(URL_obj.find(item => item.id == $("#new_social_media_0").val())){ var item_val = URL_obj.find(item => item.id == $("#new_social_media_0").val()); $("#new_social_media_URL_0").val(item_val.name);}
});
$('#url_input_append').on('change','#new_social_media_1', function() { 
  if(URL_obj.find(item => item.id == $("#new_social_media_1").val())){ var item_val = URL_obj.find(item => item.id == $("#new_social_media_1").val()); $("#new_social_media_URL_1").val(item_val.name);}
});
$('#url_input_append').on('change','#new_social_media_2', function() { 
  if(URL_obj.find(item => item.id == $("#new_social_media_2").val())){ var item_val = URL_obj.find(item => item.id == $("#new_social_media_2").val()); $("#new_social_media_URL_2").val(item_val.name);}
});
$('#url_input_append').on('change','#new_social_media_3', function() { 
  if(URL_obj.find(item => item.id == $("#new_social_media_3").val())){ var item_val = URL_obj.find(item => item.id == $("#new_social_media_3").val()); $("#new_social_media_URL_3").val(item_val.name);}
});
$('#url_input_append').on('change','#new_social_media_4', function() { 
  if(URL_obj.find(item => item.id == $("#new_social_media_4").val())){ var item_val = URL_obj.find(item => item.id == $("#new_social_media_4").val()); $("#new_social_media_URL_4").val(item_val.name);}
});
$('#url_input_append').on('change','#new_social_media_5', function() { 
  if(URL_obj.find(item => item.id == $("#new_social_media_5").val())){ var item_val = URL_obj.find(item => item.id == $("#new_social_media_5").val()); $("#new_social_media_URL_5").val(item_val.name);}
});
$('#url_input_append').on('change','#new_social_media_6', function() { 
  if(URL_obj.find(item => item.id == $("#new_social_media_6").val())){ var item_val = URL_obj.find(item => item.id == $("#new_social_media_6").val()); $("#new_social_media_URL_6").val(item_val.name);}
});
$('#url_input_append').on('change','#new_social_media_7', function() { 
  if(URL_obj.find(item => item.id == $("#new_social_media_7").val())){ var item_val = URL_obj.find(item => item.id == $("#new_social_media_7").val()); $("#new_social_media_URL_7").val(item_val.name);}
});
$('#url_input_append').on('change','#new_social_media_8', function() { 
  if(URL_obj.find(item => item.id == $("#new_social_media_8").val())){ var item_val = URL_obj.find(item => item.id == $("#new_social_media_8").val()); $("#new_social_media_URL_8").val(item_val.name);}
});
$('#url_input_append').on('change','#new_social_media_9', function() { 
  if(URL_obj.find(item => item.id == $("#new_social_media_9").val())){ var item_val = URL_obj.find(item => item.id == $("#new_social_media_9").val()); $("#new_social_media_URL_9").val(item_val.name);}
});
$('#url_input_append').on('change','#new_social_media_10', function() { 
  if(URL_obj.find(item => item.id == $("#new_social_media_10").val())){ var item_val = URL_obj.find(item => item.id == $("#new_social_media_10").val()); $("#new_social_media_URL_10").val(item_val.name);}
});
$('#url_input_append').on('change','#new_social_media_11', function() { 
  if(URL_obj.find(item => item.id == $("#new_social_media_11").val())){ var item_val = URL_obj.find(item => item.id == $("#new_social_media_11").val()); $("#new_social_media_URL_11").val(item_val.name);}
});
$('#url_input_append').on('change','#new_social_media_12', function() { 
  if(URL_obj.find(item => item.id == $("#new_social_media_12").val())){ var item_val = URL_obj.find(item => item.id == $("#new_social_media_12").val()); $("#new_social_media_URL_12").val(item_val.name);}
});
$('#url_input_append').on('change','#new_social_media_13', function() { 
  if(URL_obj.find(item => item.id == $("#new_social_media_13").val())){ var item_val = URL_obj.find(item => item.id == $("#new_social_media_13").val()); $("#new_social_media_URL_13").val(item_val.name);}
});
$('#url_input_append').on('change','#new_social_media_14', function() { 
  if(URL_obj.find(item => item.id == $("#new_social_media_14").val())){ var item_val = URL_obj.find(item => item.id == $("#new_social_media_14").val()); $("#new_social_media_URL_14").val(item_val.name);}
});
$('#url_input_append').on('change','#new_social_media_15', function() { 
  if(URL_obj.find(item => item.id == $("#new_social_media_15").val())){ var item_val = URL_obj.find(item => item.id == $("#new_social_media_15").val()); $("#new_social_media_URL_15").val(item_val.name);}
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
