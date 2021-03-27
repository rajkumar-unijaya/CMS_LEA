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
<div class="container-fluid">
    <h1 style="padding-top: 1.5rem;">View Social Media</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard/index">Home</a></li>
            <li class="breadcrumb-item"><a href="../permohonan/view-social-media?id=<?=$id?>">View Social Media</a></li>
            
        </ol>
    </nav>



    <div class="card-body">
        
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>No. Permohonan</strong></td>
                        <td> <?= $mediaSocialResponse["case_no"];?></td>
                    </tr>
                    <tr>
                        <td><strong>No. Laporan Polis</strong></td>
                        <td><?= $mediaSocialResponse["report_no"];?></td>
                    </tr>
                    <tr>
                        <td><strong>No Kertas Siasatan</strong></td>
                        <td> <?= $mediaSocialResponse["investigation_no"];?></td>
                    </tr>
                    <tr>
                        <td><strong>Ringkasan Kes</strong></td>
                        <td> <?= $mediaSocialResponse["purpose_of_application_info"];?></td>
                    </tr>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>