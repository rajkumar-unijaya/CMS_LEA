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
          <div class="row">
						<div class="col-md-6">
							  <div class="form-group">
								    <label>Pilihan Mengisi <span class="text-danger">*</span></label>
								      <select class="custom-select" id="inquiry">
									        <option selected="">Pilih Pilihan</option>
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
              <!--no. Laporan Polis-->
              <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                      <label class="control-label">No. Laporan Polis <span class="text-danger"></span></label>
                      <div class="controls">
                      <input type="text" id="" class="form-control" name="" data-validation-required-message="This field is required" required>
                      </div>
                  </div>
              </div>

              <!--No. Kertas Siasatan-->
              <div class="col-md-6">
                  <div class="form-group">
                      <label class="control-label">No. Kertas siasatan <span class="text-danger">*</span></label>
                      <div class="controls">
                      <input type="text" id="" class="form-control" name="" data-validation-required-message="This field is required" required>
                      </div>
                  </div>
              </div>
              </div>

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
              <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                      <label class="control-label"> Ringkasan Kes<span class="text-danger">*</span></label>
                      <div class="controls">
                      <textarea id="mymce" rows="5" type="text" id="path" class="form-control" name="aktiviti_lesen" data-validation-required-message="This field is required" required></textarea>
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
					  	<label>Surat Rasmi</label>
                  
						    <input type="file" id="file" accept=".doc,.docx,.pdf,image/*" multiple="multiple" onchange="javascript:updateList()" /><br /><small>(format file : .DOC, .DOCX, .JPG, .JPEG, .PNG, .PDF)</small>
						      <div id="fileList"></div>                     
				  	</div>
          </div>
</div>
  <!--Laporan Polis-->   
  <div class="row">       
          <div class="col-md-6">
            <div class="form-group">
					  	<label>Laporan Polis</label>
						    <input type="file" id="file" accept=".doc,.docx,.pdf,image/*" multiple="multiple" onchange="javascript:updateList()" /><br /><small>(format file : .DOC, .DOCX, .JPG, .JPEG, .PNG, .PDF)</small>
						      <div id="fileList"></div>
               </div>      
				  	</div>
          </div>
        </div>
<br>
  <!--URL--> 
                      <div class="row">
                      <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Link (URL)</label>
                                    <button type="button" class="btn btn-info m-b-20" id="button1">
	                                     <i class="fa fa-plus text"></i>
	                                  </button> 
                                    <div class="form-group">
                                    <select class="custom-select" id="inquiry">
                                      <option selected="">Pilih Sosial Media</option>
                                      <option value="1">Twitter</option>
                                      <option value="2">Facebook</option>
                                      <option value="3">Instagram</option>
                                      <option value="4">Tumblr</option>	
                                      <option value="5">Youtube</option>
                                      <option value="6">Tiktok</option>		
                                  </select>
                                  <input type="text" id="" class="form-control" name="">
                                    </div>
                                </div>
                      </div>
                      </div>
<br>
                      <!--/span-->
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
              <!--/button--> <br>
                      <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="text-right">

                                <button type="button" name="btnSave"
                                    class="btn  waves-effect-light btn-info btn-sm btnSave" data-toggle="tooltip"
                                    data-placement="left" title=""
                                    data-original-title="Click to submit and back to the main page"><i
                                        class="ti-check"></i>Hantar</button>
                                <a href="{{route('licensing.license.index')}}"
                                    class="btn waves-effect-light btn-danger btn-sm" data-toggle="tooltip"
                                    data-placement="left" title=""
                                    data-original-title="Click to cancel and back to the main page"><i
                                        class="ti-close"></i>
                                    Batal</a>
                            </div>
                        </div>
                    </div>
</div>
</div>
                                        </div></div>
<!-- end form design  -->

	<script src="../assets/plugins/dropify/dist/js/dropify.min.js"></script>
	<script>
		//block form field
		$("#name,#emel,#notelefon").hide();
		
		//control selection from inquiry
		$('#inquiry').change(function() {
			var zz = $(this).val();

			if (zz == 2) {

				$("#name,#emel,#notelefon").hide();

			} else {

				$("#name,#emel,#notelefon").show();

			}

		});

    pre = $("#search option").length + ' Record';
    $(".count-from").text(pre);
    $(".count-from").text("0 Record");

    $("#search").change(function(){

        text = $("#search").find("option").length + ' Record'+($("#search option").length>1?'s':'');
        balance = $("#search_to").find('option').length + ' Record'+($("#search_to").find('option').length>1?'s':'');
        //all = balance + ' Record';
        $(".count-from").text(text);
        $(".count-to").text(balance);
    });

    $("#search_to").change(function(){

        text = $("#search option").length + ' Record'+($("#search option").length>1?'s':'');
        balance = $("#search_to option").length + ' Record'+($("#search_to").find('option').length>1?'s':'')
        //all = balance + ' Record';
        $(".count-from").text(text);
        $(".count-to").text(balance);
    });

    $('#search').multiselect({
        search: {
            left: '<label class="control-label">Selectable Activity</label><input type="text" name="q" class="form-control" placeholder="Search..." style="margin-bottom:20px;"/>',
            right: '<label class="control-label">Selected Activity</label><input type="text" name="q" class="form-control" placeholder="Search..." style="margin-bottom:20px;"/>',
        },

        startUp: false,
        fireSearch: function(value) {
            return value.length > 2;
        },
        afterMoveToRight: function(){
            $("#search_to").trigger('change');
        },
        afterMoveToLeft: function() {
            $("#search").trigger('change');
        },
        afterInit: function(){
            $(".count-from").text($("#search").find("option").length + ' Record'+($("#search option").length>1?'s':''));
        },
        submitAllLeft:false,
        submitAllRight:true

    });
	</script>
<!-- ============================================================== -->
	<!-- End wanie part -->
	<!-- ============================================================== -->      

    <div class="row">
			<div class="col-md-6 col-6">

          <!-- <div class="row">
            <div class="col-lg-5">-->

           <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
           <?= $form->field($model, 'masterCaseInfoTypeId')->hiddenInput(['value' => $masterCaseInfoTypeId])->label(false); ?>
           <div class="row mb-3">
              <label for="inputEmail3" class="col-sm-4 col-form-label">Pilihan Mengisi</label>
              <div class="col-sm-6">
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
                <label for="inputPassword3" class="col-sm-4 col-form-label">No. Laporan Polis </label>
                <div class="col-sm-8">
                <?php //= $form->field($model, 'report_no')->textInput(['placeholder' => 'No Laporan Polis'])->label(false) ?>   
                </div>
            </div>-->

            <div class="row mb-3">
                <label for="inputPassword3" class="col-sm-4 col-form-label">No. Kertas Siasatan </label>
                <div class="col-sm-8">
                <?= $form->field($model, 'investigation_no')->textInput(['placeholder' => 'No Kertas Siasata'])->label(false) ?> 
                </div>
            </div>

            <div class="row mb-3">
                <legend class="col-form-label col-sm-4 pt-0">Kesalahan</legend>
                <div class="col-sm-8">
                <?= $form->field($model, 'offence')->dropDownList($offences,array('multiple'=>'multiple','prompt' => 'Pilih Kesalahan'))->label(false); ?>
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
                <?=  $form->field($model, 'surat_rasmi')->fileInput()->label(false)->hint('fail format : png | jpg | jpeg | pdf'); ?>
                </div>
            </div>

            <div class="row mb-3">
                <legend class="col-form-label col-sm-4 pt-0">Laporan Polis</legend>
                <div class="col-sm-8">
                <?= $form->field($model, 'laporan_polis')->fileInput(['accept' => 'image/*'])->label(false)->hint('fail format : png | jpg | jpeg | pdf');?>   
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
                echo $form->field($model, 'master_social_media_id['.$i.']')->dropDownList($masterSocialMedia,array('prompt' => 'Pilih Sosial Media','id' => 'social_media_'.$i))->label(false);
                echo $form->field($model, 'url['.$i.']')->textInput(['id' => 'social_media_URL_'.$i])->label(false); 
                ?>
                </div>
                <?php
                }
                ?> 
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

</div></div></div>

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
