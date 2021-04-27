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
			<div class="col-lg-12 col-8 align-self-center">
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
           <?= $form->field($model, 'masterCaseInfoTypeId')->hiddenInput(['value' => $masterCaseInfoTypeId])->label(false); ?>
           
          <div class="row">
						<div class="col-md-6">
							  <div class="form-group">
								    <label>Pilihan Mengisi <span class="text-danger">*</span></label>
								      <?= $form->field($model, 'for_self')->dropDownList($newCase,array('prompt' => 'Pilih Pilihan'))->label(false);?>
							  </div>
						  </div>
              </div>
      <!--/span-->
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
              <!--no. Laporan Polis-->
              <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                      <label class="control-label">No. Laporan Polis <span class="text-danger"></span></label>
                      <div class="controls">
                      <?= $form->field($model, 'report_no')->textInput(['placeholder' => 'No. Laporan Polis'])->label(false); ?>  
                      </div>
                  </div>
              </div>

              <!--No. Kertas Siasatan-->
              <div class="col-md-6">
                  <div class="form-group">
                      <label class="control-label">No. Kertas siasatan <span class="text-danger">*</span></label>
                      <div class="controls">
                      <?= $form->field($model, 'investigation_no')->textInput(['placeholder' => 'No. Kertas siasatan'])->label(false); ?> 
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
        <?php 
        $selectedNewOffences =  array();
        ?>
      <?= $form->field($model, 'offence')->dropDownList($selectedNewOffences,array('id' => 'mySideToSideSelect_to','class' => 'form-control','size' => 10,'multiple'=>'multiple','prompt' => 'Pilih Kesalahan'))->label(false); ?>
                  
      </div>
    </div>
 <!--Ringkasan Kes-->
              <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                      <label class="control-label"> Ringkasan Kes<span class="text-danger">*</span></label>
                      <div class="controls">
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
					  	<label>Surat Rasmi</label>
                  
						    <?=  $form->field($model, 'surat_rasmi')->fileInput()->label(false); ?>
                <br /><small>(format file : .DOC, .DOCX, .JPG, .JPEG, .PNG, .PDF)</small>
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
                <br /><small>(format file : .DOC, .DOCX, .JPG, .JPEG, .PNG, .PDF)</small>
						      <div id="fileList"></div>
               </div>      
				  	</div>
          </div>
        
<br>
  <!--URL--> 
  <!-- rams start --><div class="row"> 
  <div class="col-sm-8">
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

            <div class="container-items"><!-- widgetContainer -->
            <?php foreach ($modelUrl as $i => $modelUrl): //echo"<pre>";print_r($modelUrl);exit;?>
                <div class="item panel panel-default"><!-- widgetBody -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left">URL</h3>
                        <div class="pull-right">
                            <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        
                        <div class="row">
                            <div class="col-sm-6">
                                <?= $form->field($modelUrl, '['.$i.']master_social_media_id')->dropDownList($masterSocialMedia,array('prompt' => 'Pilih Sosial Media','id' => $i.'social_media'))->label(false); ?>
                            </div>
                            <div class="col-sm-6">
                                <?= $form->field($modelUrl, '['.$i.']url')->textInput(['id' => $i.'social_media_URL'])->label(false); ?>
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
                      <!--<div class="row">
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
                      </div>-->
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
<!-- end form design  -->

	
</div>

</div></div></div>

<?php
$script = <<< JS
$(document).ready(function() {
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

$(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    console.log("afterInsert");
});

$(".dynamicform_wrapper").on("beforeDelete", function(e, item) {
    if (! confirm("Are you sure you want to delete this item?")) {
        return false;
    }
    return true;
});

$(".dynamicform_wrapper").on("afterDelete", function(e) {
    console.log("Deleted item!");
});

$(".dynamicform_wrapper").on("limitReached", function(e, item) {
    alert("Limit reached");
});


  $("#add_options").click(function(){
    $("#mySideToSideSelect option:selected").remove().appendTo($("#mySideToSideSelect_to"));
})
$("#remove_options").click(function(){
    $("#mySideToSideSelect_to option:selected").remove().appendTo($("#mySideToSideSelect"));
})
  $("#choose_forself").hide();
  $("#application_purpose_info").hide();
  $('#blockrequestform-for_self').change(function() {  //alert("ramstest = "+$("input[name='BlockRequestForm[for_self]']:checked").val());
    if (this.value == 78) {
      $("#choose_forself").show();
    }
    else if (this.value == 79) {
      $("#choose_forself").hide();
    }
});

var URL_obj = [{id:39, name:"https://twitter.com/"}, {id:40, name:"https://www.instagram.com/"}, {id:41, name:"https://www.tumblr.com/"}, {id:42, name:"https://www.facebook.com/"}, {id:99, name:"https://www.youtube.com/"}, {id:100, name:"https://www.tiktok.com/"}];


$('.dynamicform_wrapper').on('change','select[name="PermohonanUrl[0][master_social_media_id]"]', function() { 
  if(URL_obj.find(item => item.id == $('select[name="PermohonanUrl[0][master_social_media_id]"]').val())){ var item_val = URL_obj.find(item => item.id == $('select[name="PermohonanUrl[0][master_social_media_id]"]').val()); $('input[name="PermohonanUrl[0][url]"]').val(item_val.name);}
});
    var valid = true;

});
JS; $this->registerJs($script, \yii\web\View::POS_END);

?>
