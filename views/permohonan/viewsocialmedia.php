<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
?>

<div class="container-fluid">
    <h3 style="padding-top: 1.5rem;">Media Sosial</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard/index">Laman Utama</a></li>
            <li class="breadcrumb-item"><a href="../permohonan/block-request-list">Media Sosial</a></li>
            <li class="breadcrumb-item active">Paparan Media Sosial</a></li>
            
        </ol>
    </nav>

    <div class="row">
			<div class="col-lg-12">
				<div class="card card-outline-info">

    <div class="card-body">
                                    
       
  <div class="form-body">
<h5 class="m-t-20" style="color:#337ab7" >Maklumat Media Sosial</h5>
<hr>
           
<div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Perkara</th>
                        <th>Maklumat</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>No. Permohonan</strong></td>
                        <td><?= $mediaSocialResponse["case_no"];?></td>
                    </tr>
                    <tr>
                        <td><strong>No. Laporan Polis</strong></td>
                        <td><?= $mediaSocialResponse["report_no"];?></td>
                    </tr>
                    <tr>
                        <td><strong>No. Kertas Siasatan</strong></td>
                        <td><?= $mediaSocialResponse["investigation_no"];?></td>
                    </tr>
                    <tr>
                        <td><strong>Kesalahan</strong></td>
                        <td><?php
                        if(count($mediaSocialResponse["case_offence"]) > 0)
                        {
                          foreach($mediaSocialResponse["case_offence"] as $key => $val)
                          {
                            echo $val['offence_id']['name']."<br>";
                          }
                        }
                            
                            ?></td>
                    </tr>
                    <tr>
                        <td><strong>Surat Rasmi</strong></td>
                        <td><?php 
                        if(!empty($mediaSocialResponse["surat_rasmi"]))
                        { 
                          echo '<input type="hidden" id="suratRasmiImagePath"  value="'.$mediaSocialResponse['surat_rasmi'].'">';
                          echo Html::button("Muat Turun | Lihat",['class'=>'btn btn-primary',"id" => "suratRasmiViesDownloadImg"]);}
                        else{
                          echo "Tiada Lampiran";
                        }
                        ?></td>
                    </tr>
                    <tr>
                        <td><strong>Laporan Polis</strong></td>
                        <td><?php 
                        if(!empty($mediaSocialResponse["laporan_polis"]))
                        { 
                          echo '<input type="hidden" id="suratRasmiImagePath"  value="'.$mediaSocialResponse['laporan_polis'].'">';
                          echo Html::button("Muat Turun | Lihat",['class'=>'btn btn-primary',"id" => "laporanPolisViesDownloadImg"]);}
                        else{
                          echo "Tiada Lampiran";
                        } 
                        ?></td>
                    </tr>

                    <tr>
                        <td><strong>Status Suspek/Saksi</strong></td>
                        <td><?php
                        if(count($mediaSocialResponse["case_info_status_suspek"]) > 0)
                        {
                          $increments = 1;
                          foreach($mediaSocialResponse["case_info_status_suspek"] as $key => $val)
                          {
                            echo $increments." : ".$val['master_status_suspect_or_saksi_id']['name']."<br>";
                            echo "&nbsp;&nbsp;&nbsp;".$val['master_status_status_suspek_id']['name']."<br>";
                            echo "&nbsp;&nbsp;&nbsp;".$val['ic']."&nbsp;&nbsp;".$val['name']."&nbsp;&nbsp;".$val['others']."<br>";
                            $increments++;

                          }
                        }
                            
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>URL</strong></td>
                        <td><?php
                        if(count($mediaSocialResponse["case_info_url_involved"]) > 0)
                        {
                          $increments = 1;
                          foreach($mediaSocialResponse["case_info_url_involved"] as $key => $val)
                          {
                            echo $increments." : ".$val['master_social_media_id']['name']."<br>";
                            echo "&nbsp;&nbsp;&nbsp;".$val['url']."<br>";
                            $increments++;

                          }
                        }
                            
                            ?>
                        </td>
                    </tr>
                    
                </tbody>
            </table>
        </div>
                   
</div>
</div>
</div>
                                        </div>
                                        </div>
                                        </div>
<?php 
$script = <<< JS
$(document).ready(function() { 
  $("#suratRasmiViesDownloadImg").click(function(){ 
    var params = "?name="+$('#suratRasmiImagePath').val();
    document.location.href = '../permohonan/surat-download'+params
    });
  $("#laporanPolisViesDownloadImg").click(function(){ 
    
  var params = "?name="+$('#loparanImagePath').val();
  document.location.href = '../permohonan/laporan-download'+params
  });
});

JS; $this->registerJs($script, \yii\web\View::POS_END);
?>                                        

