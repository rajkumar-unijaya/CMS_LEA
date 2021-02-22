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
    private $_DFHeaderKey = null;
    private $_DFHeaderPass = null;
    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $this->_url = Yii::$app->params['DreamFactoryContextURL'];
        $this->_DFHeaderKey = Yii::$app->params['DreamFactoryHeaderKey'];
        $this->_DFHeaderPass = Yii::$app->params['DreamFactoryHeaderPass'];
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
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
        $model = new EmailForm();
        $otpAuth = new OtpAuthentication;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) { 
            $data = Yii::$app->request->post();
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
                $response = $client->createRequest()
                ->setFormat(Client::FORMAT_URLENCODED)
                ->setMethod('POST')
                //->setUrl($this->_url.'login')
                ->setUrl($this->_url.'otp_authentication')
                ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
                ->setData(["otp" => $otp,"email" => $data['EmailForm']['email']])
                ->send();
            if ($response->isOk) {
                Yii::$app->session->addFlash('notification','Check your email for OTP.');
                $this->redirect('index.php?r=auth/validation-code');
            }          
            
        }
    }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

     /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }
        $this->layout =  'login';

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }
        $this->layout =  'login';

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }


    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }
        $this->layout =  'login';

        return $this->render('resetPassword', [
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
            date_default_timezone_set("Asia/Kuala_Lumpur");
            $lessDate =  date("Y-m-d H:i:s", strtotime("-5 minutes"));
             $date =  date("Y-m-d H:i:s");
            $otp = Yii::$app->request->get('otp');
                $client = new Client();
                $session = Yii::$app->session;
                $response = $client->createRequest()
                ->setFormat(Client::FORMAT_URLENCODED)
                ->setMethod('GET')
                ->setUrl($this->_url.'otp_authentication?filter=email,eq,'.Yii::$app->request->get('email').'&order=id,desc&size=1')
                ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
                ->send();
                if (isset($response->data['records']) && count($response->data['records']) > 0) { 
                    $dbOTP = $response->data['records'][0]['otp'];
                    $dbGenerated = $response->data['records'][0]['generated']; 

                    if(isset($dbOTP) && $dbOTP == $otp )
                    { 
                     if(isset($dbGenerated) && $dbGenerated >= $lessDate )
                    { 
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
                    else{ 
                         $responseInfo['status'] = 422;
                         $responseInfo['message'] = 'failed';
                         $responseInfo['info'] = 'Invalid OTP entered';
                         return $this->asJson($responseInfo);
                    }                   
                }
                elseif(!$session->has('email')){
                    return  $this->redirect(array('auth/login'));
                }
                else{ 
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
                ->setData(["otp" => $otp,"email" => $email])
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
}
