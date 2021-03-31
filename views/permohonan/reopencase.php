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
            <li class="breadcrumb-item"><a href="../crawler/mntl-list">Permohonan Baru</a></li>
            
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
           <?=  Html::hiddenInput('PermohonanForm[id]', $mediaSocialResponse['id'],["id" => "permohonanId"]); ?>
           
           <div class="row mb-3">
                <label for="inputPassword3" class="col-sm-4 col-form-label">No Laporan Polis </label>
                <div class="col-sm-8">
                <?php  $model->report_no = $mediaSocialResponse['report_no']; ?>
                <?= $form->field($model, 'report_no')->textInput(['placeholder' => 'No Laporan Polis','readonly' => true])->label(false) ?>   
                </div>
            </div>

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
                <legend class="col-form-label col-sm-4 pt-0">Status Suspek</legend>
                <div class="pull-right">
                        <button type="button" id="add_ic_name" class="add-item btn btn-success btn-xs">+</button>
                        </div>
                
            </div>
            <?php 
            $count = 0;
            foreach($mediaSocialResponse['case_info_status_suspek'] as $key => $statusSuspectDbInfo):
            ?>
            <div class="col-sm-4" ></div>
            
            <div class="col-sm-8" id="id_name_<?=$key;?>">
                    <div class="row">
                    <?=  Html::hiddenInput('PermohonanForm[caseInfoStatusSuspekID]['.$key.']', $statusSuspectDbInfo['id']); ?>
                    <?php  $model->master_status_suspect_or_saksi_id[$key] = $statusSuspectDbInfo['master_status_suspect_or_saksi_id']; ?>
                        <?= $form->field($model, 'master_status_suspect_or_saksi_id['.$key.']')->dropDownList($suspectOrSaksi,array('prompt' => '--Pilih Suspek or Saksi--'))->label(false); ?>
                        
                    </div>

                    <div class="row">
                    <?php  $model->master_status_status_suspek_id[$key] = $statusSuspectDbInfo['master_status_status_suspek_id']; ?>
                    <?= $form->field($model, 'master_status_status_suspek_id['.$key.']')->dropDownList($masterStatusSuspect,['prompt' => '--Pilih Option--'/*,'itemOptions'=>['class' => 'master_suspect_class']*/])->label(false);?>   
                    </div>
                  <div class="row">
                    <div class="col-sm-4">
                    <?php  $model->ic[$key] = $statusSuspectDbInfo['ic']; ?>
                    <?= $form->field($model, 'ic['.$key.']')->textInput(['placeholder' => 'IC'])->label(false);?> 
                    </div>
                    <div class="col-sm-4" id="add_text_areabox-0"> 
                    <?php  $model->name[$key] = $statusSuspectDbInfo['name']; ?>
                    <?= $form->field($model, 'name['.$key.']')->textInput(['placeholder' => 'Name'])->label(false);?>  
                    </div> 
                    <?php 
                    if($statusSuspectDbInfo['master_status_status_suspek_id'] == 22)
                    {
                    ?>
                    <div class="col-lg-8"><textarea class="form-control" name="PermohonanForm[others][<?= $key?>]"><?= $statusSuspectDbInfo['others'];?></textarea></div> 
                    <?php 
                    }
                    ?>
                </div>
            </div>
            <?php 
            $count++;
            endforeach;
            ?>

            <div class="row mb-3">
                <legend class="col-form-label col-sm-4 pt-0">URL</legend>
                <div class="pull-right">
                <button type="button" id="add" class="add-item btn btn-success btn-xs">+</button>
            </div>
            <div class="col-sm-8" id="url_input_append">
                <?php
                //for($i=0;$i<=4;$i++)
                //{
                  foreach($mediaSocialResponse['case_info_url_involved'] as $key => $URLDbInfo):
                  $model->master_social_media_id[$key] = $URLDbInfo['master_social_media_id'];
                  $model->url[$key] = $URLDbInfo['url'];
                  ?>
                  <div class="row">
                  <?=  Html::hiddenInput('PermohonanForm[caseInfoURLInvolvedId]['.$key.']', $URLDbInfo['id']); ?>
                  <?php
                echo $form->field($model, 'master_social_media_id['.$key.']')->dropDownList($masterSocialMedia,array('prompt' => '--Pilih Social Media--'))->label(false);
                echo $form->field($model, 'url['.$key.']')->textInput()->label(false); 
                ?>
                </div>
                <?php
                endforeach;
                //}
                ?> 
            </div>
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
$purposeOfApplicationIdValInfo = "";
$statusSuspekCount = $count ? $count : 0;
$purposeOfApplicationIdVal = explode(",",$mediaSocialResponse['master_status_purpose_of_application_id']);
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
  if($purposeOfApplicationIdValInfo == 91)
  { 
   $("#application_purpose_info").show();
  }
  else{
    $("#application_purpose_info").hide();
  }
  
  var statusSuspekCount = $statusSuspekCount-1;
 

$('#add').click(function(){ var newID =  ( $('#url_input_append > div').length);
if(newID < 15)
{
  $('#url_input_append').append('<div class="row"><div class="form-group field-permohonanform-master_social_media_id"><select id="permohonanform-master_social_media_id['+newID+']" class="form-control" name="PermohonanForm[master_social_media_id]['+newID+']"><option value="">--Pilih Social Media--</option><option value="1">twitter</option><option value="2">instagram</option><option value="3">tumblr</option><option value="4">facebook</option><option value="5">blog / website</option></select><div class="help-block"></div></div><div class="form-group field-permohonanform-url-'+newID+'"><input type="text" id="permohonanform-url-'+newID+'" class="form-control" name="PermohonanForm[url]['+newID+']"><div class="help-block"></div></div></div>');
}
else{
  alert("Can't create new field");
  return false;
}
  
});
/*$('#add_ic_name').click(function(){ var asd = "#id_name_"+statusSuspekCount; var newSuspek = statusSuspekCount+1; var newIDInfo =  ($(asd+' > div').length); newIdVal = (newIDInfo / 3); alert(newIdVal);
  if(newIdVal < 5)
{
  $(asd).append('<div class="row"><div class="form-group field-permohonanform-master_status_suspect_or_saksi_id-'+newSuspek+' required"><select id="permohonanform-master_status_suspect_or_saksi_id-'+newSuspek+'" class="form-control" name="PermohonanForm[master_status_suspect_or_saksi_id]['+newSuspek+']"><option value="">--Pilih Suspek or Saksi--</option><option value="14">Suspek</option><option value="15">Saksi</option></select><div class="help-block"></div></div></div><div class="row"><div class="form-group field-permohonanform-master_status_status_suspek_id-'+newSuspek+'"><select id="permohonanform-master_status_status_suspek_id-'+newSuspek+'" class="form-control" name="PermohonanForm[master_status_status_suspek_id]['+newSuspek+']"><option value="">--Pilih Option--</option><option value="18">Tiada maklumat mengenai suspek</option><option value="19">Identiti suspek(Nama dan KPT) sudah dikenalpasti, tetapi belum ditahan</option><option value="20">Suspek telah ditahan</option><option value="21">Suspek dibebaskan dengan jaminan</option><option value="22">Lain-lain sila nyatakan</option></select><div class="help-block"></div></div></div><div class="row"><div class="col-sm-4"><div class="form-group field-permohonanform-ic-0"><input type="text" id="permohonanform-ic-0" class="form-control" name="PermohonanForm[ic]['+newSuspek+']" placeholder="IC"><div class="help-block"></div></div></div><div class="col-sm-4" id="add_text_areabox-'+newSuspek+'"><div class="form-group field-permohonanform-name-0"><input type="text" id="permohonanform-name-0" class="form-control" name="PermohonanForm[name]['+newSuspek+']" placeholder="Name"><div class="help-block"></div></div></div></div>');
}
else{
  alert("Can't create new field");
  return false;
}
});*/
var others_1 = 1;var others_2 = 1;var others_3 = 1;var others_4 = 1;var others_5 = 1;

$('#permohonanform-master_status_status_suspek_id-0').change(function(){  var newIDInfo =  ($('#id_name > div').length); newIdVal = (newIDInfo / 2)-1; //alert($('select[name="PermohonanForm[master_status_status_suspek_id][0]"]').val());
  if(this.value == 64 && others_1 < 2)
  {
    $('#add_text_areabox-0').after('<div class="col-lg-8"><textarea class="form-control" name="PermohonanForm[others]['+newIdVal+']"></textarea></div><div class="clearfix"></div>');
    ++others_1;
  }
  
});

$('#id_name').on('change','#permohonanform-master_status_status_suspek_id-1', function() {  var newIDInfo =  ($('#id_name > div').length); newIdVal = (newIDInfo / 2)-1; //alert($('select[name="PermohonanForm[master_status_status_suspek_id][0]"]').val());
  if(this.value == 64 && others_2 < 2){
$('#add_text_areabox-1').after('<div class="col-lg-8"><textarea class="form-control" name="PermohonanForm[others]['+newIdVal+']"></textarea></div><div class="clearfix"></div>');
++others_2;
  }
});

$('#id_name').on('change','#permohonanform-master_status_status_suspek_id-2', function() {  var newIDInfo =  ($('#id_name > div').length); newIdVal = (newIDInfo / 2)-1; //alert($('select[name="PermohonanForm[master_status_status_suspek_id][0]"]').val());
  if(this.value == 64 && others_3 < 2){
$('#add_text_areabox-2').after('<div class="col-lg-8"><textarea class="form-control" name="PermohonanForm[others]['+newIdVal+']"></textarea></div><div class="clearfix"></div>');
++others_3;
  }
});

$('#id_name').on('change','#permohonanform-master_status_status_suspek_id-3', function() {  var newIDInfo =  ($('#id_name > div').length); newIdVal = (newIDInfo / 2)-1; //alert($('select[name="PermohonanForm[master_status_status_suspek_id][0]"]').val());
  if(this.value == 64 && others_4 < 2){
$('#add_text_areabox-3').after('<div class="col-lg-8"><textarea class="form-control" name="PermohonanForm[others]['+newIdVal+']"></textarea></div><div class="clearfix"></div>');
++others_4;
  }
});

$('#id_name').on('change','#permohonanform-master_status_status_suspek_id-4', function() {  var newIDInfo =  ($('#id_name > div').length); newIdVal = (newIDInfo / 2)-1; //alert($('select[name="PermohonanForm[master_status_status_suspek_id][0]"]').val());
  if(this.value == 64  && others_5 < 2){
$('#add_text_areabox-4').after('<div class="col-lg-8"><textarea class="form-control" name="PermohonanForm[others]['+newIdVal+']"></textarea></div><div class="clearfix"></div>');
++others_5;
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
