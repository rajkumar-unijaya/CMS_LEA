<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php
if (Yii::$app->session->hasFlash('success')) {
	echo "<div class='alert alert-success'>" . Yii::$app->session->getFlash('success')[0] . "</div>";
}
?>

<div class="container-fluid">
    <h3 style="padding-top: 1.5rem;">Tentang CMS</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard/index">Laman Utama</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tentang CMS</li>
        </ol>
    </nav>

    <div class="row">
			<div class="col-lg-12">
				<div class="card card-outline-info">
         <div class="card-body">
                <label>Case management System (CMS) is an initiative by the Malaysian Communications 
                and Multimedia Commission to facilitate the Law Enforcement Agency (LEA) or statutory / non-statutory 
                agencies to submit application for assistance in providing information for the purpose of the Royal 
                Malaysian Police Inquiry.  
                

                
                </label>
              </div>
</div>
</div>
</div>
</div>