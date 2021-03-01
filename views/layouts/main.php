<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\DashboardAsset;
//use app\assets\AppAsset;

DashboardAsset::register($this);
//AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="sb-nav-fixed">
<?php $this->beginBody() ?>

    <!-- header tab -->
    <header>
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand">CMS 2.0 LEA</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fa fa-bars"></i></button>
            <ul class="ml-auto mr-0 mt-auto mb-auto">
                    <a class="dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="w-auto" src="avatar.png" alt="User 1" class="avatar">    
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="../misc/aboutcms">Tentang CMS</a>
                        <a class="dropdown-item" href="../misc/guidelines">Garis Panduan</a>
                        <a class="dropdown-item" href="../misc/profile">Lihat Profil</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="login.html">Log Keluar</a>
                    </div>
                    
            </ul>
        </nav>

    </header>
    

    <!-- side menu tab -->
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Menu</div>
                        <!-- <a class="nav-link collapsed" href="../dashboard" data-toggle="collapse" data-target="#collapseDashboardPages" aria-expanded="false" aria-controls="collapseDashboardPages">
                            -- <div class="sb-nav-link-icon" >
                                sss
                            </div> --
                        </a> -->

                        <a class="nav-link" href="../dashboard">&nbsp;&nbsp;Dashboard</a>
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePermohonanPages" aria-expanded="false" aria-controls="collapsePages">
                            <div class="sb-nav-link-icon"><i class="fa fa-book-open"></i></div>
                            Permohonan
                            <div class="sb-sidenav-collapse-arrow"><i class="fa fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsePermohonanPages" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">

                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="../permohonan/mediasosial">Melalui Media Sosial</a>
                                    <a class="nav-link" href="../permohonan/mntl">Melalui MNTL</a>
                                    <a class="nav-link" href="../permohonan/baru">Permohonan Baru</a>
                                </nav>
                            </nav>
                        </div> 
                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                            <div class="sb-nav-link-icon"><i class="fa fa-book-open"></i></div>
                            Statistik/Laporan
                            <div class="sb-sidenav-collapse-arrow"><i class="fa fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                    Authentication
                                    <div class="sb-sidenav-collapse-arrow"><i class="fa fa-angle-down"></i></div>
                                </a>
                                <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link" href="index.php?r=auth/login">Login</a>
                                        <a class="nav-link" href="index.php?r=auth/validation-code">Verification Code</a>
                                        <a class="nav-link" href="index.php?r=auth/signup">Register</a>
                                        <a class="nav-link" href="index.php?r=auth/request-password-reset">Forgot Password</a>
                                    </nav>
                                </div>
                            </nav>
                        </div>
                    </div>

                </div>

            </nav>
        </div>

        
        
        <div id="layoutSidenav_content">

            <!-- main content -->
            <main>

                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <div class="container-fluid">
                    <?= $content ?> 
                </div>
            <main>

        </div>
        
            <!-- footer -->
            <!-- <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2020</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer> -->
    </div>




<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
