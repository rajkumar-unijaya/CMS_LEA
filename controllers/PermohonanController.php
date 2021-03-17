<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\PermohonanForm;
use app\models\BlockRequestForm;
use yii\httpclient\Client;
use yii\web\UploadedFile;

class PermohonanController extends Controller
{
    private $_url = null;
    private $_url_procedure = null;
    private $_url_crawler = null;
    private $_DFHeaderKey = null;
    private $_DFHeaderPass = null;
    private $_DFHeaderPasslive = null;
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
        $this->_DFHeaderPasslive = Yii::$app->params['DreamFactoryHeaderPassLive'];
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
        $masterCaseInfoTypeId = 1;
        /******
         * load masterdata from the master component and pass these data into view page
         */
		$masterStatusSuspect = Yii::$app->mycomponent->statusSuspect();
		$purposeOfApplication = Yii::$app->mycomponent->purposeOfApplication();
		$newCase = Yii::$app->mycomponent->newCase();
        $suspectOrSaksi = Yii::$app->mycomponent->suspectOrSaksi();
        $masterSocialMedia = Yii::$app->mycomponent->masterSocialMedia();
        $client = new Client();
        $offenceResponse = array();
        $filterOffenceResponse = array();

        /******
         * Get offence master data from the offence table using api service.
         */
        $offenceResponse = $client->createRequest()
                ->setFormat(Client::FORMAT_URLENCODED)
                ->setMethod('GET')
                ->setUrl($this->_url.'offence?include=id,name')
                ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
                ->send();
               
                if(isset($offenceResponse->data['records']) && count($offenceResponse->data['records']) > 0)
                {
                    foreach($offenceResponse->data['records'] as $key => $value)
                {
                    $filterOffenceResponse[$value['id']] = $value['name'];
                }
                }

          /*********
           * once validation is success then set the data as an array and convert these data into json object and then pass it to stored procedure as a arguments
           * 
           *  */     
        if ($model->load(Yii::$app->request->post()) && $model->validate()) { 
            $data = Yii::$app->request->post();

            //$model->surat_rasmi = UploadedFile::getInstance($model, 'surat_rasmi');
            //$model->laporan_polis = UploadedFile::getInstance($model, 'laporan_polis');
            //$model->surat_rasmi->saveAs('uploads/surat_rasmi/' . $data['PermohonanForm']['report_no'].'_'.$model->surat_rasmi->baseName .'_'.date('Y_m_d_H_i_s'). '.' . $model->surat_rasmi->extension);
            //$model->laporan_polis->saveAs('uploads/laporan_polis/' . $data['PermohonanForm']['report_no'].'_'.$model->laporan_polis->baseName .'_'.date('Y_m_d_H_i_s'). '.' . $model->laporan_polis->extension);
            $caseInfo = array();
            $caseStatusSuspek = array();
            $caseInvolvedURL = array();
            $offences = array();
            
            $caseInfo['master_case_info_type_id'] = $data['PermohonanForm']['masterCaseInfoTypeId'];
            $caseInfo['requestor_ref'] = 1;
            $caseInfo['bagipihak_dirisendiri'] = $data['PermohonanForm']['for_self'];
            $caseInfo['no_telephone'] = $data['PermohonanForm']['no_telephone'];
            $caseInfo['email'] = $data['PermohonanForm']['email'];
            $caseInfo['report_no'] = $data['PermohonanForm']['report_no'];
            $caseInfo['investigation_no'] = $data['PermohonanForm']['investigation_no'];
            $caseInfo['case_summary'] = $data['PermohonanForm']['case_summary'];
            //$caseInfo['surat_rasmi'] = 'uploads/surat_rasmi/' .$data['PermohonanForm']['report_no'].'_'.$model->surat_rasmi->baseName .'_'.date('Y_m_d_H_i_s'). '.' . $model->surat_rasmi->extension;
            //$caseInfo['laporan_polis'] = 'uploads/laporan_polis/' .$data['PermohonanForm']['report_no'].'_'.$model->laporan_polis->baseName .'_'.date('Y_m_d_H_i_s'). '.' . $model->laporan_polis->extension;
            $caseInfo['surat_rasmi'] = "avtar.jpg";
            $caseInfo['laporan_polis'] = "avtar1.jpg";
            if(isset($data['PermohonanForm']['application_purpose']) && !empty($data['PermohonanForm']['application_purpose']))
            {
            $caseInfo['master_status_purpose_of_application_id'] = implode(",",$data['PermohonanForm']['application_purpose']);
            $caseInfo['purpose_of_application_info'] = $data['PermohonanForm']['application_purpose_info'];
            }
            

            for($i=0;$i<=count($data['PermohonanForm']['master_status_status_suspek_id'])-1;$i++)
            {
                $caseStatusSuspek[$i]['master_status_suspect_or_saksi_id']  = $data['PermohonanForm']['master_status_suspect_or_saksi_id'][$i];
                $caseStatusSuspek[$i]['master_status_status_suspek_id']  = $data['PermohonanForm']['master_status_status_suspek_id'][$i];
                $caseStatusSuspek[$i]['ic']  = $data['PermohonanForm']['ic'][$i];
                $caseStatusSuspek[$i]['name']  = $data['PermohonanForm']['name'][$i];
                if(isset($data['PermohonanForm']['others'][$i]) && !empty($data['PermohonanForm']['others'][$i]))
                {
                    $caseStatusSuspek[$i]['others']  = $data['PermohonanForm']['others'][$i];
                }
                
            }
            for($i=0;$i<=count($data['PermohonanForm']['url'])-1;$i++)
            { 
                if(!empty($data['PermohonanForm']['master_social_media_id'][$i]))
                {
                    $caseInvolvedURL[$i]["master_social_media_id"]  = $data['PermohonanForm']['master_social_media_id'][$i];
                    $caseInvolvedURL[$i]["url"]  = $data['PermohonanForm']['url'][$i];
                }
                
            }
            $offences = $data['PermohonanForm']['offence'];

            
            //echo'<pre>';print_r($caseStatusSuspek);exit;
            //echo json_encode($caseInfo).'<br>';//exit;
            //echo json_encode($caseStatusSuspek).'<br>';
            //echo json_encode($caseInvolvedURL).'<br>';
            //echo json_encode($offences).'<br>';exit;

            $caseInfoResponse = $client->createRequest()
            ->setFormat(Client::FORMAT_URLENCODED)
            ->setMethod('POST')
            //->setUrl($this->_url_procedure.'crud-api-procedures/case_info')
            ->setUrl($this->_url_procedure.'case_info')
            ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass,"Accept" => "*/*"])
            ->setData(["caseInfo" => json_encode($caseInfo),"caseStatusSuspek" => json_encode($caseStatusSuspek),"caseInvolvedURL" => json_encode($caseInvolvedURL),"offences" => json_encode($offences)])
            ->send(); 
            if($caseInfoResponse->statusCode == 200 && count($caseInfoResponse->data['records']) > 0)
                { 
                    Yii::$app->session->addFlash('success','Successfully added new case infomation.');
                    return $this->redirect('../dashboard/index');
                }
                else{
                    Yii::$app->session->addFlash('failed','New case infomation not inserted successfully.');
                    return $this->redirect(Yii::$app->request->referrer);
                }
            
		}
        return $this->render('baru',['model'=>$model,"masterStatusSuspect" => $masterStatusSuspect,"purposeOfApplication" => $purposeOfApplication,"newCase" => $newCase,"offences" => $filterOffenceResponse,"suspectOrSaksi" => $suspectOrSaksi,"masterSocialMedia" => $masterSocialMedia,"masterCaseInfoTypeId" => $masterCaseInfoTypeId]);
        
    }


    /**
     * Displays Permohonan Baru page.
     *
     * @return string
     */
    public function actionBlockRequest()
    {
        $this->layout =  'main';
        $model = new BlockRequestForm();
        //echo'<pre>';print_r($model);exit;
        $masterCaseInfoTypeId = 2;

        /******
         * load masterdata from the master component and pass these data into view page
         */
		$masterStatusSuspect = Yii::$app->mycomponent->statusSuspect();
		$purposeOfApplication = Yii::$app->mycomponent->purposeOfApplication();
		$newCase = Yii::$app->mycomponent->newCase();
        $suspectOrSaksi = Yii::$app->mycomponent->suspectOrSaksi();
        $masterSocialMedia = Yii::$app->mycomponent->masterSocialMedia();
        $client = new Client();
        $offenceResponse = array();
        $filterOffenceResponse = array();

        /******
         * Get offence master data from the offence table using api service.
         */
        $offenceResponse = $client->createRequest()
                ->setFormat(Client::FORMAT_URLENCODED)
                ->setMethod('GET')
                ->setUrl($this->_url.'offence?include=id,name')
                ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
                ->send();
               
                if(isset($offenceResponse->data['records']) && count($offenceResponse->data['records']) > 0)
                {
                    foreach($offenceResponse->data['records'] as $key => $value)
                {
                    $filterOffenceResponse[$value['id']] = $value['name'];
                }
                }
                //echo'<pre>';print_r($filterOffenceResponse);exit;
        /*********
           * once validation is success then set the data as an array and convert these data into json object and then pass it to stored procedure as a arguments
           * 
           *  */     
          if ($model->load(Yii::$app->request->post()) && $model->validate()) { 
            $data = Yii::$app->request->post();

            $model->surat_rasmi = UploadedFile::getInstance($model, 'surat_rasmi');
            $model->laporan_polis = UploadedFile::getInstance($model, 'laporan_polis');
            $model->surat_rasmi->saveAs('uploads/surat_rasmi/' . $data['BlockRequestForm']['report_no'].'_'.$model->surat_rasmi->baseName .'_'.date('Y_m_d_H_i_s'). '.' . $model->surat_rasmi->extension);

            $model->laporan_polis->saveAs('uploads/laporan_polis/' . $data['BlockRequestForm']['report_no'].'_'.$model->laporan_polis->baseName .'_'.date('Y_m_d_H_i_s'). '.' . $model->laporan_polis->extension);
            $caseInfo = array();
            $caseStatusSuspek = array();
            $caseInvolvedURL = array();
            $offences = array();
            
            $caseInfo['master_case_info_type_id'] = $data['BlockRequestForm']['masterCaseInfoTypeId'];
            $caseInfo['requestor_ref'] = 1;
            $caseInfo['bagipihak_dirisendiri'] = $data['BlockRequestForm']['for_self'];
            $caseInfo['no_telephone'] = $data['BlockRequestForm']['no_telephone'];
            $caseInfo['email'] = $data['BlockRequestForm']['email'];
            $caseInfo['report_no'] = $data['BlockRequestForm']['report_no'];
            $caseInfo['investigation_no'] = $data['BlockRequestForm']['investigation_no'];
            $caseInfo['case_summary'] = $data['BlockRequestForm']['case_summary'];
            $caseInfo['surat_rasmi'] = 'uploads/surat_rasmi/' .$data['BlockRequestForm']['report_no'].'_'.$model->surat_rasmi->baseName .'_'.date('Y_m_d_H_i_s'). '.' . $model->surat_rasmi->extension;
            $caseInfo['laporan_polis'] = 'uploads/laporan_polis/' .$data['BlockRequestForm']['report_no'].'_'.$model->laporan_polis->baseName .'_'.date('Y_m_d_H_i_s'). '.' . $model->laporan_polis->extension;
            if(isset($data['BlockRequestForm']['application_purpose']) && !empty($data['BlockRequestForm']['application_purpose']))
            {
            $caseInfo['master_status_purpose_of_application_id'] = implode(",",$data['BlockRequestForm']['application_purpose']);
            $caseInfo['purpose_of_application_info'] = $data['BlockRequestForm']['application_purpose_info'];
            }
            

            for($i=0;$i<=count($data['BlockRequestForm']['url'])-1;$i++)
            { 
                if(!empty($data['BlockRequestForm']['master_social_media_id'][$i]))
                {
                    $caseInvolvedURL[$i]["master_social_media_id"]  = $data['BlockRequestForm']['master_social_media_id'][$i];
                    $caseInvolvedURL[$i]["url"]  = $data['BlockRequestForm']['url'][$i];
                }
                
            }
            $offences = $data['BlockRequestForm']['offence'];

            
            //echo'<pre>';print_r($caseStatusSuspek);exit;
            //echo json_encode($caseInfo).'<br>';//exit;
            //echo json_encode($caseStatusSuspek).'<br>';
            //echo json_encode($caseInvolvedURL).'<br>';
            //echo json_encode($offences).'<br>';exit;

            $caseInfoResponse = $client->createRequest()
            ->setFormat(Client::FORMAT_URLENCODED)
            ->setMethod('POST')
            //->setUrl($this->_url_procedure.'crud-api-procedures/case_info')//local
            ->setUrl($this->_url_procedure.'case_info')
            ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass,"Accept" => "*/*"])
            ->setData(["caseInfo" => json_encode($caseInfo),"caseStatusSuspek" => json_encode($caseStatusSuspek),"caseInvolvedURL" => json_encode($caseInvolvedURL),"offences" => json_encode($offences)])
            ->send(); 
            if($caseInfoResponse->statusCode == 200 && count($caseInfoResponse->data['records']) > 0)
                { 
                    Yii::$app->session->addFlash('success','Successfully added new case infomation.');
                    return $this->redirect('../dashboard/index');
                }
                else{
                    Yii::$app->session->addFlash('failed','New case infomation not inserted successfully.');
                    return $this->redirect(Yii::$app->request->referrer);
                }
            
		}
          
        return $this->render('blockRequest',['model'=>$model,"masterStatusSuspect" => $masterStatusSuspect,"purposeOfApplication" => $purposeOfApplication,"newCase" => $newCase,"offences" => $filterOffenceResponse,"suspectOrSaksi" => $suspectOrSaksi,"masterSocialMedia" => $masterSocialMedia,"masterCaseInfoTypeId" => $masterCaseInfoTypeId]);
        
    }
    

}
