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
    <h1 style="padding-top: 1.5rem;">Tentang CMS</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard/index">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tentang CMS</li>
        </ol>
    </nav>
    
  <div class="panel panel-default">
    <div class="panel-body">Case management System (CMS) is an initiative by the Malaysian Communications and Multimedia Commission to facilitate the Law Enforcement Agency (LEA) or statutory / non-statutory agencies to submit application for assistance in providing information for the purpose of the Royal Malaysian Police Inquiry.  </div>
  </div>
</div>