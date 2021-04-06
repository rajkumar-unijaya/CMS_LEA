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
        <!-- <div style="display: inline-flex; margin-bottom: 10px;">
            <div style="display: inline-block;padding-right: 20px;">Start Date: <input type="date" class="form-control"> </div>
            <div style="display: inline-block;">End Date: <input type="date" class="form-control"> </div>
        </div> -->
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
                        <th>Date Created</th>
                        <th>Date Finished</th>
                        <th>Report No.</th>
                        <th>CMS No.</th>
                        <th>Phone No.</th>
                        <th>Telco</th>
                        <th>Created By</th>
                        <th>Days Taken</th>
                        <th>Star Rating</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 1;
                    foreach ($responses as $key => $responseTemp) {
                    ?>
                        <tr>
                            <td><?php echo $count; ?></td>
                            <td><?php echo $responseTemp['date_created']; ?></td>
                            <td><?php echo $responseTemp['date_finish']; ?></td>
                            <td>
                                <?php
                                echo $responseTemp['report_number'];
                                ?>
                            </td>
                            <td>
                            <!-- remember to change 'reportNo' => $responseTemp['cms_number'] -->
                                <?= Html::a($responseTemp['cms_number'], ['../crawler/mntl-preview-detail', 'reportNo' => 'CMS12345' ? 'CMS12345' : '#']) ?>
                            </td>
                            <td><?php echo $responseTemp['number']; ?></td>
                            <td><?php echo $responseTemp['telco']; ?></td>
                            <td><?php echo $responseTemp['name']; ?></td>
                            <td><?php echo $responseTemp['days']; ?></td>
                            <td><?php echo $responseTemp['star']; ?></td>
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