<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

class DashboardController extends Controller
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
        $this->layout =  'main';
        return $this->render('index');
    }
    /*****
     * 
     * save session in to db
     */

    public function afterAction($action, $result)
	{ 
        $session = Yii::$app->session;
        $timeoutVal = 0;
        if ($session->has('sessionTimeOut'))
        {
            $timeoutVal = $session->get('sessionTimeOut');
        }
        if($timeoutVal > 0 && $session->get('sessionTimeOut') < time() && !(Yii::$app->controller->id == 'auth' && Yii::$app->controller->action->id == 'login'))
        {
            return $this->redirect('../auth/logout');
        }
        if(!empty($session->Id) && !(Yii::$app->controller->id == 'auth' && Yii::$app->controller->action->id == 'login'))
        { 
         if(parent::checkSession($action))
        { 
             return $result;
        }
        }
        return false;
	}

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        $this->layout =  'main';
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionGetMasterData()
    {
        $responseInfo['message'] = 'failed';
        $masterResult = array();
        $data = Yii::$app->request->post();
        $options = "<option>".$data['default_option']."</option>";
        $masterResult = Yii::$app->mycomponent->getMasterDataBasedOnParentId($data['id'],$data['data_group']);
        $response = array();
        if(count($masterResult) > 0)
        {
            $responseInfo['status'] = 200;
            $responseInfo['message'] = 'success';
            foreach($masterResult as $key => $val):
                $options .= "<option value='".$key."'>".$val."</option>";
            endforeach;
            $responseInfo['result'] = $options;
            
        }
        else{
            $responseInfo['message'] = 'failed';
            $responseInfo['status'] = 200;
            $responseInfo['result'] = "";
        }
        return $this->asJson($responseInfo);
    }
}
