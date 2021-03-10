<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\PermohonanForm;

class PermohonanController extends Controller
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
     * Displays Permohonan using MNTL page.
     *
     * @return string
     */
    public function actionMntl()
    {
        $this->layout =  'main';
        return $this->render('mntl');
    }

    /**
     * Displays Permohonan Baru page.
     *
     * @return string
     */
    public function actionMediasosial()
    {
        $this->layout =  'main';
        return $this->render('mediasosial');
    }
    
    /**
     * Displays Permohonan Baru page.
     *
     * @return string
     */
    public function actionBaru()
    {
        $this->layout =  'main';
        $model = new PermohonanForm();
		$masterStatusSuspect = Yii::$app->mycomponent->statusSuspect();
        //echo"<pre>";print_r($masterStatusSuspect);exit;
		if ($model->load(Yii::$app->request->post()) && $model->validate()) { 
			$data = Yii::$app->request->post();
					
			$url = Yii::$app->params['DreamFactoryContextURL'];
			$data = Yii::$app->request->post();
			$client = new Client();
			$responses = $client->createRequest()
			->setFormat(Client::FORMAT_URLENCODED)
			->setMethod('POST')
			->setUrl($this->_url.'offence')
			->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
			->setData(["name" => $data['OffenceCreate']['offence']])
			->send();
			if ($responses->isOk) {
					Yii::$app->session->addFlash('success','Successfully added new Offence.');
			}
		}
		
		return $this->render('baru',['model'=>$model,"masterStatusSuspect" => $masterStatusSuspect]);
        
    }
    // /**
    //  * Login action.
    //  *
    //  * @return Response|string
    //  */
    // public function actionLogin()
    // {
    //     if (!Yii::$app->user->isGuest) { 
    //         return $this->goHome();
    //     }
    //     $this->layout =  'login';
        
    //     $model = new LoginForm();
    //     if ($model->load(Yii::$app->request->post()) && $model->login()) {
    //         return $this->goBack();
    //     }

    //     $model->password = '';
    //     return $this->render('login', [
    //         'model' => $model,
    //     ]);
    // }

    // /**
    //  * Logout action.
    //  *
    //  * @return Response
    //  */
    // public function actionLogout()
    // {
    //     Yii::$app->user->logout();

    //     return $this->goHome();
    // }

}
