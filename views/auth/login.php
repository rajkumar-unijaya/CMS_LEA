<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\helpers\Url;
//use yii\bootstrap\ActiveForm;
use yii\widgets\ActiveForm;

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
                                    <?php 
                                    $action = Url::to(['/auth/login']);
                                    $form =  ActiveForm::begin(['action' => $action, 'method' => 'post','id' => 'emailForm','enableClientValidation' => true])
                                    ?>

                                        <div class="form-group"><?= $form->field($model, 'email')->label(false)->textInput(['placeholder' => "Enter Your Email"]) ?>
                                        <!--<div class="input-group input-group-md">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                            </div>
                                            <input type="email" class="form-control" placeholder="E-mail address">
                                        </div>-->
                                        </div>
                                        

                                           <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0 float-right">
                                           <?= Html::submitButton('Seterusnya', ['class' => 'btn btn-primary']) ?>
                                                
                                            </div>
                                            <?php  ActiveForm::end() ?>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>    
</div>
