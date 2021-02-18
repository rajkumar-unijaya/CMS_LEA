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
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
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
            /*if(Yii::$app->mailer->compose('verification', ['code' => $otp])
            ->setFrom($data['EmailForm']['email'])
            ->setTo('zoie17@ethereal.email')
            ->setSubject('Email sent from cms project')
            ->send())
            {
                /*$data = Yii::$app->request->post();
                $session = Yii::$app->session;
                $session->set('email', $data['EmailForm']['email']);
                $otpAuth->otp = $otp;
                $otpAuth->ip = 12345;
                $otpAuth->email = $data['EmailForm']['email'];
                if($otpAuth->save())
                {
                Yii::$app->session->addFlash('notification','Please check your email address for OTP.');
                 $this->redirect('index.php?r=auth/validation-code');
                }*/
                $client = new Client();
                $session = Yii::$app->session;
                $session->set('email', $data['EmailForm']['email']);
                $response = $client->createRequest()
                ->setFormat(Client::FORMAT_URLENCODED)
                ->setMethod('POST')
                ->setUrl('http://127.0.0.1:8000/api/login')
                ->setHeaders(['X-DreamFactory-API-Key' => '323326d1fc16ee93ee80df98d023e2caa73aa2b1911bd6ea9b83b311d09982f2'])
                ->setData(["otp" => $otp,"ip" => '12345',"email" => $data['EmailForm']['email']])
                ->send();
            if ($response->isOk) {
                Yii::$app->session->addFlash('notification','Please check your email address for OTP.');
                $this->redirect('index.php?r=auth/validation-code');
            //}
                
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
        $this->layout =  'login';
        $session = Yii::$app->session;
        $model = new ValidationCodeForm();
        if (Yii::$app->request->post()) {
            date_default_timezone_set("Asia/Kuala_Lumpur");
            $lessDate =  date("Y-m-d H:i:s", strtotime("-5 minutes"));
            $date =  date("Y-m-d H:i:s");
            
           $data = Yii::$app->request->post();
           $otp = implode("",$data['validationCode']);
           $emailInfo = OtpAuthentication::find()->where(['email' => $data['email']])->orderBy(['id' => SORT_DESC])->one();
           if($emailInfo)
           { 
            $otpInfo = OtpAuthentication::find()->where(['email' => $data['email'],'otp' => $otp])->orderBy(['id' => SORT_DESC])->one();
           }
           else{  
            Yii::$app->session->addFlash('failed','email does not exists.');
            return  $this->redirect(array('auth/validation-code'));
           }
           if($otpInfo)
           { 
            $timeInfo = OtpAuthentication::find()->where(['email' => $data['email'],'otp' => $otp])->orderBy(['id' => SORT_DESC])->andWhere(['between', 'generated', $lessDate,$date])->one(); 
           }
           else{  
            Yii::$app->session->addFlash('failed','you entered invalid OTP');
            return  $this->redirect(array('auth/validation-code'));
           }
           if($timeInfo)
           {  
            Yii::$app->session->addFlash('notification','Please check your email address for OTP.');
            $this->redirect(array('dashboard/index'));
           }
           else{  
            Yii::$app->session->addFlash('failed','You entered OTP is timeout');
            return  $this->redirect(array('auth/validation-code'));
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
        $email =  Yii::$app->request->get('email');
        $otpAuth = new OtpAuthentication;
         $otp = rand(100000, 999999);
            if(Yii::$app->mailer->compose('verification', ['code' => $otp])
            ->setFrom($email)
            ->setTo('zoie17@ethereal.email')
            ->setSubject('Email sent from cms project')
            ->send())
            {
                $otpAuth->otp = $otp;
                $otpAuth->ip = 12345;
                $otpAuth->email = $email;
                if($otpAuth->save())
                {
                    $responseInfo['status'] = 200;
                    $responseInfo['message'] = 'send';
                    $response = Yii::$app->response;
                    $response->format = \yii\web\Response::FORMAT_JSON;
                    $response->data = $responseInfo;
                    return $response;
                }
                else{
                    $responseInfo['status'] = 422;
                    $responseInfo['message'] = 'failed';
                    $response = Yii::$app->response;
                    $response->format = \yii\web\Response::FORMAT_JSON;
                    $response->data = $responseInfo;
                    return $response;   
                }
                
            }
    }
}
