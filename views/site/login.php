<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    
   <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">CMS 2.0</h3></div>
                                    <div class="card-body">
                                    <div class="float-left mb-2">
                                        <h4>Log In - LEA</h4>
                                    </div>
                                        <form>

                                        <div class="form-group">
                                        <div class="input-group input-group-md">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                            </div>
                                            <input type="email" class="form-control" placeholder="E-mail address">
                                        </div>
                                        </div>

                                           <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0 float-right">
                                                <button class="btn btn-primary">Seterusnya</button>
                                            </div>
                                        </form>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>    
</div>
