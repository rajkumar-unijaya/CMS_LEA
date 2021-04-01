<?php 

/* @var $this yii\web\View */

namespace app\widgets;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use Yii;
?>

<div class="container-fluid">
    <h1 style="padding-top: 1.5rem;">Block Request</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../permohonan/block-request-list">Home</a></li>
            <li class="breadcrumb-item active">Block Request</li>
            
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
           <?= $form->field($model, 'master_case_info_type_id')->hiddenInput(['value' => $mediaSocialResponse['master_case_info_type_id']])->label(false); ?>
           <?=  Html::hiddenInput('BlockRequestForm[id]', $mediaSocialResponse['id'],["id" => "permohonanId"]); ?>
           
           
            <div class="row mb-3">
                <label for="inputPassword3" class="col-sm-4 col-form-label">No Kertas Siasatan </label>
                <div class="col-sm-8">
                <?php  $model->investigation_no = $mediaSocialResponse['investigation_no']; ?>
                <?= $form->field($model, 'investigation_no')->textInput(['placeholder' => 'No Kertas Siasata','readonly' => true])->label(false) ?> 
                </div>
            </div>

            <div class="row mb-3">
                <label for="inputPassword3" class="col-sm-4 col-form-label">No. Permohonan </label>
                <div class="col-sm-8">
                <?= Html::input('text', 'case_no', $mediaSocialResponse['case_no'], ['class'=> 'form-control','readonly' => true]) ?>
                
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
                <legend class="col-form-label col-sm-4 pt-0">URL</legend>
                <div class="pull-right">
                <button type="button" id="add" class="add-item btn btn-success btn-xs">+</button>
            </div>
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

?>

<?php
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
  

$('#add').click(function(){ var newID =  ( $('#url_input_append > div').length);
if(newID < 15)
{
  $('#url_input_append').append('<div class="row"><div class="form-group field-permohonanform-master_social_media_id"><select id="permohonanform-master_social_media_id['+newID+']" class="form-control" name="BlockRequestForm[master_social_media_id]['+newID+']"><option value="">--Pilih Social Media--</option><option value="1">twitter</option><option value="2">instagram</option><option value="3">tumblr</option><option value="4">facebook</option><option value="5">blog / website</option></select><div class="help-block"></div></div><div class="form-group field-permohonanform-url-'+newID+'"><input type="text" id="permohonanform-url-'+newID+'" class="form-control" name="BlockRequestForm[url]['+newID+']"><div class="help-block"></div></div></div>');
}
else{
  alert("Can't create new field");
  return false;
}
  
});

var URL_obj = [{id:39, name:"https://twitter.com/"}, {id:40, name:"https://www.instagram.com/"}, {id:41, name:"https://www.tumblr.com/"}, {id:42, name:"https://www.facebook.com/"}, {id:43, name:"https://www.youtube.com/"}, {id:44, name:"https://www.tiktok.com/"}];
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

    var valid = true;

});
JS; $this->registerJs($script, \yii\web\View::POS_END);

?>
