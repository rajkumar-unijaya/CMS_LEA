<?php
use yii\helpers\Html;
?>
<div class="container-fluid">
    <h3 style="padding-top: 1.5rem;">Senarai MNTL</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard/index">Laman Utama</a></li>
            <li class="breadcrumb-item active" aria-current="page">Senarai MNTL</li>
        </ol>
    </nav>
    <div id="success" class="info noticationMsg">
<?php if(Yii::$app->session->hasFlash('success')):?>
<?php echo Yii::$app->session->getFlash('success')[0] ?>
<?php endif;?>
</div>
    <div class="card-body">
        <div style="float:right;margin-bottom: 10px;">
            <a href="../permohonan/mntl">
                <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Permohonan Baru</button>
            </a>
        </div>
        <div class="table-responsive">
            <table class="display nowrap table table-hover table-striped table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>No. Laporan Polis</th>
                        <th>No. Kertas Siasatan</th>
                        <th>No. Telefon</th>
                        <th>Nama Telco</th>
                        <th>Tarikh 1</th>
                        <th>Tarikh 2</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    foreach ($responses as $key => $responseTemp) { 
                        foreach($responseTemp['case_info_mntl'] as $key1 => $val)
                        { 
                            $phoneNo =  $val['phone_number'];
                            $telcoName =  $val['telco_name'];
                            $date1 =  $val['date1'];
                            $date2 =  $val['date2'];
                        }
                        
                    ?>
                        <tr>
                            <td><?php echo $count; ?></td>
                            <td><?php echo $responseTemp['report_no']; ?></td>
                            <td><?php echo $responseTemp['investigation_no']; ?></td>
                            <td><?php echo $phoneNo; ?></td>
                            <td><?php echo $telcoName; ?></td>
                            <td><?php echo $date1; ?></td>
                            <td><?php echo $date2; ?></td>
                            
                        </tr>
                    <?php
                        $count++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>