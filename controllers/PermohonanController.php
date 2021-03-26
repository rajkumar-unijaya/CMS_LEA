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
    private $_FileDownload = null;
    private $_FileTrashFolderSuratRasmi = null;
    private $_FileTrashFolderLaporanPolice = null;
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
        $this->_FileDownload = Yii::$app->params['FILE_DOWNLOAD'];
        $this->_FileTrashFolderSuratRasmi = Yii::$app->params['FILE_TRASH_SURAT_RASMI'];
        $this->_FileTrashFolderLaporanPolice = Yii::$app->params['FILE_TRASH_LAPORAN_POLIS'];
        
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
        $lastCaseInfoResponse = array();
        $lastCaseInfoNo = "";

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

            $lastCaseInfoResponse = $client->createRequest()
            ->setFormat(Client::FORMAT_URLENCODED)
            ->setMethod('POST')
            ->setUrl($this->_url_procedure.'get_case_no')
            ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass,"Accept" => "*/*"])
            ->send(); 
            
            if($lastCaseInfoResponse->statusCode == 200 && count($lastCaseInfoResponse->data['records']) > 0)
                {
                    $lastCaseInfoNo =  $lastCaseInfoResponse->data['records']['newCaseNo'];
                }
           
            $caseInfo['master_case_info_type_id'] = $data['PermohonanMNTLForm']['masterCaseInfoTypeId'];
            $caseInfo['requestor_ref'] = $session->get('userId');
            $caseInfo['case_no'] = $lastCaseInfoNo;
            $caseInfo['bagipihak_dirisendiri'] = $data['PermohonanMNTLForm']['for_self'];
            $caseInfo['no_telephone'] = $data['PermohonanMNTLForm']['no_telephone'];
            $caseInfo['email'] = $data['PermohonanMNTLForm']['email'];
            $caseInfo['report_no'] = $data['PermohonanMNTLForm']['report_no'];
            $caseInfo['case_status'] = 1;
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
        
        $client = new Client();
        $session = Yii::$app->session;
        $mediaSocialResponse = array();
        $session->get('userId');
        $responses = $client->createRequest()
            ->setFormat(Client::FORMAT_URLENCODED)
            ->setMethod('GET')
            //->setUrl($this->_url . 'case_info?filter=requestor_ref,eq,'.$session->get('userId').'&filter=case_status,in,1,2,3')
            ->setUrl($this->_url . 'case_info?filter=requestor_ref,eq,'.'1'.'&filter=case_status,in,1,2,3&join=master_status&order=id,desc')
            ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
            ->send();
        $mediaSocialResponse = $responses->data['records'];
        //return $this->render('tplist', ['responses' => $responses]);
        return $this->render('mediasosial', ['mediaSocialResponse' => $mediaSocialResponse]);
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
            if(!empty($model->surat_rasmi))
            {
            $suratRasmiFileName =  $this->_FileUploadSuratRasmi."".'_'.$model->surat_rasmi->baseName .'_'.date('YmdHis'). '.' . $model->surat_rasmi->extension;
            }
            $suratRasmiDFFileName = \Yii::getAlias('@webroot')."/". $suratRasmiFileName;
            
            $model->laporan_polis = UploadedFile::getInstance($model, 'laporan_polis'); 
            if(!empty($model->laporan_polis))
            {
            $loparaPoliceFileName =  $this->_FileUploadLaporanPolice."".'_'.$model->laporan_polis->baseName .'_'.date('YmdHis'). '.' . $model->laporan_polis->extension;
            }
            $loparaPoliceDFFileName = \Yii::getAlias('@webroot')."/". $loparaPoliceFileName;
            
            $caseInfo = array();
            $caseStatusSuspek = array();
            $caseInvolvedURL = array();
            $offences = array();
            
            $caseInfo['master_case_info_type_id'] = $data['PermohonanForm']['masterCaseInfoTypeId'];
            //$caseInfo['requestor_ref'] = $session->get('userId');
            $caseInfo['requestor_ref'] = 1;
            $caseInfo['bagipihak_dirisendiri'] = $data['PermohonanForm']['for_self'];
            $caseInfo['no_telephone'] = $data['PermohonanForm']['no_telephone'] ? $data['PermohonanForm']['no_telephone'] : 0;
            $caseInfo['email'] = $data['PermohonanForm']['email'];
            $caseInfo['report_no'] = $data['PermohonanForm']['report_no'];
            $caseInfo['investigation_no'] = $data['PermohonanForm']['investigation_no'];
            $caseInfo['case_summary'] = $data['PermohonanForm']['case_summary'];
            $caseInfo['surat_rasmi'] = $suratRasmiFileName;
            $caseInfo['laporan_polis'] = $loparaPoliceFileName;
            $caseInfo['case_status'] = 1;
            //$caseInfo['created_by'] = $session->get('userId');
            $caseInfo['created_by'] = 1;
            if(isset($data['PermohonanForm']['application_purpose']) && !empty($data['PermohonanForm']['application_purpose']))
            {
            $caseInfo['master_status_purpose_of_application_id'] = implode(",",$data['PermohonanForm']['application_purpose']);
            $caseInfo['purpose_of_application_info'] = $data['PermohonanForm']['application_purpose_info'];
            }
            

            for($i=0;$i<=count($data['PermohonanForm']['master_status_status_suspek_id'])-1;$i++)
            {
                $caseStatusSuspek[$i]['master_status_suspect_or_saksi_id']  = $data['PermohonanForm']['master_status_suspect_or_saksi_id'][$i] ? $data['PermohonanForm']['master_status_suspect_or_saksi_id'][$i]: 0;
                $caseStatusSuspek[$i]['master_status_status_suspek_id']  = $data['PermohonanForm']['master_status_status_suspek_id'][$i] ? $data['PermohonanForm']['master_status_status_suspek_id'][$i] : 0;
                $caseStatusSuspek[$i]['ic']  = $data['PermohonanForm']['ic'][$i] ? $data['PermohonanForm']['ic'][$i] : 0;
                $caseStatusSuspek[$i]['name']  = $data['PermohonanForm']['name'][$i] ? $data['PermohonanForm']['name'][$i] : "NULL";
                //$caseStatusSuspek[$i]['created_by'] = $session->get('userId');
                $caseStatusSuspek[$i]['created_by'] = 1;
                if(isset($data['PermohonanForm']['others'][$i]) && !empty($data['PermohonanForm']['others'][$i]))
                {
                    $caseStatusSuspek[$i]['others']  = $data['PermohonanForm']['others'][$i];
                }
                
            }
            for($i=0;$i<=count($data['PermohonanForm']['url'])-1;$i++)
            { 
                if(!empty($data['PermohonanForm']['master_social_media_id'][$i]))
                {
                    $caseInvolvedURL[$i]["master_social_media_id"]  = $data['PermohonanForm']['master_social_media_id'][$i] ? $data['PermohonanForm']['master_social_media_id'][$i] : 0;
                    $caseInvolvedURL[$i]["url"]  = $data['PermohonanForm']['url'][$i] ? $data['PermohonanForm']['url'][$i] : "NULL";
                    //$caseInvolvedURL[$i]['created_by'] = $session->get('userId');
                    $caseInvolvedURL[$i]['created_by'] = 1;
                }
                
            }
            $offences = $data['PermohonanForm']['offence'];

            
            //echo json_encode($caseInfo).'<br>';//exit;
           // echo json_encode($caseStatusSuspek).'<br>';
            //echo json_encode($caseInvolvedURL).'<br>';
            //echo json_encode($offences).'<br>';exit;
            
            $caseInfoResponse = $client->createRequest()
            ->setFormat(Client::FORMAT_URLENCODED)
            ->setMethod('POST')
            ->setUrl($this->_url_procedure.'case_info')
            ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass,"Accept" => "*/*"])
            ->setData(["caseInfo" => json_encode($caseInfo),"caseStatusSuspek" => json_encode($caseStatusSuspek),"caseInvolvedURL" => json_encode($caseInvolvedURL),"offences" => json_encode($offences)])
            ->send(); 
            if($caseInfoResponse->statusCode == 200 && count($caseInfoResponse->data['records']) > 0)
                { 
                    if(!empty($model->surat_rasmi))
                    { 
                    $model->surat_rasmi->saveAs($suratRasmiFileName);
                    $fileResponse = $client->createRequest()
                    ->setFormat(Client::FORMAT_URLENCODED)
                    ->setMethod('POST')
                    ->setUrl($this->_url_files."".$this->_FileUploadSuratRasmi)
                    ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
                    ->addFile('files',$suratRasmiDFFileName)
                    ->send();
                    //unlink($suratRasmiDFFileName);
                    }
                    if(!empty($model->laporan_polis))
                    {
                    $model->laporan_polis->saveAs($loparaPoliceFileName);
                    $fileResponse = $client->createRequest()
                    ->setFormat(Client::FORMAT_URLENCODED)
                    ->setMethod('POST')
                    ->setUrl($this->_url_files."".$this->_FileUploadLaporanPolice)
                    ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
                    ->addFile('files',$loparaPoliceDFFileName)
                    ->send();
                   // unlink($loparaPoliceDFFileName);
                    }
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

            $lastCaseInfoResponse = $client->createRequest()
            ->setFormat(Client::FORMAT_URLENCODED)
            ->setMethod('POST')
            ->setUrl($this->_url_procedure.'get_case_no')
            ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass,"Accept" => "*/*"])
            ->send(); 
            
            

            $this->_FileUploadSuratRasmi = Yii::$app->params['FILE_UPLOAD_SURAT_RASMI']."block-request/surat_rasmi/";
            $this->_FileUploadLaporanPolice = Yii::$app->params['FILE_UPLOAD_LAPORAN_POLIS']."block-request/laporan_polis/";

            
            $model->surat_rasmi = UploadedFile::getInstance($model, 'surat_rasmi'); 
            if(!empty($model->surat_rasmi))
            {
            $suratRasmiFileName =  $this->_FileUploadSuratRasmi."".'_'.$model->surat_rasmi->baseName .'_'.date('YmdHis'). '.' . $model->surat_rasmi->extension;
            }
            $suratRasmiDFFileName = \Yii::getAlias('@webroot')."/". $suratRasmiFileName;

            
            
            $model->laporan_polis = UploadedFile::getInstance($model, 'laporan_polis'); 
            if(!empty($model->laporan_polis))
            {
            $loparaPoliceFileName =  $this->_FileUploadLaporanPolice."".'_'.$model->laporan_polis->baseName .'_'.date('YmdHis'). '.' . $model->laporan_polis->extension;
            }
            $loparaPoliceDFFileName = \Yii::getAlias('@webroot')."/". $loparaPoliceFileName;

            $caseInfo = array();
            $caseStatusSuspek = array();
            $caseInvolvedURL = array();
            $offences = array();
            
            $caseInfo['master_case_info_type_id'] = $data['BlockRequestForm']['masterCaseInfoTypeId'];
            //$caseInfo['requestor_ref'] = $session->get('userId');
            $caseInfo['requestor_ref'] = 1;
            $caseInfo['bagipihak_dirisendiri'] = $data['BlockRequestForm']['for_self'];
            $caseInfo['no_telephone'] = $data['BlockRequestForm']['no_telephone'] ? $data['BlockRequestForm']['no_telephone'] : 0;
            $caseInfo['email'] = $data['BlockRequestForm']['email'] ? $data['BlockRequestForm']['email'] : "NULL";
            $caseInfo['report_no'] = $data['BlockRequestForm']['report_no'];
            $caseInfo['investigation_no'] = $data['BlockRequestForm']['investigation_no'];
            $caseInfo['case_summary'] = $data['BlockRequestForm']['case_summary'];
            $caseInfo['surat_rasmi'] = $suratRasmiFileName;
            $caseInfo['laporan_polis'] = $loparaPoliceFileName;
            $caseInfo['case_status'] = 1;
            //$caseInfo['created_by'] = $session->get('userId');
            $caseInfo['created_by'] = 1;
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
                    //$caseInvolvedURL[$i]["created_by"]  = $session->get('userId');
                    $caseInvolvedURL[$i]["created_by"]  = 1;
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
                    if(!empty($model->surat_rasmi))
                    {  
                    $model->surat_rasmi->saveAs($suratRasmiFileName);
                    $fileResponse = $client->createRequest()
                    ->setFormat(Client::FORMAT_URLENCODED)
                    ->setMethod('POST')
                    ->setUrl($this->_url_files."".$this->_FileUploadSuratRasmi)
                    ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
                    ->addFile('files',$suratRasmiDFFileName)
                    ->send();
                    //unlink($suratRasmiDFFileName);
                    }
                    if(!empty($model->laporan_polis))
                    {
                    $model->laporan_polis->saveAs($loparaPoliceFileName);
                    $fileResponse = $client->createRequest()
                    ->setFormat(Client::FORMAT_URLENCODED)
                    ->setMethod('POST')
                    ->setUrl($this->_url_files."".$this->_FileUploadLaporanPolice)
                    ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
                    ->addFile('files',$loparaPoliceDFFileName)
                    ->send();
                    //unlink($loparaPoliceDFFileName);
                    }
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


    /**
     * Edit social media page
     *
     * @return string
     */
    public function actionEditSocialMedia($id)
    { 
        $this->layout =  'main';
        $model = new PermohonanForm();
        $session = Yii::$app->session;
        /******
         * load masterdata from the master component and pass these data into view page
         */
		$masterStatusSuspect = Yii::$app->mycomponent->statusSuspect();
		$purposeOfApplication = Yii::$app->mycomponent->purposeOfApplication();
		$newCase = Yii::$app->mycomponent->newCase();
        $suspectOrSaksi = Yii::$app->mycomponent->suspectOrSaksi();
        $masterSocialMedia = Yii::$app->mycomponent->masterSocialMedia();
        $mediaSocialResponse = array();
        $client = new Client();
        $offenceResponse = array();
        $filterOffenceResponse = array();
        $suratRasmiFileName = "";
        $suratRasmiDFFileName = "";
        $loparaPoliceFileName = "";
        $loparaPoliceDFFileName = "";
        $prevOffences = array();
        $newOffences = array();
        $newSelectedOffences = array();
        $prevDeletedOffences = array();

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
        $client = new Client();
        $session = Yii::$app->session;
        $mediaSocialResponse = array();
        $session->get('userId');
        $responses = $client->createRequest()
            ->setFormat(Client::FORMAT_URLENCODED)
            ->setMethod('GET')
            //->setUrl($this->_url . 'case_info?filter=requestor_ref,eq,'.$session->get('userId').'&filter=case_status,in,1,2,3&join=master_status&order=id,desc')
            ->setUrl($this->_url . 'case_info?filter=id,eq,'.$id.'&join=case_offence,offence&join=case_info_status_suspek&join=case_info_url_involved&order=id,desc')
            ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
            ->send();
            //echo count($responses->data['records']);exit;
            //echo"<pre>";print_r($responses->data['records']);exit;

        /*********
           * once validation is success then set the data as an array and convert these data into json object and then pass it to stored procedure as a arguments
           * 
           *  */     
          if ($model->load(Yii::$app->request->post()) && $model->validate()) {  
            $data = Yii::$app->request->post();
            //echo"<pre>";print_r($data);exit;
            if(count($responses->data['records']) > 0)
            {
               foreach($responses->data['records'][0]['case_offence'] as $offenceVal):
                $prevOffences[] = $offenceVal['offence_id'];
               endforeach; 
            }
            $newOffences = $data['PermohonanForm']['offence'];
            $newSelectedOffences = array_values(array_diff($newOffences,$prevOffences));
            $prevDeletedOffences = array_values(array_diff($prevOffences,$newOffences));
            //echo"Previous <pre>";print_r($prevOffences);
            //echo"New <pre>";print_r($newOffences);
            //echo"new selected <pre>";print_r($newSelectedOffences);
            //echo"prev deleted <pre>";print_r($prevDeletedOffences);exit;
            
            $this->_FileUploadSuratRasmi = Yii::$app->params['FILE_UPLOAD_SURAT_RASMI']."permohonan/surat_rasmi/";
            $this->_FileUploadLaporanPolice = Yii::$app->params['FILE_UPLOAD_LAPORAN_POLIS']."permohonan/laporan_polis/";
            
            $model->surat_rasmi = UploadedFile::getInstance($model, 'surat_rasmi');//echo $data['PermohonanForm']['surat_rasmi_last_attachment'];exit; echo "<pre>";print_r($model->surat_rasmi);exit;
            if(isset($model->surat_rasmi) && !empty($model->surat_rasmi) )
            {  
            $suratRasmiFileName =  $this->_FileUploadSuratRasmi."".'_'.$model->surat_rasmi->baseName .'_'.date('YmdHis'). '.' . $model->surat_rasmi->extension;
            }
            else if(!isset($model->surat_rasmi) && !empty($data['PermohonanForm']['surat_rasmi_last_attachment'])){ 
                $suratRasmiFileName =  $data['PermohonanForm']['surat_rasmi_last_attachment'];
            }
           
            $suratRasmiDFFileName = \Yii::getAlias('@webroot')."/". $suratRasmiFileName;
            
            $model->laporan_polis = UploadedFile::getInstance($model, 'laporan_polis'); 
            if(isset($model->laporan_polis) && !empty($model->laporan_polis))
            {
            $loparaPoliceFileName =  $this->_FileUploadLaporanPolice."".'_'.$model->laporan_polis->baseName .'_'.date('YmdHis'). '.' . $model->laporan_polis->extension;
            }
            else if(!isset($model->laporan_polis) && !empty($data['PermohonanForm']['laporan_polis_last_attachment'])){
                $loparaPoliceFileName =  $data['PermohonanForm']['laporan_polis_last_attachment'];
            }
            $loparaPoliceDFFileName = \Yii::getAlias('@webroot')."/". $loparaPoliceFileName;
            
            $caseInfo = array();
            $caseStatusSuspek = array();
            $caseInvolvedURL = array();
            $offences = array();
            
            $caseInfo['master_case_info_type_id'] = $data['PermohonanForm']['master_case_info_type_id'];
            //$caseInfo['requestor_ref'] = $session->get('userId');
            $caseInfo['id'] = $data['PermohonanForm']['id'];
            $caseInfo['requestor_ref'] = 1;
            $caseInfo['bagipihak_dirisendiri'] = $data['PermohonanForm']['for_self'];
            $caseInfo['no_telephone'] = $data['PermohonanForm']['no_telephone'] ? $data['PermohonanForm']['no_telephone'] : 0;
            $caseInfo['email'] = $data['PermohonanForm']['email'];
            $caseInfo['report_no'] = $data['PermohonanForm']['report_no'];
            $caseInfo['investigation_no'] = $data['PermohonanForm']['investigation_no'];
            $caseInfo['case_summary'] = $data['PermohonanForm']['case_summary'];
            $caseInfo['surat_rasmi'] = $suratRasmiFileName;
            $caseInfo['laporan_polis'] = $loparaPoliceFileName;
            $caseInfo['case_status'] = 1;
            
            //$caseInfo['created_by'] = $session->get('userId');
            $caseInfo['updated_by'] = 1;
            if(isset($data['PermohonanForm']['application_purpose']) && !empty($data['PermohonanForm']['application_purpose']))
            { 
            $caseInfo['master_status_purpose_of_application_id'] = implode(",",$data['PermohonanForm']['application_purpose']);
            $caseInfo['purpose_of_application_info'] = $data['PermohonanForm']['application_purpose_info'];
            }
            
            for($i=0;$i<=count($data['PermohonanForm']['master_status_status_suspek_id'])-1;$i++)
            {
                $caseStatusSuspek[$i]['case_info_status_suspek_id']  = $data['PermohonanForm']['caseInfoStatusSuspekID'][$i] ? $data['PermohonanForm']['caseInfoStatusSuspekID'][$i]: 0;
                $caseStatusSuspek[$i]['master_status_suspect_or_saksi_id']  = $data['PermohonanForm']['master_status_suspect_or_saksi_id'][$i] ? $data['PermohonanForm']['master_status_suspect_or_saksi_id'][$i]: 0;
                $caseStatusSuspek[$i]['master_status_status_suspek_id']  = $data['PermohonanForm']['master_status_status_suspek_id'][$i] ? $data['PermohonanForm']['master_status_status_suspek_id'][$i] : 0;
                $caseStatusSuspek[$i]['ic']  = $data['PermohonanForm']['ic'][$i] ? $data['PermohonanForm']['ic'][$i] : 0;
                $caseStatusSuspek[$i]['name']  = $data['PermohonanForm']['name'][$i] ? $data['PermohonanForm']['name'][$i] : "NULL";
                //$caseStatusSuspek[$i]['created_by'] = $session->get('userId');
                $caseStatusSuspek[$i]['updated_by'] = 1;
                if(isset($data['PermohonanForm']['others'][$i]) && !empty($data['PermohonanForm']['others'][$i]))
                {
                    $caseStatusSuspek[$i]['others']  = $data['PermohonanForm']['others'][$i];
                }
                
            }
            for($i=0;$i<=count($data['PermohonanForm']['url'])-1;$i++)
            { 
                if(!empty($data['PermohonanForm']['master_social_media_id'][$i]))
                {
                    $caseInvolvedURL[$i]["case_info_url_involved_id"]  = $data['PermohonanForm']['caseInfoURLInvolvedId'][$i] ? $data['PermohonanForm']['caseInfoURLInvolvedId'][$i] : 0;
                    $caseInvolvedURL[$i]["master_social_media_id"]  = $data['PermohonanForm']['master_social_media_id'][$i] ? $data['PermohonanForm']['master_social_media_id'][$i] : 0;
                    $caseInvolvedURL[$i]["url"]  = $data['PermohonanForm']['url'][$i] ? $data['PermohonanForm']['url'][$i] : "NULL";
                    //$caseInvolvedURL[$i]['created_by'] = $session->get('userId');
                    $caseInvolvedURL[$i]['updated_by'] = 1;
                }
                
            }
            //$offences = $data['PermohonanForm']['offence'];

            
            //echo json_encode($caseInfo).'<br>';
            //echo json_encode($caseStatusSuspek).'<br>';
            //echo json_encode($caseInvolvedURL).'<br>';
            //echo json_encode($newSelectedOffences).'<br>';
            //echo json_encode($prevDeletedOffences).'<br>';exit;
            
            $caseInfoResponse = $client->createRequest()
            ->setFormat(Client::FORMAT_URLENCODED)
            ->setMethod('POST')
            ->setUrl($this->_url_procedure.'case_info_edit')
            ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass,"Accept" => "*/*"])
            ->setData(["caseInfo" => json_encode($caseInfo),"caseStatusSuspek" => json_encode($caseStatusSuspek),"caseInvolvedURL" => json_encode($caseInvolvedURL),"newOffences" => json_encode($newSelectedOffences),"deleteOffences" => json_encode($prevDeletedOffences)])
            ->send(); 
            if($caseInfoResponse->statusCode == 200 && count($caseInfoResponse->data['records']) > 0)
                { 
                    if(!empty($model->surat_rasmi))
                    { 
                    $model->surat_rasmi->saveAs($suratRasmiFileName);
                    $fileResponse = $client->createRequest()
                    ->setFormat(Client::FORMAT_URLENCODED)
                    ->setMethod('POST')
                    ->setUrl($this->_url_files."".$this->_FileUploadSuratRasmi)
                    ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
                    ->addFile('files',$suratRasmiDFFileName)
                    ->send();
                    //unlink($suratRasmiDFFileName);
                    }
                    if(!empty($model->laporan_polis))
                    {
                    $model->laporan_polis->saveAs($loparaPoliceFileName);
                    $fileResponse = $client->createRequest()
                    ->setFormat(Client::FORMAT_URLENCODED)
                    ->setMethod('POST')
                    ->setUrl($this->_url_files."".$this->_FileUploadLaporanPolice)
                    ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
                    ->addFile('files',$loparaPoliceDFFileName)
                    ->send();
                   // unlink($loparaPoliceDFFileName);
                    }
                    Yii::$app->session->addFlash('success','Successfully updated existing case infomation.');
                    return $this->redirect('../dashboard/index');
                }
                else{
                    Yii::$app->session->addFlash('failed','New case infomation not inserted successfully.');
                    return $this->redirect(Yii::$app->request->referrer);
                }
            
		}    
        if(count($responses->data['records']) > 0)
        {
            $mediaSocialResponse = $responses->data['records'][0];
        }
        
       // echo "<pre>";print_r($responses->data['records']);exit;
        return $this->render('editsocialmedia', ['model'=>$model,"mediaSocialResponse" => $mediaSocialResponse,"masterStatusSuspect" => $masterStatusSuspect,"purposeOfApplication" => $purposeOfApplication,"newCase" => $newCase,"offences" => $filterOffenceResponse,"suspectOrSaksi" => $suspectOrSaksi,"masterSocialMedia" => $masterSocialMedia]);
       
        
    }

    /****
     * 
     * Download surat rasmi document
     */
    public function actionSuratDownload($name)
    { 
        header("Content-Type: image/png");
        header("Content-Description: File Transfer");
        header("Content-disposition: attachment; filename='".$this->_FileDownload."".$name); 

        return readfile($this->_FileDownload."".$name);
    }

    /****
     * 
     * Download loparan police document
     */
    public function actionLaporanDownload($name)
    { 
        header("Content-Type: image/png");
        header("Content-Description: File Transfer");
        header("Content-disposition: attachment; filename='".$this->_FileDownload."".$name); 

        return readfile($this->_FileDownload."".$name);
    }

    /*****
     * 
     * delete surath rasmi attachement fucntion
     * request value : id,path
     * @return json response either successfully deltion of failed.
     */
    public function actionDeleteSuratRasmi()
    {
        $deleteResponse = array();
        if (Yii::$app->request->get('id') && Yii::$app->request->get('path')) {
            $trashPath = "";

             $imageName = explode("/",Yii::$app->request->get('path'));
             if(!empty(Yii::$app->request->get('path')) && Yii::$app->request->get('path') != "NULL")
             {
                $trashPath = \Yii::getAlias('@webroot').$this->_FileTrashFolderSuratRasmi.$imageName[3];
             }
             
            if(file_exists(\Yii::getAlias('@webroot')."/".Yii::$app->request->get('path')))
            {  
                $client = new Client();
                $fileResponse = $client->createRequest()
                ->setFormat(Client::FORMAT_URLENCODED)
                ->setMethod('POST')
                ->setUrl($this->_url_files."".ltrim($this->_FileTrashFolderSuratRasmi, $this->_FileTrashFolderSuratRasmi[0]))
                ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
                ->addFile('files',\Yii::getAlias('@webroot')."/".Yii::$app->request->get('path'))
                ->send();
                if(count($fileResponse->data) > 0)
                { 
                    $client = new Client();
                    $deleteResponse = $client->createRequest()
                      ->setFormat(Client::FORMAT_URLENCODED)
                      ->setMethod('PUT')
                      ->setUrl($this->_url.'case_info/'.Yii::$app->request->get('id'))
                      ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
                      ->setData(["surat_rasmi" => ""])
                      ->send();
                      if($deleteResponse->statusCode == 200 && $deleteResponse->data > 0)
                      { 
                          if(file_exists(\Yii::getAlias('@webroot')."/".Yii::$app->request->get('path')) && rename(\Yii::getAlias('@webroot')."/".Yii::$app->request->get('path'), $trashPath))
                          {
                          $responseInfo['status'] = 200;
                           $responseInfo['success'] = 'success';
                           $responseInfo['info'] = 'Attachment deleted successfully';
                           return $this->asJson($responseInfo);
                          }
                          else
                          { 
                                  $responseInfo['status'] = 422;
                                  $responseInfo['message'] = 'failed';
                                  $responseInfo['info'] = 'Attachment deleted failed';
                                  return $this->asJson($responseInfo);
                          }
                      }
                      else
                      { 
                              $responseInfo['status'] = 422;
                              $responseInfo['message'] = 'failed';
                              $responseInfo['info'] = 'Attachment deleted failed';
                              return $this->asJson($responseInfo);
                      }

                }
                else
                {
                $responseInfo['status'] = 422;
                $responseInfo['message'] = 'failed';
                $responseInfo['info'] = 'File move to trash failed';
                return $this->asJson($responseInfo);

                }
              
            }
            else{
                        $responseInfo['status'] = 422;
                        $responseInfo['message'] = 'failed';
                        $responseInfo['info'] = 'File not found';
                        return $this->asJson($responseInfo);

            }
               
        }
    }




    /*****
     * 
     * delete laporan polis attachement fucntion
     * request value : id,path
     * @return json response either successfully deltion of failed.
     */
    public function actionDeleteLaporanPolis()
    {
        $deleteResponse = array();
        if (Yii::$app->request->get('id') && Yii::$app->request->get('path')) {
            $trashPath = "";
             $imageName = explode("/",Yii::$app->request->get('path'));
             if(!empty(Yii::$app->request->get('path')) && Yii::$app->request->get('path') != "")
             {
                $trashPath = \Yii::getAlias('@webroot').$this->_FileTrashFolderLaporanPolice.$imageName[3];
             }
             //echo $trashPath;exit;
             //echo \Yii::getAlias('@webroot')."/".Yii::$app->request->get('path');exit;
            if(file_exists(\Yii::getAlias('@webroot')."/".Yii::$app->request->get('path')))
            {  
                $client = new Client();
                $fileResponse = $client->createRequest()
                ->setFormat(Client::FORMAT_URLENCODED)
                ->setMethod('POST')
                ->setUrl($this->_url_files."".ltrim($this->_FileTrashFolderLaporanPolice, $this->_FileTrashFolderLaporanPolice[0]))
                ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
                ->addFile('files',\Yii::getAlias('@webroot')."/".Yii::$app->request->get('path'))
                ->send();
                if(count($fileResponse->data) > 0)
                { 
                    $client = new Client();
                    $deleteResponse = $client->createRequest()
                      ->setFormat(Client::FORMAT_URLENCODED)
                      ->setMethod('PUT')
                      ->setUrl($this->_url.'case_info/'.Yii::$app->request->get('id'))
                      ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
                      ->setData(["laporan_polis" => ""])
                      ->send();
                      if($deleteResponse->statusCode == 200 && $deleteResponse->data > 0)
                      { 
                          if(file_exists(\Yii::getAlias('@webroot')."/".Yii::$app->request->get('path')) && rename(\Yii::getAlias('@webroot')."/".Yii::$app->request->get('path'), $trashPath))
                          {
                          $responseInfo['status'] = 200;
                           $responseInfo['success'] = 'success';
                           $responseInfo['info'] = 'Attachment deleted successfully';
                           return $this->asJson($responseInfo);
                          }
                          else
                          { 
                                  $responseInfo['status'] = 422;
                                  $responseInfo['message'] = 'failed';
                                  $responseInfo['info'] = 'Attachment deleted failed';
                                  return $this->asJson($responseInfo);
                          }
                      }
                      else
                      { 
                              $responseInfo['status'] = 422;
                              $responseInfo['message'] = 'failed';
                              $responseInfo['info'] = 'Attachment deleted failed';
                              return $this->asJson($responseInfo);
                      }

                }
                else
                {
                $responseInfo['status'] = 422;
                $responseInfo['message'] = 'failed';
                $responseInfo['info'] = 'File move to trash failed';
                return $this->asJson($responseInfo);

                }
              
            }
            else{
                        $responseInfo['status'] = 422;
                        $responseInfo['message'] = 'failed';
                        $responseInfo['info'] = 'File not found';
                        return $this->asJson($responseInfo);

            }
               
        }
    }
    
    
    

}
