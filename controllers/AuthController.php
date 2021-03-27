<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\EmailForm;
use app\models\OtpAuthentication;
use app\models\ValidationCodeForm;
use app\models\ContactForm;
use app\models\SignupForm;
use app\models\PasswordResetRequestForm;
use yii\httpclient\Client;



class AuthController extends Controller
{
    
    private $_url = null;
    private $_url_procedure = null;
    private $_url_crawler = null;
    private $_DFHeaderKey = null;
    private $_DFHeaderPass = null;
    
    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $this->_url = Yii::$app->params['DreamFactoryContextURL'];
        $this->_url_procedure = Yii::$app->params['DreamFactoryContextURLProcedures'];
        $this->_url_crawler = Yii::$app->params['DreamFactoryContextURLCrawler'];
        $this->_DFHeaderKey = Yii::$app->params['DreamFactoryHeaderKey'];
        $this->_DFHeaderPass = Yii::$app->params['DreamFactoryHeaderPass'];
        return [
            /*'access' => [
                'class' => AccessControl::className(),
                //'only' => ['logout'],
                'rules' => [
                    [
                        //'actions' => ['logout'],
                        //'allow' => true,
                        //'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'logout' => ['post'],
                ],
            ],*/
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {  
        $this->layout =  'login';
        //email form for serverside validations
        $model = new EmailForm();
        $otpAuth = new OtpAuthentication;
        // check post data and validate postdata and generate random OTP send it as email notifications
        if ($model->load(Yii::$app->request->post()) && $model->validate()) 
        { 
            $data = Yii::$app->request->post(); 
            $client = new Client();
            $statusResponse = $client->createRequest()
                ->setFormat(Client::FORMAT_URLENCODED)
                ->setMethod('GET')
                ->setUrl($this->_url.'master_status?filter=category,eq,record_status&filter=name,eq,active')
                ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
                ->send();
            /*
            ***** check if user entered email address is exists in database or not, If exists then proceed with next business logic
            */    
            $emailResponse = $client->createRequest()
                ->setFormat(Client::FORMAT_URLENCODED)
                ->setMethod('GET')
                ->setUrl($this->_url.'user?filter=email,eq,'.$data['EmailForm']['email'].'&filter=master_status_id,eq,'.$statusResponse->data['records'][0]['id'].'&filter=is_login,eq,17')
                ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
                ->send();
                 //check if user entered telegram id is exists in database or not, If exists then proceed with next business logic
                
               /* if(isset($emailResponse->data['records'][0]['telegram_id']) && !empty($emailResponse->data['records'][0]['telegram_id']))
                { 
                    $telegramResponse = $client->createRequest()
                    ->setFormat(Client::FORMAT_URLENCODED)
                    ->setMethod('GET')
                    ->setUrl($this->_url_crawler."func.telegram_sendmsg.php?chatid=".$emailResponse->data['records'][0]['telegram_id']."&msg=testing purpose")
                    ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
                    ->send();
                    
                      if(empty($telegramResponse['ok']))
                      {
                        Yii::$app->session->addFlash('failed','telegram id is not correct');
                        return $this->refresh();
                      }
                    
                }  
                // check if user entered mobile number is exists in database or not, If exists then proceed with next business logic

                if(isset($emailResponse->data['records'][0]['mobile']) && !empty($emailResponse->data['records'][0]['mobile']))
                { 
                    $mobileNo = "60".$emailResponse->data['records'][0]['mobile'];
                    $message = "Testing purpose";
                    $mobileResponse = $client->createRequest()
                    ->setFormat(Client::FORMAT_URLENCODED)
                    ->setMethod('POST')
                    ->setUrl($this->_url_crawler."func.sms.php")
                    ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
                    ->setData(["phone" => $mobileNo,"msg" => $message])
                    ->send();
                    
                      if(empty($mobileResponse['ok']))
                      {
                        Yii::$app->session->addFlash('failed','mobile is not correct');
                        return $this->refresh();
                      }
                    
                }  */

                /*
                *** if email is exists then generate OTP and send it to email & sms & telegram id
                */
                if($emailResponse->statusCode == 200 && count($emailResponse->data['records']) > 0)
                { 
                      $otp = rand(100000, 999999);
                    if(Yii::$app->mailer->compose('verification', ['code' => $otp])
                    ->setFrom($data['EmailForm']['email'])
                    ->setTo('zoie17@ethereal.email')
                    ->setSubject('Email sent from cms project')
                    ->send())
                    { 
                        $client = new Client();
                        $session = Yii::$app->session;
                        $session->set('email', $data['EmailForm']['email']);
                        $session->set('userId', $emailResponse->data['records'][0]['id']);
                        $otpResponse = $client->createRequest()
                        ->setFormat(Client::FORMAT_URLENCODED)
                        ->setMethod('POST')
                        ->setUrl($this->_url.'otp_authentication')
                        ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
                        ->setData(["otp" => $otp,"email" => $data['EmailForm']['email'],"user_id" => $emailResponse->data['records'][0]['id']])
                        ->send();
                        // once email notifications successfully done then redirect to verifications page
                        if ($otpResponse->statusCode == 200) { 
                            $session->open();
                            Yii::$app->session->addFlash('notification','Check your email for OTP.');
                            $this->redirect('../auth/validation-code');
                        }
                        else
                        { 
                            Yii::$app->session->addFlash('failed','OTP not save in database.');
                            return $this->refresh();

                        }          
                    
                    }

                }
                else
                { 
                Yii::$app->session->setFlash('failed','email not exists in database');
                return $this->refresh();

                }  
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionValidationCode()
    {  
        $url = Yii::$app->params['DreamFactoryContextURL'];
        $this->layout =  'login';
        $session = Yii::$app->session;
        $model = new ValidationCodeForm();
        //default timezone is UTC it has configured at web.php
        if (Yii::$app->request->get('email') && Yii::$app->request->get('otp')) {
             $lessDate =  date("Y-m-d H:i:s", strtotime("-1 minutes"));
             $date =  date("Y-m-d H:i:s");
             $otp = Yii::$app->request->get('otp');
             $email = Yii::$app->request->get('email');
             $client = new Client();
             $otp_response = $client->createRequest()
             ->setFormat(Client::FORMAT_URLENCODED)
             ->setMethod('POST')
             //->setUrl($this->_url_procedure.'crud-api-procedures/check_user_islogged')//local
             ->setUrl($this->_url_procedure.'check_user_islogged')//live
             ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass,"Accept" => "*/*"])
             ->setData(["email" => $email,"otp" => $otp,"userId"=>$session->get('userId')])
             ->send(); 
             /*
             *** check if email & otp is check in table if correct then session will create and redirect to dashboard page
             */
             if($otp_response->statusCode == 200 && count($otp_response->data['records']) > 0)
                { 
                    if(isset($otp_response->data['records']['generatedDate']) && $otp_response->data['records']['generatedDate'] >= $lessDate )
                    { 
                        if ($session->isActive)
                        { 
                            $session->set('IC', $otp_response->data['records']['ic_no']);
                            $session->set('email', $otp_response->data['records']['email']);
                            $session->set('mobile', $otp_response->data['records']['mobile_no']);
                            $session->set('telegram_id', $otp_response->data['records']['telegram_id']);
                            $session->set('username', $otp_response->data['records']['fullname']);
                        } 
                     $responseInfo['status'] = 200;
                     $responseInfo['message'] = 'notification';
                     $responseInfo['info'] = 'Entered OTP is correct';
                     return $this->asJson($responseInfo);
                    }
                    else{ 
                        $responseInfo['status'] = 422;
                        $responseInfo['message'] = 'failed';
                        $responseInfo['info'] = 'Timeout';
                        return $this->asJson($responseInfo);
                    }

                }
                else if($otp_response->statusCode == 200 && count($otp_response->data['records']) == 0)
                { 
                   $responseInfo['status'] = 422;
                   $responseInfo['message'] = 'failed';
                   $responseInfo['info'] = 'Invalid OTP entered';
                   return $this->asJson($responseInfo);
                }     
             else if($otp_response->statusCode != 200)
             {  
                $responseInfo['status'] = 422;
                $responseInfo['message'] = 'failed';
                $responseInfo['info'] = 'Invalid OTP entered';
                return $this->asJson($responseInfo);
             }
        }   
        else
        {
        return $this->render('validationCode', [
        'model' => $model,'email' => $session->get('email')
        ]);
        }
    }



     /**
     * Resend action.
     *
     * @return Response|string
     */
    public function actionResend()
    {  
        $session = Yii::$app->session;
        $url = Yii::$app->params['DreamFactoryContextURL'];
        $email =  Yii::$app->request->get('email');
        $otpAuth = new OtpAuthentication;
         $otp = rand(100000, 999999);
            if(Yii::$app->mailer->compose('verification', ['code' => $otp])
            ->setFrom($email)
            ->setTo('zoie17@ethereal.email')
            ->setSubject('Email sent from cms project')
            ->send())
            {
                $client = new Client();
                $response = $client->createRequest()
                ->setFormat(Client::FORMAT_URLENCODED)
                ->setMethod('POST')
                ->setUrl($this->_url.'otp_authentication')
                ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
                ->setData(["otp" => $otp,"email" => $email,"user_id" => $session->get('userId')])
                ->send();
            if (!empty($response->data)) {
                    $responseInfo['status'] = 200;
                    $responseInfo['message'] = 'send';
                    return $this->asJson($responseInfo);
                
            }
            else{
                $responseInfo['status'] = 422;
                $responseInfo['message'] = 'failed';
                return $this->asJson($responseInfo); 
            }
        }
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    { 
        $session = Yii::$app->session;
        $client = new Client();
        $sessionResponse = $client->createRequest()
                ->setFormat(Client::FORMAT_URLENCODED)
                ->setMethod('PUT')
                ->setUrl($this->_url.'session/'.$session->Id)
                ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
                ->setData(["is_login" => 17])
                ->send();
                
        Yii::$app->user->logout();
        session_destroy();
        setcookie("PHPSESSID", NULL, time()-1,"/");
        return $this->redirect('../auth/login');
    }
}
