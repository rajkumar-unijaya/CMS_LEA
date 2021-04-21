<?php

/* @var $this yii\web\View */

namespace app\widgets;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use Yii;
?>

<div class="container-fluid">
    <h1 style="padding-top: 1.5rem;">Permohonan Baru Sosial Media</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="../crawler/mntl-list">Permohonan Baru Sosial Media</a></li>
            
        </ol>
    </nav>
    <div class="card card-outline-info">
           <div class="card-body">
                                    <div  id="failed" class="info failedMsg">
                                        <?php if(Yii::$app->session->hasFlash('failed')):
                                         echo Yii::$app->session->getFlash('failed')[0];
                                        ?>
                                        <?php endif; ?>  
                                    </div>
        <div class="row">
        <div class="col-lg-12">

           <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
           <?= $form->field($model, 'masterCaseInfoTypeId')->hiddenInput(['value' => $masterCaseInfoTypeId])->label(false); ?>
           <div class="row">
            <div class="col-md-6">
              <label for="inputEmail3" class="col-sm-4 col-form-label">Pilihan Mengisi</label>
              <div class="col-md-12">
                    <?= $form->field($model, 'for_self')->radioList($newCase,array('class'=>'for_self'))->label(false); ?>
                    <div id="choose_forself">
                            <div class="col-md-12">
                            <label for="inputPassword3" class="col-sm-4 col-form-label">Nama </label>
                            <?= $form->field($model, 'selfName')->textInput(['placeholder' => 'Nama'])->label(false) ?>
                            <label for="inputPassword3" class="col-sm-4 col-form-label">E-mel </label>
                            <?= $form->field($model, 'email')->textInput(['placeholder' => 'E-mel'])->label(false) ?>
                            </div>
                               <div class="col-md-12">
                                  <div class="help-block-email" id="invalid_email"></div>
                                   <label for="inputPassword3" class="col-sm-4 col-form-label">No. Telefon </label>
                                    <?= $form->field($model, 'no_telephone')->textInput(['placeholder' => 'No. Telefon'])->label(false) ?>                
                              </div> 
                    </div>
              </div>
            </div>
           </div>
    <!--/span-->
<!-- ============================================================== -->
		<!-- Start new code-->
		<!-- ============================================================== -->

    <div class="form-body">
<h4 class="m-t-20" style="color:#337ab7" >Maklumat Permohonan Penyekatan</h4>
<hr>
          <div class="row">
						<div class="col-md-6">
							  <div class="form-group">
								    <label>Pilihan Mengisi <span class="text-danger">*</span></label>
								      <select class="custom-select" id="inquiry">
									        <option selected="">--Pilih Pilihan--</option>
									        <option value="1">Bagi Pihak</option>
									        <option value="2">Diri Sendiri</option>	
								      </select>
							  </div>
						  </div>
              </div>
      <!--/span-->
      <br>

          <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                      <label class="control-label">Nama<span class="text-danger">*</span></label>
                      <div class="controls">
                      <input type="text" id="nama" class="form-control" name="nama" data-validation-required-message="This field is required" required>
                      </div>
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                      <label class="control-label">E-mel<span class="text-danger">*</span></label>
                      <div class="controls">
                      <input type="text" id="emel" class="form-control" name="emel" data-validation-required-message="This field is required" required>
                      </div>
                  </div>
              </div>
              <!--/span-->
              </br>
              <div class="col-md-6">
                  <div class="form-group">
                      <label class="control-label">No. Telefon <span class="text-danger">*</span></label>
                      <div class="controls">
                      <input type="text" id="notelefon" class="form-control" name="notelefon" data-validation-required-message="This field is required" required>
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
 <!--Ringkasan Kes-->
            <!--/span-->
            <br>
           <div class="row">
           <div class="col-md-6">
                <label for="inputPassword3" >Ringkasan Kes </label>
                
                <?= $form->field($model, 'case_summary')->textarea()->label(false); ?>
                
            </div>
            </div>
        <!--/span-->
        <br>

            <div class="row">
            <div class="col-md-6">
                <label class="col-form-label col-sm-4 pt-0">Status Suspek / Saksi</label>
                        <button type="button" id="add_ic_name" class="add-item btn btn-success btn-xs">+</button>
                </div>
            </div>
            <br>
    <!--/span--><div class="form-group">
            <div class="row">
              <div class="col-md-6" id="id_name">
                        <?= $form->field($model, 'master_status_suspect_or_saksi_id[0]')->dropDownList($suspectOrSaksi,array('prompt' => '--Pilih Suspek or Saksi--'))->label(false); ?>
                    </div>
                   
                  <!--/span-->
                    
                      <div class="col-md-6">
                    <?= $form->field($model, 'master_status_status_suspek_id[0]')->dropDownList($masterStatusSuspect,['prompt' => '--Pilih Pilihan--'/*,'itemOptions'=>['class' => 'master_suspect_class']*/])->label(false);?>   
                      </div>
                    </div>
    <!--/span--><br>
                <div class="row">
                    <div class="col-md-6">
                    <?= $form->field($model, 'ic[0]')->textInput(['placeholder' => 'No. Kad Pengenalan'])->label(false);?> 
                    </div>
                    <div class="col-md-6" id="add_text_areabox-0"> 
                    <?= $form->field($model, 'name[0]')->textInput(['placeholder' => 'Nama'])->label(false);?>  
                    </div>  
                </div>
           </div>
    <!--/span-->
    <br>
    <h4 class="m-t-20"style="color:#337ab7"> URL Terbabit/Email/ Nama Pengguna Social Media/Etc.</h4>
      <hr>
            <div class="row">
                    <div class="col-md-6">
                    <label>Surat Rasmi</label>
                <?=  $form->field($model, 'surat_rasmi')->fileInput(['accept' => 'image/*'])->label(false)->hint('Lampiran hendaklah png | jpg | jpeg | pdf'); ?>
                </div>
            </div>

    <!--/span--><br>
            <div class="row">
                    <div class="col-md-6">
                    <label>Laporan Polis</label>
                <?= $form->field($model, 'laporan_polis')->fileInput(['accept' => 'image/*'])->label(false)->hint('Lampiran hendaklah png | jpg | jpeg | pdf');?>   
                </div>
            </div>
    <!--/span--><br>
            <div class="row">
                    <div class="col-md-6">
                <legend class="col-form-label col-sm-4 pt-0">Lampiran URL</legend>
                <?= $form->field($model, 'attachmentURL')->textInput(['placeholder' => 'URL'])->label(false) ?>
                </div>
            </div>

                <!--/span-->
                <br>
            <div class="row">
                <div class="col-md-6">
                      <label class="col-form-label col-sm-4 pt-0">URL</label>
                      <button type="button" id="add" class="add-item btn btn-success btn-xs">+</button>
                </div> </div>
                <br>
                
                <div class="row">
                    <div class="col-md-6" id="url_input_append">
                        <?php
                        for($i=0;$i<=4;$i++)
                        {
                          ?>
                          <?php
                        echo $form->field($model, 'master_social_media_id['.$i.']')->dropDownList($masterSocialMedia,array('prompt' => '--Pilih Social Media--','id' => 'social_media_'.$i))->label(false);
                        echo $form->field($model, 'url['.$i.']')->textInput(['id' => 'social_media_URL_'.$i])->label(false); 
                        ?>
                     
                          <?php
                          }
                          ?> 
                          </div>
            </div>
            
              <!--/span--><br>
              <h4 class="m-t-20"style="color:#337ab7"> Tujuan Permohonan</h4>
                <hr>
                <div class="row"> 
                            <div class="col-lg-6">
                                <label class="custom-control custom-radio"
                                    style="display: inline-block; padding-right: 30px;">
                                    <input type="radio" class="custom-control-input" name="agensi_action_id" value="0">
                                    <span class="custom-control-label">Mengenalpasti pengendali akaun/laman sosial/laman web<br>
                                        
                                </label>
                            </div>
                            <div class="col-lg-6 m-t-20">
                                <label class="custom-control custom-radio"
                                    style="display: inline-block; padding-right: 30px;">
                                    <input type="radio" class="custom-control-input" name="agensi_action_id" value="1">
                                    <span class="custom-control-label">Maklumat lain, sila nyatakan:<br>
                                </label>
                                <input type="text" id="agency_web" class="form-control"
                                    placeholder="">
                            </div>
                        </div>
         

<br>
            <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="text-right">
                                <div class="form-group">
                                     <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                                 </div>
                            </div>
                        </div>
                                 <div>

    <?php ActiveForm::end(); ?>
            </div>
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

  $("input[name='PermohonanForm[for_self]']").change(function() {
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
  //$('#url_input_append').append('<div class="row"><div class="form-group field-permohonanform-master_social_media_id"><select id="permohonanform-master_social_media_id['+newID+']" class="form-control" name="PermohonanForm[master_social_media_id]['+newID+']"><option value="">--Pilih Social Media--</option><option value="1">twitter</option><option value="2">instagram</option><option value="3">tumblr</option><option value="4">facebook</option><option value="5">blog / website</option></select><div class="help-block"></div></div><div class="form-group field-permohonanform-url-'+newID+'"><input type="text" id="permohonanform-url-'+newID+'" class="form-control" name="PermohonanForm[url]['+newID+']"><div class="help-block"></div></div></div>');
  $('#url_input_append').append('<div class="row"><div class="col-lg-12"><div class="form-group field-permohonanform-master_social_media_id"><select id="social_media_'+newID+'" class="form-control" name="PermohonanForm[master_social_media_id]['+newID+']"><option value="">--Pilih Social Media--</option><option value="39">twitter</option><option value="40">instagram</option><option value="41">tumblr</option><option value="42">facebook</option><option value="43">blog / website</option><option value="99">Youtube</option><option value="100">Tiktok</option><option value="101">Others</option></select><div class="help-block"></div></div><div class="form-group field-permohonanform-url-'+newID+'"><input type="text" id="social_media_URL_'+newID+'" class="form-control" name="PermohonanForm[url]['+newID+']"><div class="help-block"></div></div></div></div>');
}
else{
  alert("Perhatian,maksimum hanya 11 data");
  return false;
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
$('#id_name').on('change','#permohonanform-master_status_suspect_or_saksi_id-2', function() {  
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
$('#id_name').on('change','#permohonanform-master_status_suspect_or_saksi_id-4', function() {  
  if(this.value == 86 ||  this.value == 87)
  { 
    $("#permohonanform-master_status_status_suspek_id-4 option[value=60]").prop("selected", "selected");
  }  
});

$('#add_ic_name').click(function(){ var newIDInfo =  ($('#id_name > div').length); newIdVal = (newIDInfo / 3); 
  if(newIdVal < 5)
{
  $('#id_name').append('<div class="row"><div class="col-lg-12"><div class="form-group field-permohonanform-master_status_suspect_or_saksi_id-'+newIdVal+' required"><select id="permohonanform-master_status_suspect_or_saksi_id-'+newIdVal+'" class="form-control" name="PermohonanForm[master_status_suspect_or_saksi_id]['+newIdVal+']"><option value="">--Pilih Suspek or Saksi--</option><option value="86">Suspek</option><option value="87">Saksi</option></select><div class="help-block"></div></div></div><div class="col-lg-12"><div class="form-group field-permohonanform-master_status_status_suspek_id-'+newIdVal+'"><select id="permohonanform-master_status_status_suspek_id-'+newIdVal+'" class="form-control" name="PermohonanForm[master_status_status_suspek_id]['+newIdVal+']"><option value="">--Pilih Pilihan--</option><option value="60">Tiada maklumat mengenai suspek/saksi</option><option value="61">Identiti suspek(Nama dan KPT) sudah dikenalpasti, tetapi belum ditahan</option><option value="62">Suspek telah ditahan</option<option value="63">Suspek dibebaskan dengan jaminan</option><option value="64">Lain-lain sila nyatakan</option></select><div class="help-block"></div></div></div></div><div class="row"><div class="col-lg-12"><div class="form-group field-permohonanform-ic-0"><input type="text" id="permohonanform-ic-0" class="form-control" name="PermohonanForm[ic]['+newIdVal+']" placeholder="No. Kad Pengenalan"><div class="help-block"></div></div></div><div class="col-lg-12" id="add_text_areabox-'+newIdVal+'"><div class="form-group field-permohonanform-name-0"><input type="text" id="permohonanform-name-0" class="form-control" name="PermohonanForm[name]['+newIdVal+']" placeholder="Nama"><div class="help-block"></div></div></div></div>');
}
else{
  alert("Can't create new field");
  return false;
}
});
var others_1 = 1;var others_2 = 1;var others_3 = 1;var others_4 = 1;var others_5 = 1;

$('#permohonanform-master_status_status_suspek_id-0').change(function(){  var newIDInfo =  ($('#id_name > div').length); newIdVal = (newIDInfo / 2)-1; //alert($('select[name="PermohonanForm[master_status_status_suspek_id][0]"]').val());
  if(this.value == 64 && others_1 < 2)
  { 
    $('#add_text_areabox-0').after('<div class="col-lg-12" id="textarea_1"><textarea  class="form-control" name="PermohonanForm[others][0]"></textarea></div><div class="clearfix" id="clearfix_1"></div>');
    ++others_1;
  }
  else{
    $("#textarea_1").empty();
    $("#textarea_1").remove();
    $("#clearfix_1").remove();
    others_1 = 1;
  }
  
});

$('#id_name').on('change','#permohonanform-master_status_status_suspek_id-1', function() {  var newIDInfo =  ($('#id_name > div').length); newIdVal = (newIDInfo / 2)-1; //alert($('select[name="PermohonanForm[master_status_status_suspek_id][0]"]').val());
  if(this.value == 64 && others_2 < 2){ 
$('#add_text_areabox-1').after('<div class="col-lg-12" id="textarea_2"><textarea class="form-control" name="PermohonanForm[others][1]"></textarea></div><div class="clearfix" id="clearfix_2"></div>');
++others_2;
  }
  else{
    $("#textarea_2").empty();
    $("#textarea_2").remove();
    $("#clearfix_2").remove();
    others_2 = 1;
  }
});

$('#id_name').on('change','#permohonanform-master_status_status_suspek_id-2', function() {  var newIDInfo =  ($('#id_name > div').length); newIdVal = (newIDInfo / 2)-1; //alert($('select[name="PermohonanForm[master_status_status_suspek_id][0]"]').val());
  if(this.value == 64 && others_3 < 2){
$('#add_text_areabox-2').after('<div class="col-lg-12" id="textarea_3"><textarea class="form-control" name="PermohonanForm[others][2]"></textarea></div><div class="clearfix" id="clearfix_3"></div>');
++others_3;
  }
  else{
    $("#textarea_3").empty();
    $("#textarea_3").remove();
    $("#clearfix_3").remove();
    others_3 = 1;
  }
});

$('#id_name').on('change','#permohonanform-master_status_status_suspek_id-3', function() {  var newIDInfo =  ($('#id_name > div').length); newIdVal = (newIDInfo / 2)-1; //alert($('select[name="PermohonanForm[master_status_status_suspek_id][0]"]').val());
  if(this.value == 64 && others_4 < 2){
$('#add_text_areabox-3').after('<div class="col-lg-12" id="textarea_4"><textarea class="form-control" name="PermohonanForm[others][3]"></textarea></div><div class="clearfix" id="clearfix_4"></div>');
++others_4;
  }
  else{
    $("#textarea_4").empty();
    $("#textarea_4").remove();
    $("#clearfix_4").remove();
    others_4 = 1;
  }
});

$('#id_name').on('change','#permohonanform-master_status_status_suspek_id-4', function() {  var newIDInfo =  ($('#id_name > div').length); newIdVal = (newIDInfo / 2)-1; //alert($('select[name="PermohonanForm[master_status_status_suspek_id][0]"]').val());
  if(this.value == 64  && others_5 < 2){
$('#add_text_areabox-4').after('<div class="col-lg-12"  id="textarea_5"><textarea class="form-control" name="PermohonanForm[others][4]"></textarea></div><div class="clearfix"  id="clearfix_5"></div>');
++others_5;
  }
  else{
    $("#textarea_5").empty();
    $("#textarea_5").remove();
    $("#clearfix_5").remove();
    others_5 = 1;
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
