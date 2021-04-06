<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

// $this->title = 'mntl';
// $this->params['breadcrumbs'][] = $this->title;
?>
<!-- <div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        This is the <?= Html::encode($this->title) ?> page. You may modify the following file to customize its content
    </p>
</div> -->
<?php

$responses = $responses->data;
?>
<div class="container-fluid">
    <h1 style="padding-top: 1.5rem;">MNTL List</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">MNTL</a></li>
            <li class="breadcrumb-item active" aria-current="page">List</li>
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
                <button type="button" class="btn btn-primary">New Request</button>
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No Laporan Polis</th>
                        <th>No Kertas Siasatan</th>
                        <th>No. TP</th>
                        <th>Phone Number</th>
                        <th>Telco Name</th>
                        <th>Date1</th>
                        <th>Date2</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    foreach ($responses['records'] as $key => $responseTemp) { 
                    ?>
                        <tr>
                            <td><?php echo $count; ?></td>
                            <td><?php echo $responseTemp['report_no']; ?></td>
                            <td><?php echo $responseTemp['investigation_no']; ?></td>
                            <td><?php echo $responseTemp['case_info_mntl'][0]['tippoff_id']['tipoff_no'];?></td>
                            <td><?php echo $responseTemp['case_info_mntl'][0]['phone_number']; ?></td>
                            <td><?php echo $responseTemp['case_info_mntl'][0]['telco_name']; ?></td>
                            <td><?php echo $responseTemp['case_info_mntl'][0]['date1']; ?></td>
                            <td><?php echo $responseTemp['case_info_mntl'][0]['date2']; ?></td>
                            
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