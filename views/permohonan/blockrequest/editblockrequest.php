<?php

/* @var $this yii\web\View */

namespace app\widgets;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use Yii;
?>

<div class="container-fluid">
<h1 class="text-themecolor" style="padding-top: 2rem;">Permohonan Penyekatan</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../permohonan/block-request-list">Laman Utama</a></li>
            <li class="breadcrumb-item active">Permohonan Penyekatan</li>
            
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
<?php //echo $mediaSocialResponse['case_no'];exit;?>
           <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
           <div class="row mb-3">
                <label for="inputPassword3" class="col-sm-4 col-form-label">No. Permohonan </label>
                <div class="col-sm-8">
                <?= Html::input('text', 'case_no', $mediaSocialResponse['case_no'], ['class'=> 'form-control','readonly' => true]) ?>
                
                </div>
            </div>
           <?= $form->field($model, 'master_case_info_type_id')->hiddenInput(['value' => $mediaSocialResponse['master_case_info_type_id']])->label(false); ?>
           <?=  Html::hiddenInput('BlockRequestForm[caseInfoID]', $mediaSocialResponse['id']); ?> 
           <?=  Html::hiddenInput('BlockRequestForm[id]', $mediaSocialResponse['id'],["id" => "permohonanId"]); ?>
           
            <div class="row mb-3">
                <label for="inputPassword3" class="col-sm-4 col-form-label">No. Kertas Siasatan </label>
                <div class="col-sm-8">
                <?php  $model->investigation_no = $mediaSocialResponse['investigation_no']; ?>
                <?= $form->field($model, 'investigation_no')->textInput(['placeholder' => 'No Kertas Siasatan'])->label(false) ?> 
                </div>
            </div>

            <div class="row mb-3">
                <legend class="col-form-label col-sm-4 pt-0">Kesalahan</legend>
                <div class="col-sm-8">
                <?php 
                $offencesList = array();
                $i = 0;
                foreach($mediaSocialResponse['case_offence'] as $key => $offenceInfo):
                  $i++;
                  $offencesList[$offenceInfo['offence_id']] = array("selected"=>true);
                  //echo Html::hiddenInput("PermohonanForm[offenceId][".$key."]", $offenceInfo['id']);
                endforeach;
                ?>
                <?= $form->field($model, 'offence')->dropDownList($offences,array('multiple'=>'multiple','prompt' => '--Pilih Kesalahan--','options' => $offencesList))->label(false); ?>
                </div>
           </div>


            <div class="row mb-3">
                <label for="inputPassword3" class="col-sm-4 col-form-label">Ringkasan Kes </label>
                <div class="col-sm-8">
                <?php  $model->case_summary = $mediaSocialResponse['case_summary']; ?>
                <?= $form->field($model, 'case_summary')->textarea()->label(false); ?>
                </div>
            </div>

            <div class="row mb-3">
                <legend class="col-form-label col-sm-4 pt-0">Surat Rasmi</legend>
                
              <div class="col-sm-4" id="suratRasmiAttachmentIsNull">
                <?= $form->field($model, 'surat_rasmi')->fileInput()->label(false)->hint('fail format :  png | jpg | jpeg | pdf');?>
                
              </div>
                
              
              <div id="suratRasmiAttachmentNotNull">
                <div class="col-sm-4" id="surat_rasmi_img_del">
                <input type="hidden" id="suratRasmiImagePath" name="BlockRequestForm[surat_rasmi_last_attachment]" value="<?php echo $mediaSocialResponse['surat_rasmi'];?>">
                <?= Html::button("Padam",['class'=>'btn btn-primary deleteImg',"id" => "deleteImg"]);?>
                </div>
                
                <div class="col-sm-4 text-right" id="surat_rasmi_img_download">
                <?= Html::button("Muat Turun | Lihat",['class'=>'btn btn-primary',"id" => "suratRasmiViesDownloadImg"]);?>
                </div>
              </div>
                
            </div>

            <div class="row mb-3">
                <legend class="col-form-label col-sm-4 pt-0">Laporan Polis</legend>
                
              <div class="col-sm-4" id="laporanPolisAttachmentIsNull">
                <?= $form->field($model, 'laporan_polis')->fileInput(['accept' => 'image/*'])->label(false)->hint('fail format :  png | jpg | jpeg | pdf');?>
                
              </div>
                
                
              <div id="laporanPolisAttachmentNotNull">
                <div class="col-sm-4" id="laporan_polis_img_del">
                <input type="hidden" id="loparanImagePath" name="BlockRequestForm[laporan_polis_last_attachment]" value="<?php echo $mediaSocialResponse['laporan_polis'];?>"> 
                <?= Html::button("Delete",['class'=>'btn btn-primary',"id" => "laporanPolisDeleteImg"]);?>
                </div>
                
               
                <div class="col-sm-4 text-right" id="laporan_polis_img_download">
                <?= Html::button("Download | View",['class'=>'btn btn-primary',"id" => "laporanPolisViesDownloadImg"]);?>
                </div>
              </div>
               
                
            </div>

            <div class="row mb-3">
                <legend class="col-form-label col-sm-4 pt-0">URL</legend>
                <div class="pull-right">
                <button type="button" id="add" class="add-item btn btn-success btn-xs">+</button>
            </div>
            <?php if(count($mediaSocialResponse['case_info_url_involved']) > 0 ){?>
            <div class="col-sm-8" id="url_input_append">
                <?php
               
                //for($i=0;$i<=4;$i++)
                //{
                  $k = 0;
                  foreach($mediaSocialResponse['case_info_url_involved'] as $key => $URLDbInfo):
                  $model->master_social_media_id[$key] = $URLDbInfo['master_social_media_id'];
                  $model->url[$key] = $URLDbInfo['url'];
                  ?>
                  <div class="row">
                  <?=  Html::hiddenInput('BlockRequestForm[caseInfoURLInvolvedId]['.$key.']', $URLDbInfo['id']); ?>
                  <?php
                echo $form->field($model, 'master_social_media_id['.$key.']')->dropDownList($masterSocialMedia,array('prompt' => '--Pilih Social Media--','id' => 'social_media_'.$k))->label(false);
                echo $form->field($model, 'url['.$key.']')->textInput(['id' => 'social_media_URL_'.$k])->label(false); 
                ?>
                </div>
                <?php
                $k++;
                endforeach;
                //}
                ?> 
            </div>
              <?php } else { ?>
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
            <?php } ?>
            
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

?>

<?php
$isSuratRasmiExists =  0;
$isLaporanPoliceExists =  0;
$purposeOfApplicationIdVal = explode(",",$mediaSocialResponse['master_status_purpose_of_application_id']);
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
  xhttp.open("GET", "../permohonan/delete-block-request-surat-rasmi"+params, true);
  
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
  xhttp.open("GET", "../permohonan/delete-block-request-laporan-polis"+params, true);
  
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

var newURLVal = 0;
$('#add').click(function(){ var newID =  ( $('#url_input_append > div').length);
if(newID < 15)
{
  //$('#url_input_append').append('<div class="row"><div class="form-group field-permohonanform-master_social_media_id"><select id="permohonanform-master_social_media_id['+newURLVal+']" class="form-control" name="PermohonanForm[new_master_social_media_id]['+newURLVal+']"><option value="">--Pilih Social Media--</option><option value="1">twitter</option><option value="2">instagram</option><option value="3">tumblr</option><option value="4">facebook</option><option value="5">blog / website</option></select><div class="help-block"></div></div><div class="form-group field-permohonanform-url-'+newURLVal+'"><input type="text" id="permohonanform-url-'+newURLVal+'" class="form-control" name="PermohonanForm[new_url]['+newURLVal+']"><div class="help-block"></div></div></div>');
  $('#url_input_append').append('<div class="row"><div class="form-group field-permohonanform-master_social_media_id"><select id="new_social_media_'+newURLVal+'" name="BlockRequestForm[new_master_social_media_id]['+newURLVal+']"><option value="">--Pilih Social Media--</option><option value="39">twitter</option><option value="40">instagram</option><option value="41">tumblr</option><option value="42">facebook</option><option value="43">blog / website</option><option value="99">Yourtube</option><option value="100">Tiktok</option><option value="101">Others</option></select><div class="help-block"></div></div><div class="form-group field-permohonanform-url-'+newURLVal+'"><input type="text" id="new_social_media_URL_'+newURLVal+'" class="form-control" name="BlockRequestForm[new_url]['+newURLVal+']"><div class="help-block"></div></div></div>');
  
  ++newURLVal;
}
else{
  alert("Can't create new field");
  return false;
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
    var valid = true;

});
JS; $this->registerJs($script, \yii\web\View::POS_END);

?>
