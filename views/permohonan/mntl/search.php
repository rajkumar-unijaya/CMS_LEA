<?php 

/* @var $this yii\web\View */

namespace app\widgets; 
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use Yii;
?>
<!-- <div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        This is the <?= Html::encode($this->title) ?> page. You may modify the following file to customize its content
    </p>
</div> -->

<div class="container-fluid">
    <h1 style="padding-top: 1.5rem;">MNP Search</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">MNTL</a></li>
            <li class="breadcrumb-item active" aria-current="page">MNP Search</li>
        </ol>
    </nav>


    <div class="card-body">
        
            <div class="input-group-btn">
                <?php $form = ActiveForm::begin(['id' => 'mnp-form']); ?>
                <div class="row">
                 <div>
                    <?= $form->field($model, 'phone_number')->textInput(['placeholder' => 'Enter Phone Number', 'type' => 'number']); ?>
                </div>
                <div class="form-group">
                    <?= Html::submitButton('<i class="fa fa-search"></i> &nbsp; Search', [
                        'class' => 'btn btn-primary'
                    ]) ?>
                </div>
                </div>
                <?= Html::img('../images/loader.gif',["id" => "loader"]);?>
                <?php ActiveForm::end(); ?>
            </div>
        
            <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th style="width: 20%;">Item</th>
                        <th>Detail</th>
                        <th>Remark</th>
                    </tr>
                </thead>
                <tbody>
                        <tr>
                            <td><strong>Phone No.</strong></td>
                            <td id="phone_no">-</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><strong>Carrier</strong></td>
                            <td id="carrier">-</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><strong>Ported</strong></td>
                            <td id="ported">-</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><strong>Telco</strong></td>
                            <td  id="telco">-</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><strong>Contact Information</strong></td>
                            <td  id="contact_info">-</td>
                            <td></td>
                        </tr>
                </tbody>
            </table>
</div>

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Telefon No.</th>
                        <th>Telco</th>
                        <th>Nama</th>
                        <th>IC/Pasport</th>
                        <th>Alamat</th>
                        <th>Tarikh Didaftarkan</th>
                        <th>Status</th>
                        <th>Tarikh Dibuat</th>
                        <th>Tarikh Selesai</th>
                        <th>Hari yang Diambil</th>
                    </tr>
                </thead>
                <tbody>
                        <tr>
                            <td id="telephone">-</td>
                            <td id="telco_info">-</td>
                            <td id="name">-</td>
                            <td id="ic">-</td>
                            <td id="address">-</td>
                            <td id="date_registered">-</td>
                            <td id="status_info">-</td>
                            <td id="date_created">-</td>
                            <td id="date_finish">-</td>
                            <td id="days_taken">-</td>
                            
                        </tr>
                </tbody>
            </table>
        </div>
        <blink id="blink_info" class="text-center"><a href="../permohonan/mntl">New Request</a></blink>
    </div>
</div>

<?php
//echo"<pre>";print_r($masterSocialMedia);
$script = <<< JS
$(document).ready(function() {
    $("#loader").hide();
    $("#blink_info").hide();
    $("#mnp-form").submit(function(event) {
            event.preventDefault(); // stopping submitting
            var data = $(this).serializeArray();
            var url = $(this).attr('action');
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: data,
                beforeSend: function(){
                    $("#loader").show();
                },
            })
            .done(function(response) { 
                if (response.success == "true") {
                 $("#phone_no").text(response.telco_info.phone);   
                 $("#carrier").text(response.telco_info.carrier);   
                 $("#ported").text(response.telco_info.ported);   
                 $("#telco").text(response.telco_info.ported_to);   
                 $("#contact_info").text(response.telco_info.telco_info);   
                 if(response.mntl_info.days_count_filter == "true") 
                 {
                 $("#telephone").text(response.mntl_info.number);   
                 $("#telco_info").text(response.mntl_info.telco);   
                 $("#name").text(response.mntl_info.name);   
                 $("#ic").text(response.mntl_info.ic);   
                 $("#address").text(response.mntl_info.address);   
                 $("#date_registered").text(response.mntl_info.date_created);  
                 $("#status_info").html('-');   
                 $("#date_created").text(response.mntl_info.date_created);   
                 $("#date_finish").text(response.mntl_info.date_finish);   
                 $("#days_taken").text(response.mntl_info.days); 
                 $("#status_info").text('N/A'); 
                 $("#loader").hide();
                 } 
                 else{
                    $("#date_registered").text('No records found');   
                    $("#blink_info").show();
                    $("#loader").hide();
                 }
                }
            })
            .fail(function() {
                console.log("error");
                $("#loader").hide();
            });
        
        });

    return  true;

});
JS; $this->registerJs($script, \yii\web\View::POS_END);

?>