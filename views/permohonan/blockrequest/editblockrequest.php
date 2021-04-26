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
<!-- ============================================================== -->
		<!-- Bread crumb and right sidebar toggle -->
		<!-- ============================================================== -->
		<div class="row page-titles">
			<div class="col-md-5 col-8 align-self-center">
				<h1 class="text-themecolor" style="padding-top: 2rem;">Permohonan Penyekatan</h1>
        <nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="../permohonan/block-request-list">Laman Utama</a></li>
					<li class="breadcrumb-item active">Permohonan Penyekatan</li>
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
				<div class="card card-outline-info">

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
<?php $form = ActiveForm::begin(['enableClientValidation' => true,'id' => 'dynamic-form','options' => ['enctype' => 'multipart/form-data']]); ?>
           
                     
              <!--/button--> <br>
           <?= $form->field($model, 'master_case_info_type_id')->hiddenInput(['value' => $mediaSocialResponse['master_case_info_type_id']])->label(false); ?>
           <?=  Html::hiddenInput('BlockRequestForm[caseInfoID]', $mediaSocialResponse['id']); ?> 
           <?=  Html::hiddenInput('BlockRequestForm[id]', $mediaSocialResponse['id'],["id" => "permohonanId"]); ?>          
              <!--no. Laporan Polis-->
              <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">No. Permohonan <span class="text-danger"></span></label>
                        <div class="controls">
                        <?= Html::input('text', 'case_no', $mediaSocialResponse['case_no'], ['class'=> 'form-control','readonly' => true]) ?>
                        </div>
                    </div>
                </div>

               <!--No. Kertas Siasatan-->
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">No. Kertas siasatan <span class="text-danger">*</span></label>
                        <div class="controls">
                        <?php  $model->investigation_no = $mediaSocialResponse['investigation_no']; ?>
                        <?= $form->field($model, 'investigation_no')->textInput(['placeholder' => 'No Kertas Siasatan'])->label(false) ?> 
                        </div>
                    </div>
                </div>
              </div>

<!--Kesalahan-->
              <label class="control-label">Kesalahan<span class="text-danger">*</span></label>
              <h5>Pilih Kesalahan</h5>
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
 <!--Ringkasan Kes-->
              <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label"> Ringkasan Kes<span class="text-danger">*</span></label>
                        <div class="controls">
                        <?php  $model->case_summary = $mediaSocialResponse['case_summary']; ?>
                        <?= $form->field($model, 'case_summary')->textarea(['class' => 'form-control','rows' => "5"])->label(false); ?>
                        </div>
                    </div>
                </div>
              </div>
<br>
<!--URL--> 
  <!-- rams start --><div class="row"> 
  <div class="col-sm-6">
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

<div class="panel panel-default">
        <div class="panel-heading">
            URL
            <button type="button" class="pull-right add-item btn btn-success btn-xs"><i class="fa fa-plus"></i> URL</button>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body container-items"><!-- widgetContainer -->
            <?php 
            //foreach ($modelsAddress as $index => $modelAddress):
            foreach ($modelUrl as $index => $modelurl): ?>
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                        <span class="panel-title-address">URL: <?= ($index + 1) ?></span>
                        <button type="button" class="pull-right remove-item btn btn-danger btn-xs"><i class="fa fa-minus"></i></button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                            // necessary for update action.
                            
                            //Html::hiddenInput('PermohonanUrl['.$index.'][caseInfoURLInvolvedId]', $modelUrl['id']);
                            //echo"<pre>";print_r($URLDbInfo);
                            //echo"<pre>";print_r($modelurl);exit;
                        ?>
                        
                        <div class="row">
                            <div class="col-sm-6">
                                <?= $form->field($modelurl, "[{$index}]master_social_media_id")->dropDownList($masterSocialMedia,array('prompt' => 'Pilih Sosial Media','options' => array($modelurl['master_social_media_id'] => array('selected'=>true))))->label(false);?> 
                            </div>
                            <div class="col-sm-6">
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

          <br>  
    <!--</div>
    </div>-->
    <!-- rams end -->
  <!-- Surat Rasmi-->         
  <h4 class="m-t-20"style="color:#337ab7"> URL Terbabit/Email/ Nama Pengguna Social Media/Etc.</h4>
      <hr>
        <div class="row">
          <div class="col-md-6">
                  <div class="form-group">
                    <label>Surat Rasmi</label><br>
                      <div class="col-sm-0" id="suratRasmiAttachmentIsNull">
                        <?= $form->field($model, 'surat_rasmi')->fileInput()->label(false);?>
                        
                      </div>
                      <small>(format file : .DOC, .DOCX, .JPG, .JPEG, .PNG, .PDF)</small>
                        <div id="fileList"></div> 
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
                </div>
          </div>
        </div>
        <br>
  <!--Laporan Polis-->   
  <div class="row">       
            <div class="col-md-6">
                <div class="form-group">
                    <label>Laporan Polis</label>
                    <br>
                      <div class="col-sm-0" id="laporanPolisAttachmentIsNull">
                        <?= $form->field($model, 'laporan_polis')->fileInput(['accept' => 'image/*'])->label(false);?>
                      </div>
                           <small>(format file : .DOC, .DOCX, .JPG, .JPEG, .PNG, .PDF)</small>
                        <div id="fileList"></div>
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
                </div>
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
  $(".dynamicform_wrapper").on("afterInsert", function(e, item) { 
    $(".dynamicform_wrapper .panel-title-address").each(function(index) {
        $(this).html("URL: " + (index + 1))
    });
});

$(".dynamicform_wrapper").on("afterDelete", function(e) { 
    $(".dynamicform_wrapper .panel-title-address").each(function(index) {
        $(this).html("URL: " + (index + 1))
    });
});

$(".dynamicform_wrapper").on("beforeDelete", function(e, item) {
    if (! confirm("Are you sure you want to delete this item?")) {
        return false;
    }
    return true;
});
var URL_obj = [{id:39, name:"https://twitter.com/"}, {id:40, name:"https://www.instagram.com/"}, {id:41, name:"https://www.tumblr.com/"}, {id:42, name:"https://www.facebook.com/"}, {id:99, name:"https://www.youtube.com/"}, {id:100, name:"https://www.tiktok.com/"}];

$(".dynamicform_wrapper").on("beforeInsert", function(e, item) { 

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
    //console.log("beforeInsert");
});

  $("#add_options").click(function(){
    $("#mySideToSideSelect option:selected").remove().appendTo($("#mySideToSideSelect_to"));
})
$("#remove_options").click(function(){
    $("#mySideToSideSelect_to option:selected").remove().appendTo($("#mySideToSideSelect"));
})
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
    var valid = true;

});
JS; $this->registerJs($script, \yii\web\View::POS_END);

?>
