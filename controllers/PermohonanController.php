<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\PermohonanForm;
use app\models\BlockRequestForm;
use app\models\PermohonanMNTLForm;
use yii\httpclient\Client;
use yii\web\UploadedFile;

class PermohonanController extends Controller
{
    private $_url = null;
    private $_url_procedure = null;
    private $_url_crawler = null;
    private $_url_files = null;
    private $_DFHeaderKey = null;
    private $_DFHeaderPass = null;
    private $_FileUploadSuratRasmi = null;
    private $_FileUploadLaporanPolice = null;
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $this->_url = Yii::$app->params['DreamFactoryContextURL'];
        $this->_url_procedure = Yii::$app->params['DreamFactoryContextURLProcedures'];
        $this->_url_crawler = Yii::$app->params['DreamFactoryContextURLCrawler'];
        $this->_url_files = Yii::$app->params['DreamFactoryContextURLFiles'];
        $this->_DFHeaderKey = Yii::$app->params['DreamFactoryHeaderKey'];
        $this->_DFHeaderPass = Yii::$app->params['DreamFactoryHeaderPass'];
        $this->_FileUploadSuratRasmi = Yii::$app->params['FILE_UPLOAD_SURAT_RASMI'];
        $this->_FileUploadLaporanPolice = Yii::$app->params['FILE_UPLOAD_LAPORAN_POLIS'];
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
     * Displays Permohonan using MNTL page.
     *
     * @return string
     */
    public function actionMntl()
    {
        $this->layout =  'main';
        $model = new PermohonanMNTLForm();
        $session = Yii::$app->session;
        $masterCaseInfoTypeId = 3;

        /******
         * load masterdata from the master component and pass these data into view page
         */
		$masterStatusSuspect = Yii::$app->mycomponent->statusSuspect();
		$newCase = Yii::$app->mycomponent->newCase();
        $client = new Client();
        $tipOffNoResponse = array();
        $filterTipOffNoResponse = array();

        /******
         * Get offence master data from the offence table using api service.
         */
        $tipOffNoResponse = $client->createRequest()
                ->setFormat(Client::FORMAT_URLENCODED)
                ->setMethod('GET')
                ->setUrl($this->_url.'tipoff?include=id,tipoff_no')
                ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
                ->send();
               
                if(isset($tipOffNoResponse->data['records']) && count($tipOffNoResponse->data['records']) > 0)
                {
                    foreach($tipOffNoResponse->data['records'] as $key => $value)
                {
                    $filterTipOffNoResponse[$value['id']] = $value['tipoff_no'];
                }
                }
                //echo'<pre>';print_r($filterTipOffNoResponse);exit;
        /*********
           * once validation is success then set the data as an array and convert these data into json object and then pass it to stored procedure as a arguments
           * 
           *  */     
          if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $data = Yii::$app->request->post();
            $caseInfo = array();
            $caseInfoMNTL = array();
            
            $caseInfo['master_case_info_type_id'] = $data['PermohonanMNTLForm']['masterCaseInfoTypeId'];
            $caseInfo['requestor_ref'] = $session->get('userId');
            $caseInfo['bagipihak_dirisendiri'] = $data['PermohonanMNTLForm']['for_self'];
            $caseInfo['no_telephone'] = $data['PermohonanMNTLForm']['no_telephone'];
            $caseInfo['email'] = $data['PermohonanMNTLForm']['email'];
            $caseInfo['report_no'] = $data['PermohonanMNTLForm']['report_no'];
            $caseInfo['investigation_no'] = $data['PermohonanMNTLForm']['investigation_no'];
            $caseInfo['created_by'] = 1;
            
            $caseInfoMNTL['tippoff_id'] = $data['PermohonanMNTLForm']['tippoff_id'];
            $caseInfoMNTL['phone_number'] = $data['PermohonanMNTLForm']['phone_number'];
            $caseInfoMNTL['telco_name'] = $data['PermohonanMNTLForm']['telco_name'];
            $caseInfoMNTL['date1'] = date("Y-m-d",strtotime($data['PermohonanMNTLForm']['date1']));
            $caseInfoMNTL['date2'] = date("Y-m-d",strtotime($data['PermohonanMNTLForm']['date2']));
            
            $caseInfoResponse = $client->createRequest()
            ->setFormat(Client::FORMAT_URLENCODED)
            ->setMethod('POST')
            //->setUrl($this->_url_procedure.'crud-api-procedures/case_info_mntl')//local
            ->setUrl($this->_url_procedure.'case_info_mntl')
            ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass,"Accept" => "*/*"])
            ->setData(["caseInfo" => json_encode($caseInfo),"mntl" => json_encode($caseInfoMNTL)])
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
          
        return $this->render('mntl',['model' => $model,"newCase" => $newCase,"masterCaseInfoTypeId" => $masterCaseInfoTypeId,"tipOff" => $filterTipOffNoResponse]);
       
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
        $session = Yii::$app->session;
        $masterCaseInfoTypeId = 1;
        /******
         * load masterdata from the master component and pass these data into view page
         */
		$masterStatusSuspect = Yii::$app->mycomponent->statusSuspect();
		$purposeOfApplication = Yii::$app->mycomponent->purposeOfApplication();
		$newCase = Yii::$app->mycomponent->newCase();
        $suspectOrSaksi = Yii::$app->mycomponent->suspectOrSaksi();
        $masterSocialMedia = Yii::$app->mycomponent->masterSocialMedia();
        $suratRasmiFileName = "";
        $suratRasmiDFFileName = "";
        $loparaPoliceFileName = "";
        $loparaPoliceDFFileName = "";



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

            $this->_FileUploadSuratRasmi = Yii::$app->params['FILE_UPLOAD_SURAT_RASMI']."permohonan/surat_rasmi/";
            $this->_FileUploadLaporanPolice = Yii::$app->params['FILE_UPLOAD_LAPORAN_POLIS']."permohonan/laporan_polis/";

            
            $model->surat_rasmi = UploadedFile::getInstance($model, 'surat_rasmi'); 
            $suratRasmiFileName =  $this->_FileUploadSuratRasmi."".$data['PermohonanForm']['report_no'].'_'.$model->surat_rasmi->baseName .'_'.date('YmdHis'). '.' . $model->surat_rasmi->extension;
            $suratRasmiDFFileName = \Yii::getAlias('@webroot')."/". $suratRasmiFileName;

            
            
            $model->laporan_polis = UploadedFile::getInstance($model, 'laporan_polis'); 
            $loparaPoliceFileName =  $this->_FileUploadLaporanPolice."".$data['PermohonanForm']['report_no'].'_'.$model->laporan_polis->baseName .'_'.date('YmdHis'). '.' . $model->laporan_polis->extension;
            $loparaPoliceDFFileName = \Yii::getAlias('@webroot')."/". $loparaPoliceFileName;
            
            $caseInfo = array();
            $caseStatusSuspek = array();
            $caseInvolvedURL = array();
            $offences = array();
            
            $caseInfo['master_case_info_type_id'] = $data['PermohonanForm']['masterCaseInfoTypeId'];
            $caseInfo['requestor_ref'] = $session->get('userId');
            //$caseInfo['requestor_ref'] = 1;
            $caseInfo['bagipihak_dirisendiri'] = $data['PermohonanForm']['for_self'];
            $caseInfo['no_telephone'] = $data['PermohonanForm']['no_telephone'];
            $caseInfo['email'] = $data['PermohonanForm']['email'];
            $caseInfo['report_no'] = $data['PermohonanForm']['report_no'];
            $caseInfo['investigation_no'] = $data['PermohonanForm']['investigation_no'];
            $caseInfo['case_summary'] = $data['PermohonanForm']['case_summary'];
            $caseInfo['surat_rasmi'] = $suratRasmiFileName;
            $caseInfo['laporan_polis'] = $loparaPoliceDFFileName;
            $caseInfo['created_by'] = $session->get('userId');
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
                $caseStatusSuspek[$i]['created_by'] = $session->get('userId');
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
                    $caseInvolvedURL[$i]['created_by'] = $session->get('userId');
                }
                
            }
            $offences = $data['PermohonanForm']['offence'];

            
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
                    $model->surat_rasmi->saveAs($suratRasmiFileName);
                    $fileResponse = $client->createRequest()
                    ->setFormat(Client::FORMAT_URLENCODED)
                    ->setMethod('POST')
                    ->setUrl($this->_url_files."".$this->_FileUploadSuratRasmi)
                    ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
                    ->addFile('files',$suratRasmiDFFileName)
                    ->send();
                    unlink($suratRasmiDFFileName);

                    $model->laporan_polis->saveAs($loparaPoliceFileName);
                    $fileResponse = $client->createRequest()
                    ->setFormat(Client::FORMAT_URLENCODED)
                    ->setMethod('POST')
                    ->setUrl($this->_url_files."".$this->_FileUploadLaporanPolice)
                    ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
                    ->addFile('files',$loparaPoliceDFFileName)
                    ->send();
                    unlink($loparaPoliceDFFileName);
                    
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
        $session = Yii::$app->session;
        $masterCaseInfoTypeId = 2;
        $suratRasmiFileName = "";
        $suratRasmiDFFileName = "";
        $loparaPoliceFileName = "";
        $loparaPoliceDFFileName = "";

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

            $this->_FileUploadSuratRasmi = Yii::$app->params['FILE_UPLOAD_SURAT_RASMI']."block-request/surat_rasmi/";
            $this->_FileUploadLaporanPolice = Yii::$app->params['FILE_UPLOAD_LAPORAN_POLIS']."block-request/laporan_polis/";

            
            $model->surat_rasmi = UploadedFile::getInstance($model, 'surat_rasmi'); 
            $suratRasmiFileName =  $this->_FileUploadSuratRasmi."".$data['BlockRequestForm']['report_no'].'_'.$model->surat_rasmi->baseName .'_'.date('YmdHis'). '.' . $model->surat_rasmi->extension;
            $suratRasmiDFFileName = \Yii::getAlias('@webroot')."/". $suratRasmiFileName;

            
            
            $model->laporan_polis = UploadedFile::getInstance($model, 'laporan_polis'); 
            $loparaPoliceFileName =  $this->_FileUploadLaporanPolice."".$data['BlockRequestForm']['report_no'].'_'.$model->laporan_polis->baseName .'_'.date('YmdHis'). '.' . $model->laporan_polis->extension;
            $loparaPoliceDFFileName = \Yii::getAlias('@webroot')."/". $loparaPoliceFileName;

            $caseInfo = array();
            $caseStatusSuspek = array();
            $caseInvolvedURL = array();
            $offences = array();
            
            $caseInfo['master_case_info_type_id'] = $data['BlockRequestForm']['masterCaseInfoTypeId'];
            $caseInfo['requestor_ref'] = $session->get('userId');
            $caseInfo['bagipihak_dirisendiri'] = $data['BlockRequestForm']['for_self'];
            $caseInfo['no_telephone'] = $data['BlockRequestForm']['no_telephone'];
            $caseInfo['email'] = $data['BlockRequestForm']['email'];
            $caseInfo['report_no'] = $data['BlockRequestForm']['report_no'];
            $caseInfo['investigation_no'] = $data['BlockRequestForm']['investigation_no'];
            $caseInfo['case_summary'] = $data['BlockRequestForm']['case_summary'];
            $caseInfo['surat_rasmi'] = 'uploads/surat_rasmi/' .$data['BlockRequestForm']['report_no'].'_'.$model->surat_rasmi->baseName .'_'.date('Y_m_d_H_i_s'). '.' . $model->surat_rasmi->extension;
            $caseInfo['laporan_polis'] = 'uploads/laporan_polis/' .$data['BlockRequestForm']['report_no'].'_'.$model->laporan_polis->baseName .'_'.date('Y_m_d_H_i_s'). '.' . $model->laporan_polis->extension;
            $caseInfo['created_by'] = $session->get('userId');
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
                    $caseInvolvedURL[$i]["created_by"]  = $session->get('userId');
                }
                
            }
            $offences = $data['BlockRequestForm']['offence'];


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
                    $model->surat_rasmi->saveAs($suratRasmiFileName);
                    $fileResponse = $client->createRequest()
                    ->setFormat(Client::FORMAT_URLENCODED)
                    ->setMethod('POST')
                    ->setUrl($this->_url_files."".$this->_FileUploadSuratRasmi)
                    ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
                    ->addFile('files',$suratRasmiDFFileName)
                    ->send();
                    unlink($suratRasmiDFFileName);

                    $model->laporan_polis->saveAs($loparaPoliceFileName);
                    $fileResponse = $client->createRequest()
                    ->setFormat(Client::FORMAT_URLENCODED)
                    ->setMethod('POST')
                    ->setUrl($this->_url_files."".$this->_FileUploadLaporanPolice)
                    ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
                    ->addFile('files',$loparaPoliceDFFileName)
                    ->send();
                    unlink($loparaPoliceDFFileName);

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
