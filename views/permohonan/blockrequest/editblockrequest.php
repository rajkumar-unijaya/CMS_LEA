<?php

/* @var $this yii\web\View */

namespace app\widgets;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use Yii;
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
<?php $form = ActiveForm::begin(['enableClientValidation' => true,'options' => ['enctype' => 'multipart/form-data']]); ?>
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
        
      <?= $form->field($model, 'offence')->dropDownList($prevSelectedOffences,array('id' => 'mySideToSideSelect_to','class' => 'form-control','size' => 10,'multiple'=>'multiple','prompt' => 'Pilih Kesalahan','options' => $offencesListRes))->label(false); ?>
                  
      </div>
    </div>
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
        <!-- rams -->
      

            
            <!-- end rams -->
<br>
  <!--URL--> 
                      <div class="row">
                      <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Link (URL)</label>
                                    <button type="button" class="btn btn-info m-b-20" id="add">
	                                     <i class="fa fa-plus text"></i>
	                                  </button> 
                                    <div class="form-group">
                                    
                                  <div id="url_input_append">
                                    <?php
                                    for($i=0;$i<=4;$i++)
                                    {
                                      ?>
                                      <div class="row">
                                      <?php
                                    echo $form->field($model, 'master_social_media_id['.$i.']')->dropDownList($masterSocialMedia,array('prompt' => 'Pilih Sosial Media','id' => 'social_media_'.$i))->label(false);
                                    echo $form->field($model, 'url['.$i.']')->textInput(['id' => 'social_media_URL_'.$i])->label(false); 
                                    ?>
                                    </div>
                                    <?php
                                    }
                                    ?> 
                                  </div>
                                    </div>
                                </div>
                      </div>
                      </div>
              <!--/button--> <br>
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

var newURLVal = 0;
$('#add').click(function(){ var newID =  ( $('#url_input_append > div').length);
if(newID < 15)
{
  //$('#url_input_append').append('<div class="row"><div class="form-group field-permohonanform-master_social_media_id"><select id="permohonanform-master_social_media_id['+newURLVal+']" class="form-control" name="PermohonanForm[new_master_social_media_id]['+newURLVal+']"><option value="">--Pilih Social Media--</option><option value="1">twitter</option><option value="2">instagram</option><option value="3">tumblr</option><option value="4">facebook</option><option value="5">blog / website</option></select><div class="help-block"></div></div><div class="form-group field-permohonanform-url-'+newURLVal+'"><input type="text" id="permohonanform-url-'+newURLVal+'" class="form-control" name="PermohonanForm[new_url]['+newURLVal+']"><div class="help-block"></div></div></div>');
  $('#url_input_append').append('<div class="row"><div class="form-group field-permohonanform-master_social_media_id"><select id="new_social_media_'+newURLVal+'" name="BlockRequestForm[new_master_social_media_id]['+newURLVal+']" class="form-control"><option value="">--Pilih Social Media--</option><option value="39">twitter</option><option value="40">instagram</option><option value="41">tumblr</option><option value="42">facebook</option><option value="43">blog / website</option><option value="99">Yourtube</option><option value="100">Tiktok</option><option value="101">Others</option></select><div class="help-block"></div></div><div class="form-group field-permohonanform-url-'+newURLVal+'"><input type="text" id="new_social_media_URL_'+newURLVal+'" class="form-control" name="BlockRequestForm[new_url]['+newURLVal+']"><div class="help-block"></div></div></div>');
  
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
