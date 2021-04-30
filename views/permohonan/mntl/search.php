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
    <h1 style="padding-top: 1.5rem;"> Carian MNP</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard/index">Laman Utama</a></li>
            <li class="breadcrumb-item active" aria-current="page">Carian MNP </li>
        </ol>
    </nav>

    <div class="row">
    <!-- Column -->
    <div class="col-lg-12">
<div class="card-body">
                <div class="row">
                    <div class="col-md-4 col-sm-12 m-b-10">
                    <?php $form = ActiveForm::begin(['id' => 'mnp-form']); ?>
                        <!--<input type="text" class="form-control" placeholder="Masukkan No. Telefon" name="search">-->
                        <?= $form->field($model, 'phone_number')->textInput(['placeholder' => 'Masukkan No. Telefon', 'type' => 'text'])->label(false);  ?>
                        </div>
                        <div class="col-md-4 col-sm-12 m-b-10">
                        <button type="submit"class="btn btn-info btn-lg"><i class="fa fa-search"></i> Carian</button>
                        </div>
                        <div class="col-md-4 col-sm-12 m-b-10">
                        <?= Html::img('../images/loader.gif',["id" => "loader"]);?>
                        </div>
                        <?php ActiveForm::end(); ?>
                    
                    </div>
            <br>
            <div class="row">
            <h3>Keputusan Carian MNP :</h3>
            </div> 
            <br>
            

            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 20%;">Perkara</th>
                            <th style="width: 100%;">Maklumat</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                            <tr>
                                <td><strong>No. Telefon</strong></td>
                                <td id="phone_no">-</td>
                            </tr>
                            <tr>
                                <td><strong>Carrier</strong></td>
                                <td id="carrier">-</td>
                            </tr>
                            <tr>
                                <td><strong>Ported</strong></td>
                                <td id="ported">-</td>
                            </tr>
                            <tr>
                                <td><strong>Telco</strong></td>
                                <td  id="telco">-</td>
                            </tr>
                            <tr>
                                <td><strong>Informasi</strong></td>
                                <td  id="contact_info">-</td>
                            </tr>
                    </tbody>
                </table>
            </div>


<br>
            <div>
                <h3>Keputusan Carian MNTL :</h3></div>
           <br>
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 20%;">Perkara</th>
                            <th>Maklumat</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                            <tr>
                                <td><strong>Telefon No.</strong></td>
                                <td id="telephone">-</td>
                                <td  id="norecords">No records found</td>
                            </tr>
                            <tr>
                                <td><strong>Telco</strong></td>
                                <td id="telco_info">-</td>
                                <td  id="date_registered_blink"><a id="link_val" href="">Permohonan Baru</a></p></td>
                            </tr>
                            <tr>
                                <td><strong>Nama</strong></td>
                                <td id="name">-</td>
                            </tr>
                            <tr>
                                <td><strong>No. Kad Pengenalan / Pasport</strong></td>
                                <td  id="ic">-</td>
                            </tr>
                            <tr>
                                <td><strong>Alamat</strong></td>
                                <td  id="address">-</td>
                            </tr>
                            <tr>
                                <td><strong>Tarikh Didaftarkan</strong></td>
                                <td  id="date_registered">-</td>
                                
                            </tr>
                            <tr>
                                <td><strong>Status</strong></td>
                                <td  id="status_info">-</td>
                            </tr>
                            <tr>
                                <td><strong>Tarikh Dibuat</strong></td>
                                <td  id="date_created">-</td>
                            </tr>
                            <tr>
                                <td><strong>Tarikh Selesai</strong></td>
                                <td  id="date_finish">-</td>
                            </tr>
                            <tr>
                                <td><strong>Hari yang Diambil</strong></td>
                                <td  id="days_taken">-</td>
                            </tr>
                    </tbody>
                </table>
            </div>

        
    </div>
</div>
</div>
<?php
//echo"<pre>";print_r($masterSocialMedia);
$script = <<< JS
$(document).ready(function() {
    $("#loader").hide();
    $("#date_registered_blink").hide();
    $("#norecords").hide();
    
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
                    $("#telco_info").hide();   
                    $("#telephone").hide();   
                    //$("#date_registered").text('No records found');   
                    $("#date_registered_blink").show();
                    $("#norecords").show();
                    $("#link_val").attr("href",'../permohonan/mntl?no='+$('#searchform-phone_number').val());
                    $("#telco_info").html('');  
                    $("#loader").hide();
                    
                 }
                }
            })
            .fail(function() {
                console.log("error");
                $("#loader").hide();
            });
        
        });
        var blink = document.getElementById('blink');
        setInterval(function() {
        blink.style.opacity = (blink.style.opacity == 0 ? 1 : 0);
      }, 350);

    return  true;

});
JS; $this->registerJs($script, \yii\web\View::POS_END);

?>
<style>
      .blink {
        text-decoration: blink;
        color: #1c87c9;
        font-size: 30px;
        font-weight: bold;
        font-family: sans-serif;
      }
    </style>