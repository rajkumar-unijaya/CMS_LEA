<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php
if (Yii::$app->session->hasFlash('success')) {
	echo "<div class='alert alert-success'>" . Yii::$app->session->getFlash('success')[0] . "</div>";
}
?>

<?php
$this->title = 'Profile Edit';
$this->params['breadcrumbs'][] = ['label' => 'LEA Edit', 'url' => ['lea-edit']];
?>

<div class="row">`
       
            <div class="col-lg-5">
<?php //echo $mediaSocialResponse['case_no'];exit;?>
           <?php $form = ActiveForm::begin(['options' => [ 'enableClientValidation' => true]]); ?>
           <div class="row mb-3">
                <label for="inputPassword3" class="col-sm-4 col-form-label">Email </label>
                <div class="col-sm-8">
                <?php  $model->email = $userResponse['email']; ?>
                <?= $form->field($model, 'email')->textInput(['placeholder' => 'Email'])->label(false) ?>   
                </div>
            </div>

            <div class="row mb-3">
                <legend class="col-form-label col-sm-4 pt-0">Email Type</legend>
                <div class="col-sm-8">
                <?php 
                $offencesList = array();
                $offences = array();
                /*$i = 0;
                foreach($mediaSocialResponse['case_offence'] as $key => $offenceInfo):
                  $i++;
                  $offencesList[$offenceInfo['offence_id']] = array("selected"=>true);
                endforeach;*/
                $model->email_type = $userResponse['email_type'];
                
                ?>
                <?= $form->field($model, 'email_type')->label('Email Type')->radioList($masterEmailType)->label(false); ?>
                <?php //= $form->field($model, 'email_type')->dropDownList($offences,array('multiple'=>'multiple','prompt' => '--Pilih Kesalahan--','options' => $offencesList))->label(false); ?>
                </div>
           </div>


           <div class="row mb-3">
                <label for="inputPassword3" class="col-sm-4 col-form-label">Name </label>
                <div class="col-sm-8">
                <?php  $model->name = $userResponse['fullname']; ?>
                <?= $form->field($model, 'name')->textInput(['placeholder' => 'Name'])->label(false) ?>   
                </div>
            </div>

            <div class="row mb-3">
                <label for="inputPassword3" class="col-sm-4 col-form-label">IC </label>
                <div class="col-sm-8">
                <?php  $model->icno = $userResponse['ic_no']; ?>
                <?= $form->field($model, 'icno')->textInput(['placeholder' => 'IC'])->label(false) ?>   
                </div>
            </div>

            <div class="row mb-3">
                <label for="inputPassword3" class="col-sm-4 col-form-label">Organization Name </label>
                <div class="col-sm-8">
                <?php  $model->organization_name = $userResponse['organization']; ?>
                <?= $form->field($model, 'organization_name')->dropDownList($masterOrganizationName,array('prompt' => '--Pilih Organization Nama--'))->label(false); ?>
                <?php //= $form->field($model, 'organization_name')->textInput(['placeholder' => 'Organization Name'])->label(false) ?>   
                </div>
            </div>

            <div class="row mb-3">
                <label for="inputPassword3" class="col-sm-4 col-form-label">Branch </label>
                <div class="col-sm-8">
                <?php $model->branch = $userResponse['branch']; ?>
                <?= $form->field($model, 'branch')->dropDownList($masterBranch,array('prompt' => '--Pilih Branch--'))->label(false); ?>
                <?php //= $form->field($model, 'branch')->dropDownList($suspectOrSaksi,array('prompt' => '--Pilih Bracnh--'))->label(false); ?>
                </div>
            </div>


            <div class="row mb-3">
                <label for="inputPassword3" class="col-sm-4 col-form-label">Unit Name </label>
                <div class="col-sm-8">
                <?php  $model->unit_name = $userResponse['department']; ?>
                <?= $form->field($model, 'unit_name')->dropDownList($masterUnitName,array('prompt' => '--Pilih Unit Nama--'))->label(false); ?>
                <?php //= $form->field($model, 'unit_name')->textInput(['placeholder' => 'Unit Name'])->label(false) ?>   
                </div>
            </div>

            <div class="row mb-3">
                <label for="inputPassword3" class="col-sm-4 col-form-label">State </label>
                <div class="col-sm-8">
                <?php $model->state = $userResponse['master_state_id']; ?>
                <?= $form->field($model, 'state')->dropDownList($masterState,array('prompt' => '--Pilih State--'))->label(false); ?>
                </div>
            </div>

            <div class="row mb-3">
                <label for="inputPassword3" class="col-sm-4 col-form-label">District </label>
                <div class="col-sm-8">
                <?php $model->district = $userResponse['master_district_id']; ?>
                <?= $form->field($model, 'district')->dropDownList($masterDistrict,array('prompt' => '--Pilih District--'))->label(false); ?>
                </div>
            </div>

            <div class="row mb-3">
                <label for="inputPassword3" class="col-sm-4 col-form-label">Post Code </label>
                <div class="col-sm-8">
                <?php  $model->postcode = $userResponse['master_postcode_id']; ?>
                <?= $form->field($model, 'postcode')->dropDownList($masterPostcode,array('prompt' => '--Pilih Postcode--'))->label(false); ?>
                <?php //= $form->field($model, 'postcode')->textInput(['placeholder' => 'Post Code'])->label(false) ?>   
                </div>
            </div>

            

            <div class="row mb-3">
                <label for="inputPassword3" class="col-sm-4 col-form-label">Mobile No. </label>
                <div class="col-sm-8">
                <?php  $model->mobile_no = $userResponse['mobile_no']; ?>
                <?= $form->field($model, 'mobile_no')->textInput(['placeholder' => 'Mobile No.'])->label(false) ?>   
                </div>
            </div>

            <div class="row mb-3">
                <label for="inputPassword3" class="col-sm-4 col-form-label">Office Phone No. </label>
                <div class="col-sm-8">
                <?php  $model->office_phone_no = $userResponse['office_phone_no']; ?>
                <?= $form->field($model, 'office_phone_no')->textInput(['placeholder' => 'Office Phone No.'])->label(false) ?>   
                </div>
            </div>

            <div class="row mb-3">
                <label for="inputPassword3" class="col-sm-4 col-form-label">Telegram Id </label>
                <div class="col-sm-8">
                <?php  $model->telegram_id = $userResponse['telegram_id']; ?>
                <?= $form->field($model, 'telegram_id')->textInput(['placeholder' => 'Telegram Id'])->label(false) ?>   
                </div>
            </div>

            <div class="row mb-3">
                <label for="inputPassword3" class="col-sm-4 col-form-label">Notification </label>
                <div class="col-sm-8">
                <?php   $model->notification = $userResponse['notificationInfo']; ?>
                <?= $form->field($model, 'notification')->label('Notify user creation by')->checkboxList(['1' => 'SMS', '2' => "Telegram"])->label(false); ?>
                </div>
            </div>

        </div>


    
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
            </div>
        </div>

<?php
$script = <<< JS
$(document).ready(function() {
    $("#loader").hide();
    $("#leaform-organization_name").change(function() {  
            var url = window.location.origin+"/dashboard/get-master-data";
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: {id:this.value,data_group:"master_branch",default_option : "--Pilih Branch--"},
                beforeSend: function(){
                    $("#loader").show();
                },
            })
            .done(function(response) {
                if (response.message == "success") { 
                    $("#leaform-branch").html(response.result);
                    $("#loader").hide();
                 } 
                 else{ 
                      return false;
                 }
                
            })
            .fail(function() {
                console.log("error");
                $("#loader").hide();
            });
        
        });

        $("#leaform-branch").change(function() {  
            var url = window.location.origin+"/dashboard/get-master-data";
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: {id:this.value,data_group:"master_department",default_option : "--Pilih Unit Nama--"},
                beforeSend: function(){
                    $("#loader").show();
                },
            })
            .done(function(response) {
                if (response.message == "success") { 
                    $("#leaform-unit_name").html(response.result);
                    $("#loader").hide();
                 } 
                 else{ 
                      return false;
                 }
                
            })
            .fail(function() {
                console.log("error");
                $("#loader").hide();
            });
        
        }); 

         $("#leaform-state").change(function() {  
            var url = window.location.origin+"/dashboard/get-master-data";
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: {id:this.value,data_group:"master_district",default_option : "--Pilih District--"},
                beforeSend: function(){
                    $("#loader").show();
                },
            })
            .done(function(response) {
                if (response.message == "success") { 
                    $("#leaform-district").html(response.result);
                    $("#loader").hide();
                 } 
                 else{ 
                      return false;
                 }
                
            })
            .fail(function() {
                console.log("error");
                $("#loader").hide();
            });
        
        }); 

        $("#leaform-district").change(function() {  
            var url = window.location.origin+"/dashboard/get-master-data";
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: {id:this.value,data_group:"master_postcode",default_option : "--Pilih Postcode--"},
                beforeSend: function(){
                    $("#loader").show();
                },
            })
            .done(function(response) {
                if (response.message == "success") { 
                    $("#leaform-postcode").html(response.result);
                    $("#loader").hide();
                 } 
                 else{ 
                      return false;
                 }
                
            })
            .fail(function() {
                console.log("error");
                $("#loader").hide();
            });
        
        });    
});
JS;
$this->registerJs($script, \yii\web\View::POS_END);

?>