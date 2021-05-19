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
    private $browserInfo = null;
    private $auditDetails = array();
    
    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $this->_url = Yii::$app->params['DreamFactoryContextURL'];
        $this->_url_procedure = Yii::$app->params['DreamFactoryContextURLProcedures'];
        //$this->_url_crawler = Yii::$app->params['DreamFactoryContextURLCrawler'];
        $this->_DFHeaderKey = Yii::$app->params['DreamFactoryHeaderKey'];
        $this->_DFHeaderPass = Yii::$app->params['DreamFactoryHeaderPass'];
        $ua = $this->getBrowser();
        $this->browserInfo =  $ua['name'] . " " . $ua['version'] . " on " .$ua['platform'];

        return [
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
        $otpSendDeviceList = array();
        
        // check post data and validate postdata and generate random OTP send it as email notifications
        if ($model->load(Yii::$app->request->post()) && $model->validate()) 
        { 
            $masterStatusSession = array_search("Logout",Yii::$app->mycomponent->getMasterData('master_status_session'));
            $masterStatusRecordStatus = array_search("Active",Yii::$app->mycomponent->getMasterData('master_status_record_status'));
            
            $data = Yii::$app->request->post(); 
            $client = new Client();
            /*
            ***** check if user entered email address is exists in database or not, If exists then proceed with next business logic
            */  
            $emailResponse = $client->createRequest()
                ->setFormat(Client::FORMAT_URLENCODED)
                ->setMethod('GET')
                ->setUrl($this->_url.'user?filter=email,eq,'.$data['EmailForm']['email'].'&filter=master_status_id,eq,'.$masterStatusRecordStatus.'&filter=is_login,eq,'.$masterStatusSession)
                ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
                ->send();
                 //check if user entered telegram id is exists in database or not, If exists then proceed with next business logic
                 /*if(count($emailResponse->data['records']) > 0)
                 { 
                     if(isset($emailResponse->data['records'][0]['telegram_id']) && !empty($emailResponse->data['records'][0]['telegram_id']))
                    {
                        $telegramResponse = $client->createRequest()
                        ->setFormat(Client::FORMAT_URLENCODED)
                        ->setMethod('GET')
                        ->setUrl($this->_url_crawler."func.telegram_sendmsg.php?chatid=".$emailResponse->data['records'][0]['telegram_id']."&msg=".rawurlencode("Oyi"))
                        ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
                        ->send();
                        if(isset($telegramResponse->data['ok']) && !empty($telegramResponse->data['ok']))
                        {
                            array_push($otpSendDeviceList,"telegram");
                        $this->auditDetails['master_audit_activity_id'] = array_search("Send Telegram",Yii::$app->mycomponent->getMasterData('master_audit_activity'));
                        $this->auditDetails['master_audit_log_type'] = array_search("External API Call",Yii::$app->mycomponent->getMasterData('audit_log_type'));
                        $this->auditDetails['user_id'] = $emailResponse->data['records'][0]['id'];
                        $this->auditDetails['master_user_type'] = $emailResponse->data['records'][0]['master_user_type_id'];
                        $this->auditDetails['description'] = "OTP send to telegram";
                        $this->auditDetails['user_agent'] = $this->browserInfo;
                        $this->auditDetails['ip_address'] = Yii::$app->request->userIP;
                        $responses = Yii::$app->helper->apiService('POST', 'audit_info', $this->auditDetails);
                        }
                    }
                    
                    //else{
                        //Yii::$app->session->addFlash('failed','telegram id is not correct');
                        //return $this->refresh();
                    //}
                }*/

                // check if user entered mobile number is exists in database or not, If exists then proceed with next business logic
                /*if(isset($emailResponse->data['records'][0]['mobile']) && !empty($emailResponse->data['records'][0]['mobile']))
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
                        array_push($otpSendDeviceList,"email");
                        $client = new Client();
                        $session = Yii::$app->session;
                        Yii::$app->session->setFlash('email', $data['EmailForm']['email']);
                        Yii::$app->session->setFlash('userId', $emailResponse->data['records'][0]['id']);
                        Yii::$app->session->setFlash('master_user_type', $emailResponse->data['records'][0]['master_user_type_id']);
                        $otpResponse = $client->createRequest()
                        ->setFormat(Client::FORMAT_URLENCODED)
                        ->setMethod('POST')
                        ->setUrl($this->_url.'otp_authentication')
                        ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
                        ->setData(["otp" => $otp,"email" => $data['EmailForm']['email'],"user_id" => $emailResponse->data['records'][0]['id']])
                        ->send();

                        $this->auditDetails['master_audit_activity_id'] = array_search("Send Email",Yii::$app->mycomponent->getMasterData('master_audit_activity'));
                        $this->auditDetails['master_audit_log_type'] = array_search("External API Call",Yii::$app->mycomponent->getMasterData('audit_log_type'));
                        $this->auditDetails['user_id'] = $emailResponse->data['records'][0]['id'];
                        $this->auditDetails['master_user_type'] = $emailResponse->data['records'][0]['master_user_type_id'];
                        $this->auditDetails['description'] = "OTP send to email";
                        $this->auditDetails['user_agent'] = $this->browserInfo;
                        $this->auditDetails['ip_address'] = Yii::$app->request->userIP;
                        $responses = Yii::$app->helper->apiService('POST', 'audit_info', $this->auditDetails);
                        // once email notifications successfully done then redirect to verifications page
                        if ($otpResponse->statusCode == 200) { 
                            $session->open();
                            $session->setFlash('otpDeviceList', $otpSendDeviceList);
                            Yii::$app->session->addFlash('notification','Sila Periksa E-mel Anda Untuk Kod OTP.');
                            $this->auditDetails['master_audit_activity_id'] = array_search("Token Request",Yii::$app->mycomponent->getMasterData('master_audit_activity'));
                            $this->auditDetails['master_audit_log_type'] = array_search("LEA Activity Log",Yii::$app->mycomponent->getMasterData('audit_log_type'));
                            $this->auditDetails['user_id'] = $emailResponse->data['records'][0]['id'];
                            $this->auditDetails['master_user_type'] = $emailResponse->data['records'][0]['master_user_type_id'];
                            $this->auditDetails['description'] = "OTP request";
                            $this->auditDetails['user_agent'] = $this->browserInfo;
                            $this->auditDetails['ip_address'] = Yii::$app->request->userIP;
                            $responses = Yii::$app->helper->apiService('POST', 'audit_info', $this->auditDetails);
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
                Yii::$app->session->setFlash('failed','E-mel tidak wujud dalam pangkalan data');
                return $this->refresh();

                }  
            }
        return $this->render('login', ['model' => $model]);
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
             $lessDate =  date("Y-m-d H:i:s", strtotime("-5 minutes"));
             $date =  date("Y-m-d H:i:s");
             $otp = Yii::$app->request->get('otp');
             $email = Yii::$app->request->get('email');
             $userId = Yii::$app->request->get('userId');
             $client = new Client();
             $otp_response = $client->createRequest()
             ->setFormat(Client::FORMAT_URLENCODED)
             ->setMethod('POST')
             //->setUrl($this->_url_procedure.'crud-api-procedures/check_user_islogged')//local
             ->setUrl($this->_url_procedure.'check_user_islogged')//live
             ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass,"Accept" => "*/*"])
             ->setData(["email" => $email,"otp" => $otp,"userId"=>$userId])
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
                            $session->set('userId', $otp_response->data['records']['id']);
                            $session->set('IC', $otp_response->data['records']['ic_no']);
                            $session->set('email', $otp_response->data['records']['email']);
                            $session->set('mobile', $otp_response->data['records']['mobile_no']);
                            $session->set('telegram_id', $otp_response->data['records']['telegram_id']);
                            $session->set('username', $otp_response->data['records']['fullname']);
                            $session->set('master_user_type', $otp_response->data['records']['master_user_type_id']);
                        } 
                        $this->auditDetails['master_audit_activity_id'] = array_search("Login Successful",Yii::$app->mycomponent->getMasterData('master_audit_activity'));
                        $this->auditDetails['master_audit_log_type'] = array_search("LEA Activity Log",Yii::$app->mycomponent->getMasterData('audit_log_type'));
                        $this->auditDetails['user_id'] = $session->get('userId');
                        $this->auditDetails['master_user_type'] = $session->get('master_user_type');
                        $this->auditDetails['description'] = "Login Successfull";
                        $this->auditDetails['user_agent'] = $this->browserInfo;
                        $this->auditDetails['ip_address'] = Yii::$app->request->userIP;
                        $responses = Yii::$app->helper->apiService('POST', 'audit_info', $this->auditDetails);   
                     
                     $responseInfo['status'] = 200;
                     $responseInfo['message'] = 'notification';
                     $responseInfo['info'] = 'Entered OTP is correct';
                     return $this->asJson($responseInfo);
                    }
                    else{ 
                        $this->auditDetails['master_audit_activity_id'] = array_search("Login Failure",Yii::$app->mycomponent->getMasterData('master_audit_activity'));
                        $this->auditDetails['master_audit_log_type'] = array_search("LEA Activity Log",Yii::$app->mycomponent->getMasterData('audit_log_type'));
                        $this->auditDetails['user_id'] = $session->get('userId');
                        $this->auditDetails['master_user_type'] = $session->get('master_user_type');
                        $this->auditDetails['description'] = "timeout";
                        $this->auditDetails['user_agent'] = $this->browserInfo;
                        $this->auditDetails['ip_address'] = Yii::$app->request->userIP;
                        $responses = Yii::$app->helper->apiService('POST', 'audit_info', $this->auditDetails);
                        
                        $responseInfo['status'] = 422;
                        $responseInfo['message'] = 'failed';
                        $responseInfo['info'] = 'Timeout';
                        return $this->asJson($responseInfo);
                    }

                }
                else if($otp_response->statusCode == 200 && count($otp_response->data['records']) == 0)
                { 
                    $this->auditDetails['master_audit_activity_id'] = array_search("Login Failure",Yii::$app->mycomponent->getMasterData('master_audit_activity'));
                    $this->auditDetails['master_audit_log_type'] = array_search("LEA Activity Log",Yii::$app->mycomponent->getMasterData('audit_log_type'));
                    $this->auditDetails['user_id'] = $session->get('userId');
                    $this->auditDetails['master_user_type'] = $session->get('master_user_type');
                    $this->auditDetails['description'] = "entered wrong otp ".Yii::$app->request->get('otp');
                    $this->auditDetails['user_agent'] = $this->browserInfo;
                    $this->auditDetails['ip_address'] = Yii::$app->request->userIP;
                    $responses = Yii::$app->helper->apiService('POST', 'audit_info', $this->auditDetails);
                   
                    $responseInfo['status'] = 422;
                   $responseInfo['message'] = 'failed';
                   $responseInfo['info'] = 'IOTP Tidak Sah';
                   return $this->asJson($responseInfo);
                }     
             else if($otp_response->statusCode != 200)
             {  
                $this->auditDetails['master_audit_activity_id'] = array_search("Login Failure",Yii::$app->mycomponent->getMasterData('master_audit_activity'));
                $this->auditDetails['master_audit_log_type'] = array_search("LEA Activity Log",Yii::$app->mycomponent->getMasterData('audit_log_type'));
                $this->auditDetails['user_id'] = $session->get('userId');
                $this->auditDetails['master_user_type'] = $session->get('master_user_type');
                $this->auditDetails['description'] = "entered wrong otp ".Yii::$app->request->get('otp');
                $this->auditDetails['user_agent'] = $this->browserInfo;
                $this->auditDetails['ip_address'] = Yii::$app->request->userIP;
                $responses = Yii::$app->helper->apiService('POST', 'audit_info', $this->auditDetails);
                
                $responseInfo['status'] = 422;
                $responseInfo['message'] = 'failed';
                $responseInfo['info'] = 'OTP Tidak Sah';
                return $this->asJson($responseInfo);
             }
        }   
        else
        {
        return $this->render('validationCode', ['model' => $model,'email' => Yii::$app->session->getFlash('email'),'userId' => Yii::$app->session->getFlash('userId')]);
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
