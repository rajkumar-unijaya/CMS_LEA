<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Blocking Request';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="success" class="info noticationMsg">
<?php if(Yii::$app->session->hasFlash('success')):?>
<?php echo Yii::$app->session->getFlash('success')[0] ?>
<?php endif;?>
</div>
<div class="container-fluid">
    <h1 style="padding-top: 1.5rem;">Blocking Request</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Blocking Request</li>
        </ol>
    </nav>
    <div style="text-align: right;padding:10px;">
        <a href="../permohonan/block-request"><button type="button" class="btn btn-primary">Permohonan Baru
            </button></a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No. Permohonan</th>
                        <th>Ringkasan Kes</th>
                        <th>Lampiran</th>
                        <th>Status</th>
                        <th>Tarikh Permohonan</th>
                        <th>Tempoh Proses</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>

                    <?php //echo"<pre>";print_r($mediaSocialResponse);exit;
                    $count = 1;
                    foreach ($mediaSocialResponse as $key => $responseTemp) {
                    ?>
                        <tr>
                            <td><?php echo $count; ?></td>
                            <td><?php echo $responseTemp['case_no']; ?></td>
                            <td><?php echo $responseTemp['case_summary']; ?></td>
                            <td><?php echo "abc.pdf"; ?></td>
                            <td><?php echo $responseTemp['case_status']['name'];
                            echo strcasecmp($responseTemp['case_status']['name'],"Closed") == 0 ? "<br>(Papar)" : "";
                            echo strcasecmp($responseTemp['case_status']['name'],"Rejected") == 0 ? "<br>(Muat Turun Komen)" : "";
                            
                            ?></td>
                            <td><?php echo $responseTemp['case_start_date'] ? \Yii::$app->formatter->asDate($responseTemp['case_start_date'], 'long') : "N/A"; ?></td>
                            <td><?php echo 1; ?></td>
                            <td>
                            <?php 
                            if(strcasecmp($responseTemp['case_status']['name'],"Closed") == 0)
                            {
                             echo Html::a('<i class="fa fa-folder" aria-hidden="true"></i>', array('permohonan/reopencase', 'id'=>$responseTemp['id']));
                             echo "&nbsp;&nbsp;&nbsp;";
                             echo Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', array('permohonan/view-social-media', 'id'=>$responseTemp['id']));
                            }
                            if(strcasecmp($responseTemp['case_status']['name'],"Rejected") == 0)
                            {
                             echo Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', array('permohonan/view-social-media', 'id'=>$responseTemp['id']));
                            }
                            if(strcasecmp($responseTemp['case_status']['name'],"Pending") == 0)
                            {
                            echo Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>', array('permohonan/edit-block-request', 'id'=>$responseTemp['id']));
                            echo "&nbsp;&nbsp;&nbsp;";
                            echo Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', array('permohonan/view-social-media', 'id'=>$responseTemp['id']));
                            }
                            if(strcasecmp($responseTemp['case_status']['name'],"Reopen") == 0)
                            {
                            echo Html::a('<i class="fa fa-folder" aria-hidden="true"></i>', array('permohonan/reopen-block-request', 'id'=>$responseTemp['id']));
                            echo "&nbsp;&nbsp;&nbsp;";
                            echo Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', array('permohonan/view-social-media', 'id'=>$responseTemp['id']));
                            }
                            ?>
                            </td>
                            
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

<?php

use yii\helpers\Url;

$script = <<< JS
	
	$(document).ready(function() {
		$('#btn-create-tagging').click(function(ev){ 
			document.location.href = '../administration/tagging-form';
		});
	});
	JS;
$this->registerJs($script, \yii\web\View::POS_END);
?>