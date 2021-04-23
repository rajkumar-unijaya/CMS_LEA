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
use app\models\SearchForm;
use app\models\LeaForm;


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
    private $_FileTrashFolderBlockRequestSuratRasmi = null;
    private $_FileTrashFolderBlockRequestLaporanPolice = null;
    private $_urlCrawler = null;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $this->_url = Yii::$app->params['DreamFactoryContextURL'];
        $this->_urlCrawler = Yii::$app->params['DreamFactoryContextURLCrawler'];
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
        $this->_FileTrashFolderBlockRequestSuratRasmi = Yii::$app->params['FILE_TRASH_BLOCK_REQUEST_SURAT_RASMI'];;
        $this->_FileTrashFolderBlockRequestLaporanPolice = Yii::$app->params['FILE_TRASH_BLOCK_REQUEST_LAPORAN_POLIS'];;
        
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
        $masterCaseInfoTypeId = array_search("MNTL",Yii::$app->mycomponent->getMasterData('master_case_info_type'));
        

        /******
         * load masterdata from the master component and pass these data into view page
         */
		$masterStatusSuspect = Yii::$app->mycomponent->getMasterData('master_suspect');
        $newCase = Yii::$app->mycomponent->getMasterData('master_status_new_case');
        $client = new Client();
        $tipOffNoResponse = array();
        $filterTipOffNoResponse = array();
        $lastCaseInfoResponse = array();
        $lastCaseInfoNo = "";
        $returnResponse['success'] = "failed";
        

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

                if (Yii::$app->request->isAjax)
                { 
                    $returnResponse = array();
                    $telcoResponse = array();
                    $client = new Client();
                    $data = Yii::$app->request->post();
                    $telcoResponse = $client->createRequest()
                    ->setFormat(Client::FORMAT_URLENCODED)
                    ->setMethod('GET')
                    ->setUrl($this->_urlCrawler . 'func.telco.php?search=' .  $data['phone_number'] . '&mnp=nomnp')
                    ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
                    ->send();
                    if(isset($telcoResponse->data) && count($telcoResponse->data) > 0)
                    { 
                        $returnResponse['success'] = "success";
                        $returnResponse['phone_no'] = $data['phone_number'];
                        $returnResponse['telco'] = $telcoResponse->data[0]['ported-to'];
                        return $this->asJson($returnResponse);
                    }
                    return $this->asJson($returnResponse);
                }

                if(Yii::$app->request->get())
                { 
                     $phoneNo = Yii::$app->request->get()['no'];
                     $client = new Client();
                     $data = Yii::$app->request->post();
                     $telcoResponse = $client->createRequest()
                     ->setFormat(Client::FORMAT_URLENCODED)
                     ->setMethod('GET')
                     ->setUrl($this->_urlCrawler . 'func.telco.php?search=' .  $phoneNo . '&mnp=nomnp')
                     ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
                     ->send();
                     if(isset($telcoResponse->data) && count($telcoResponse->data) > 0)
                     { 
                         $returnResponse['success'] = "success";
                         $returnResponse['phone_no'] = $phoneNo;
                         $returnResponse['telco'] = $telcoResponse->data[0]['ported-to'];
                         
                     }
                     

                }
                
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
            $caseInfo['case_status'] = 71;
            $caseInfo['investigation_no'] = $data['PermohonanMNTLForm']['investigation_no'];
            $caseInfo['created_by'] = $session->get('userId');
            
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
                    return $this->redirect('../permohonan/mntl-list');
                }
                else{
                    Yii::$app->session->addFlash('failed','New case infomation not inserted successfully.');
                    return $this->redirect(Yii::$app->request->referrer);
                }
            
		}
          
        return $this->render('mntl/mntl',['model' => $model,"phone_telco" => $returnResponse,"newCase" => $newCase,"masterCaseInfoTypeId" => $masterCaseInfoTypeId,"tipOff" => $filterTipOffNoResponse]);
       
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
        $case_status_values = "";
        $case_status_values .= array_search("Pending",Yii::$app->mycomponent->getMasterData('master_status_status')).",".array_search("Rejected",Yii::$app->mycomponent->getMasterData('master_status_status')).",".array_search("Closed",Yii::$app->mycomponent->getMasterData('master_status_status')).",".array_search("Reopen",Yii::$app->mycomponent->getMasterData('master_status_status'));
        $responses = $client->createRequest()
            ->setFormat(Client::FORMAT_URLENCODED)
            ->setMethod('GET')
            //->setUrl($this->_url . 'case_info?filter=requestor_ref,eq,'.$session->get('userId').'&filter=case_status,in,1,2,3')
            //->setUrl($this->_url . 'case_info?filter=requestor_ref,eq,'.'1'.'&filter=case_status,in,1,2,3,33&filter=master_case_info_type_id,eq,1&join=master_status&order=id,desc')
            ->setUrl($this->_url . 'case_info?filter=requestor_ref,eq,'.$session->get('userId').'&filter=case_status,in,'.$case_status_values.'&filter=master_case_info_type_id,eq,1&join=master_status&order=id,desc')
            ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
            ->send();
        $mediaSocialResponse = $responses->data['records'];
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
        $model->scenario='create';
        $session = Yii::$app->session;
        $masterCaseInfoTypeId = array_search("Social Media",Yii::$app->mycomponent->getMasterData('master_case_info_type'));
        /******
         * load masterdata from the master component and pass these data into view page
         */
        $masterStatusSuspect = Yii::$app->mycomponent->getMasterData('master_suspect');
        $purposeOfApplication = Yii::$app->mycomponent->getMasterData('master_status_purpose_of_application');
		$newCase = Yii::$app->mycomponent->getMasterData('master_status_new_case');
        $suspectOrSaksi = Yii::$app->mycomponent->getMasterData('master_status_suspect_or_witness');
        $masterSocialMedia = Yii::$app->mycomponent->getMasterData('master_social_media');
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
            $caseInfo['requestor_ref'] = $session->get('userId');
            //$caseInfo['requestor_ref'] = 1;
            $caseInfo['bagipihak_dirisendiri'] = $data['PermohonanForm']['for_self'];
            $caseInfo['no_telephone'] = $data['PermohonanForm']['no_telephone'] ? $data['PermohonanForm']['no_telephone'] : 0;
            $caseInfo['self_name'] = $data['PermohonanForm']['selfName'];
            $caseInfo['email'] = $data['PermohonanForm']['email'];
            $caseInfo['report_no'] = $data['PermohonanForm']['report_no'];
            $caseInfo['investigation_no'] = $data['PermohonanForm']['investigation_no'];
            $caseInfo['case_summary'] = $data['PermohonanForm']['case_summary'];
            $caseInfo['surat_rasmi'] = $suratRasmiFileName;
            $caseInfo['laporan_polis'] = $loparaPoliceFileName;
            $caseInfo['case_status'] = array_search("Pending",Yii::$app->mycomponent->getMasterData('master_status_status'));
            $caseInfo['created_by'] = $session->get('userId');
            //$caseInfo['created_by'] = 1;
            if(isset($data['PermohonanForm']['application_purpose']) && !empty($data['PermohonanForm']['application_purpose']))
            {
            $caseInfo['master_status_purpose_of_application_id'] = implode(",",$data['PermohonanForm']['application_purpose']);
            $caseInfo['purpose_of_application_info'] = $data['PermohonanForm']['application_purpose_info'];
            }
           
        if(!empty($data['PermohonanForm']['master_status_status_suspek_id'][0]))
        {
            for($i=0;$i<=count($data['PermohonanForm']['master_status_status_suspek_id'])-1;$i++)
            {
                $caseStatusSuspek[$i]['master_status_suspect_or_saksi_id']  = $data['PermohonanForm']['master_status_suspect_or_saksi_id'][$i] ? $data['PermohonanForm']['master_status_suspect_or_saksi_id'][$i]: 0;
                $caseStatusSuspek[$i]['master_status_status_suspek_id']  = $data['PermohonanForm']['master_status_status_suspek_id'][$i] ? $data['PermohonanForm']['master_status_status_suspek_id'][$i] : 0;
                $caseStatusSuspek[$i]['ic']  = $data['PermohonanForm']['ic'][$i] ? $data['PermohonanForm']['ic'][$i] : 0;
                $caseStatusSuspek[$i]['name']  = $data['PermohonanForm']['name'][$i] ? $data['PermohonanForm']['name'][$i] : "NULL";
                $caseStatusSuspek[$i]['created_by'] = $session->get('userId');
                //$caseStatusSuspek[$i]['created_by'] = 1;
                if(isset($data['PermohonanForm']['others'][$i]) && !empty($data['PermohonanForm']['others'][$i]))
                {
                    $caseStatusSuspek[$i]['others']  = $data['PermohonanForm']['others'][$i];
                }
                
            }
        }
            for($i=0;$i<=count($data['PermohonanForm']['url'])-1;$i++)
            { 
                if(!empty($data['PermohonanForm']['master_social_media_id'][$i]))
                {
                    $caseInvolvedURL[$i]["master_social_media_id"]  = $data['PermohonanForm']['master_social_media_id'][$i] ? $data['PermohonanForm']['master_social_media_id'][$i] : 0;
                    $caseInvolvedURL[$i]["url"]  = $data['PermohonanForm']['url'][$i] ? $data['PermohonanForm']['url'][$i] : "NULL";
                    $caseInvolvedURL[$i]['created_by'] = $session->get('userId');
                    //$caseInvolvedURL[$i]['created_by'] = 1;
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
                    return $this->redirect('../permohonan/mediasosial');
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
        $model->scenario='createBlockRequest';
        $session = Yii::$app->session;
        $masterCaseInfoTypeId = array_search("Blocking Request",Yii::$app->mycomponent->getMasterData('master_case_info_type'));
        $suratRasmiFileName = "";
        $suratRasmiDFFileName = "";
        $loparaPoliceFileName = "";
        $loparaPoliceDFFileName = "";
        

        /******
         * load masterdata from the master component and pass these data into view page
         */
		$newCase = Yii::$app->mycomponent->getMasterData('master_status_new_case');
        $masterSocialMedia = Yii::$app->mycomponent->getMasterData('master_social_media');
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
            $caseInfo['requestor_ref'] = $session->get('userId');
            //$caseInfo['requestor_ref'] = 1;
            $caseInfo['bagipihak_dirisendiri'] = $data['BlockRequestForm']['for_self'];
            $caseInfo['no_telephone'] = $data['BlockRequestForm']['no_telephone'] ? $data['BlockRequestForm']['no_telephone'] : 0;
            $caseInfo['self_name'] = $data['BlockRequestForm']['selfName'] ? $data['BlockRequestForm']['selfName'] : "NULL";
            $caseInfo['email'] = $data['BlockRequestForm']['email'] ? $data['BlockRequestForm']['email'] : "NULL";
            $caseInfo['report_no'] = $data['BlockRequestForm']['report_no'];
            $caseInfo['investigation_no'] = $data['BlockRequestForm']['investigation_no'];
            $caseInfo['case_summary'] = $data['BlockRequestForm']['case_summary'];
            $caseInfo['surat_rasmi'] = $suratRasmiFileName;
            $caseInfo['laporan_polis'] = $loparaPoliceFileName;
            //$caseInfo['attachment_url'] = $data['BlockRequestForm']['attachmentURL'] ? $data['BlockRequestForm']['attachmentURL'] : "NULL";
            $caseInfo['case_status'] = array_search("Pending",Yii::$app->mycomponent->getMasterData('master_status_status'));
            $caseInfo['created_by'] = $session->get('userId');
            //$caseInfo['created_by'] = 1;
            if(isset($data['BlockRequestForm']['application_purpose']) && !empty($data['BlockRequestForm']['application_purpose']))
            {
            $caseInfo['master_status_purpose_of_application_id'] = implode(",",$data['BlockRequestForm']['application_purpose']);
            $caseInfo['purpose_of_application_info'] = $data['BlockRequestForm']['application_purpose_info'];
            }
            
            if(isset($data['BlockRequestForm']['url']) && count($data['BlockRequestForm']['url']) > 0)
            {
            for($i=0;$i<=count($data['BlockRequestForm']['url'])-1;$i++)
            { 
                if(!empty($data['BlockRequestForm']['master_social_media_id'][$i]))
                {
                    $caseInvolvedURL[$i]["master_social_media_id"]  = $data['BlockRequestForm']['master_social_media_id'][$i];
                    $caseInvolvedURL[$i]["url"]  = $data['BlockRequestForm']['url'][$i];
                    $caseInvolvedURL[$i]["created_by"]  = $session->get('userId');
                    //$caseInvolvedURL[$i]["created_by"]  = 1;
                }
                
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
                    /*Yii::$app->session->addFlash('success','Successfully added new case infomation.');
                    return $this->redirect('../dashboard/index');*/
                    Yii::$app->session->addFlash('success','Successfully added new case infomation.');
                    return $this->redirect('../permohonan/block-request-list');
                }
                else{
                    Yii::$app->session->addFlash('failed','New case infomation not inserted successfully.');
                    return $this->redirect(Yii::$app->request->referrer);
                }
            
		}
          
        return $this->render('blockrequest/blockrequest',['model'=>$model,"newCase" => $newCase,"offences" => $filterOffenceResponse,"masterSocialMedia" => $masterSocialMedia,"masterCaseInfoTypeId" => $masterCaseInfoTypeId]);
        
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
        $model->scenario="edit";
        $session = Yii::$app->session;
        /******
         * load masterdata from the master component and pass these data into view page
         */
		$masterStatusSuspect = Yii::$app->mycomponent->getMasterData('master_suspect');
        $purposeOfApplication = Yii::$app->mycomponent->getMasterData('master_status_purpose_of_application');
		$newCase = Yii::$app->mycomponent->getMasterData('master_status_new_case');
        $suspectOrSaksi = Yii::$app->mycomponent->getMasterData('master_status_suspect_or_witness');
        $masterSocialMedia = Yii::$app->mycomponent->getMasterData('master_social_media');


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

        $prevSuspekSakhi = array();
        //$newSuspekSakhi = array();
        $newSelectedSuspekSakhi = array();
        //$prevDeletedSuspekSakhi = array();

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
            

        /*********
           * once validation is success then set the data as an array and convert these data into json object and then pass it to stored procedure as a arguments
           * 
           *  */     
          if ($model->load(Yii::$app->request->post()) && $model->validate()) {  
            $data = Yii::$app->request->post();
            if(count($responses->data['records']) > 0)
            {
               foreach($responses->data['records'][0]['case_offence'] as $offenceVal):
                $prevOffences[] = $offenceVal['offence_id'];
               endforeach; 
            }
            $newOffences = $data['PermohonanForm']['offence'];
            $newSelectedOffences = array_values(array_diff($newOffences,$prevOffences));
            $prevDeletedOffences = array_values(array_diff($prevOffences,$newOffences));
            
            $this->_FileUploadSuratRasmi = Yii::$app->params['FILE_UPLOAD_SURAT_RASMI']."permohonan/surat_rasmi/";
            $this->_FileUploadLaporanPolice = Yii::$app->params['FILE_UPLOAD_LAPORAN_POLIS']."permohonan/laporan_polis/";
            
            $model->surat_rasmi = UploadedFile::getInstance($model, 'surat_rasmi');
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
            $newCaseInvolvedURL = array();
            $offences = array();
            
            $caseInfo['master_case_info_type_id'] = $data['PermohonanForm']['master_case_info_type_id'];
            $caseInfo['requestor_ref'] = $session->get('userId');
            $caseInfo['id'] = $data['PermohonanForm']['id'];
            //$caseInfo['requestor_ref'] = 1;
            $caseInfo['report_no'] = $data['PermohonanForm']['report_no'];
            $caseInfo['investigation_no'] = $data['PermohonanForm']['investigation_no'];
            $caseInfo['case_summary'] = $data['PermohonanForm']['case_summary'];
            $caseInfo['surat_rasmi'] = $suratRasmiFileName;
            $caseInfo['laporan_polis'] = $loparaPoliceFileName;
            //$caseInfo['attachment_url'] = $data['PermohonanForm']['attachmentURL'];
            $caseInfo['case_status'] = array_search("Pending",Yii::$app->mycomponent->getMasterData('master_status_status'));
            
            //$caseInfo['created_by'] = $session->get('userId');
            $caseInfo['updated_by'] =  $session->get('userId');
            if(isset($data['PermohonanForm']['application_purpose']) && !empty($data['PermohonanForm']['application_purpose']))
            { 
            $caseInfo['master_status_purpose_of_application_id'] = implode(",",$data['PermohonanForm']['application_purpose']);
            $caseInfo['purpose_of_application_info'] = $data['PermohonanForm']['application_purpose_info'];
            }
            if(isset($data['PermohonanForm']['master_status_status_suspek_id']) && count($data['PermohonanForm']['master_status_status_suspek_id']) > 0)
            { 
                for($i=0;$i<=count($data['PermohonanForm']['master_status_status_suspek_id'])-1;$i++)
                {
                    $caseStatusSuspek[$i]['case_info_id']  = $data['PermohonanForm']['caseInfoID'] ? $data['PermohonanForm']['caseInfoID']: 0;
                    $caseStatusSuspek[$i]['case_info_status_suspek_id']  = $data['PermohonanForm']['caseInfoStatusSuspekID'][$i] ? $data['PermohonanForm']['caseInfoStatusSuspekID'][$i]: 0;
                    $caseStatusSuspek[$i]['master_status_suspect_or_saksi_id']  = $data['PermohonanForm']['master_status_suspect_or_saksi_id'][$i] ? $data['PermohonanForm']['master_status_suspect_or_saksi_id'][$i]: 0;
                    $caseStatusSuspek[$i]['master_status_status_suspek_id']  = $data['PermohonanForm']['master_status_status_suspek_id'][$i] ? $data['PermohonanForm']['master_status_status_suspek_id'][$i] : 0;
                    $caseStatusSuspek[$i]['ic']  = $data['PermohonanForm']['ic'][$i] ? $data['PermohonanForm']['ic'][$i] : 0;
                    $caseStatusSuspek[$i]['name']  = $data['PermohonanForm']['name'][$i] ? $data['PermohonanForm']['name'][$i] : "NULL";
                    //$caseStatusSuspek[$i]['created_by'] = $session->get('userId');
                    $caseStatusSuspek[$i]['updated_by'] = $session->get('userId');
                    $caseStatusSuspek[$i]['others']  = "NULL";
                    if(isset($data['PermohonanForm']['others'][$i]) && !empty($data['PermohonanForm']['others'][$i]))
                    {
                        $caseStatusSuspek[$i]['others']  = $data['PermohonanForm']['others'][$i];
                    }
                
                }
                
            }
            
            if(isset($data['PermohonanForm']['new_master_status_status_suspek_id']) && count($data['PermohonanForm']['new_master_status_status_suspek_id']) > 0)
            { 
                for($i=0;$i<=count($data['PermohonanForm']['new_master_status_status_suspek_id'])-1;$i++)
                { 
                    $newSelectedSuspekSakhi[$i]['case_info_id']  = $data['PermohonanForm']['caseInfoID'] ? $data['PermohonanForm']['caseInfoID']: 0;
                    $newSelectedSuspekSakhi[$i]['master_status_suspect_or_saksi_id']  = $data['PermohonanForm']['new_master_status_suspect_or_saksi_id'][$i] ? $data['PermohonanForm']['new_master_status_suspect_or_saksi_id'][$i]: 0;
                    $newSelectedSuspekSakhi[$i]['master_status_status_suspek_id']  = $data['PermohonanForm']['new_master_status_status_suspek_id'][$i] ? $data['PermohonanForm']['new_master_status_status_suspek_id'][$i] : 0;
                    $newSelectedSuspekSakhi[$i]['ic']  = $data['PermohonanForm']['new_ic'][$i] ? $data['PermohonanForm']['new_ic'][$i] : "";
                    $newSelectedSuspekSakhi[$i]['name']  = $data['PermohonanForm']['new_name'][$i] ? $data['PermohonanForm']['new_name'][$i] : "NULL";
                    $newSelectedSuspekSakhi[$i]['others']  = "NULL";
                    $newSelectedSuspekSakhi[$i]['created_by'] = $session->get('userId');
                    $newSelectedSuspekSakhi[$i]['updated_by'] = $session->get('userId');
                    if(isset($data['PermohonanForm']['new_others'][$i]) && !empty($data['PermohonanForm']['new_others'][$i]))
                    {
                        $newSelectedSuspekSakhi[$i]['others']  = $data['PermohonanForm']['new_others'][$i] ? $data['PermohonanForm']['new_others'][$i] : "NULL";
                        
                    }
                
                }
            }
            
            if(isset($data['PermohonanForm']['url']) && count($data['PermohonanForm']['url']) > 0)
            {
                for($i=0;$i<=count($data['PermohonanForm']['url'])-1;$i++)
                { 
                    if(!empty($data['PermohonanForm']['master_social_media_id'][$i]))
                    {
                        $caseInvolvedURL[$i]["case_info_url_involved_id"]  = $data['PermohonanForm']['caseInfoURLInvolvedId'][$i] ? $data['PermohonanForm']['caseInfoURLInvolvedId'][$i] : 0;
                        $caseInvolvedURL[$i]["master_social_media_id"]  = $data['PermohonanForm']['master_social_media_id'][$i] ? $data['PermohonanForm']['master_social_media_id'][$i] : 0;
                        $caseInvolvedURL[$i]["url"]  = $data['PermohonanForm']['url'][$i] ? $data['PermohonanForm']['url'][$i] : "NULL";
                        //$caseInvolvedURL[$i]['created_by'] = $session->get('userId');
                        $caseInvolvedURL[$i]['updated_by'] = $session->get('userId');
                    }
                    
                }
            }
            if(isset($data['PermohonanForm']['new_master_social_media_id']) && count($data['PermohonanForm']['new_master_social_media_id']) > 0)
            {
                for($i=0;$i<=count($data['PermohonanForm']['new_master_social_media_id'])-1;$i++)
                { 
                    if(!empty($data['PermohonanForm']['new_master_social_media_id'][$i]) && !empty($data['PermohonanForm']['new_url'][$i]))
                    { 
                        $newCaseInvolvedURL[$i]["case_info_id"]  = $data['PermohonanForm']['caseInfoID'] ? $data['PermohonanForm']['caseInfoID'] : 0;
                        $newCaseInvolvedURL[$i]["master_social_media_id"]  = $data['PermohonanForm']['new_master_social_media_id'][$i] ? $data['PermohonanForm']['new_master_social_media_id'][$i] : 0;
                        $newCaseInvolvedURL[$i]["url"]  = $data['PermohonanForm']['new_url'][$i] ? $data['PermohonanForm']['new_url'][$i] : "NULL";
                        $newCaseInvolvedURL[$i]['created_by'] = $session->get('userId');
                        $newCaseInvolvedURL[$i]['updated_by'] = $session->get('userId');
                    }
                    
                }
            }

            
            //$offences = $data['PermohonanForm']['offence'];

            
            //echo json_encode($caseInfo).'<br>';
            //echo json_encode($caseStatusSuspek).'<br>';
            //echo json_encode($newSelectedSuspekSakhi).'<br>';
            //echo json_encode($caseInvolvedURL).'<br>';
            //echo json_encode($newCaseInvolvedURL).'<br>';
            //echo json_encode($newSelectedOffences).'<br>';
            //echo json_encode($prevDeletedOffences).'<br>';
            
            
            //exit;
            
            
            $caseInfoResponse = $client->createRequest()
            ->setFormat(Client::FORMAT_URLENCODED)
            ->setMethod('POST')
            ->setUrl($this->_url_procedure.'case_info_edit')
            ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass,"Accept" => "*/*"])
            ->setData(["caseInfo" => json_encode($caseInfo),"caseStatusSuspek" => json_encode($caseStatusSuspek),"newCaseStatusSuspek" => json_encode($newSelectedSuspekSakhi),"caseInvolvedURL" => json_encode($caseInvolvedURL),"newCaseInvolvedURL" => json_encode($newCaseInvolvedURL),"newOffences" => json_encode($newSelectedOffences),"deleteOffences" => json_encode($prevDeletedOffences)])
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
                    return $this->redirect('../permohonan/mediasosial');
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


    /**
     * reopen case
     *
     * @return string
     */
    public function actionReopencase($id)
    { 
        $this->layout =  'main';
        $model = new PermohonanForm();
        $model->scenario="reopen";
        $session = Yii::$app->session;
        /******
         * load masterdata from the master component and pass these data into view page
         */
	    $masterStatusSuspect = Yii::$app->mycomponent->getMasterData('master_suspect');
        $purposeOfApplication = Yii::$app->mycomponent->getMasterData('master_status_purpose_of_application');
		$newCase = Yii::$app->mycomponent->getMasterData('master_status_new_case');
        $suspectOrSaksi = Yii::$app->mycomponent->getMasterData('master_status_suspect_or_witness');
        $masterSocialMedia = Yii::$app->mycomponent->getMasterData('master_social_media');
        $mediaSocialResponse = array();
        $client = new Client();
        $offenceResponse = array();
        $filterOffenceResponse = array();
        $prevOffences = array();
        $newOffences = array();
        $newSelectedOffences = array();
        
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
            
        /*********
           * once validation is success then set the data as an array and convert these data into json object and then pass it to stored procedure as a arguments
           * 
           *  */     
          if ($model->load(Yii::$app->request->post()) && $model->validate()) {  
            $data = Yii::$app->request->post();
            $newOffences = $data['PermohonanForm']['offence'];
            
            $caseInfo = array();
            $caseStatusSuspek = array();
            $newSelectedSuspekSakhi = array();
            $caseInvolvedURL = array();
            $newCaseInvolvedURL = array();
            $offences = array();
            $masterSocialMediaId = 0;
            $masterSuspekId = 0;
            
            $caseInfo['master_case_info_type_id'] = $data['PermohonanForm']['master_case_info_type_id'];
            $caseInfo['requestor_ref'] = $session->get('userId');
            //$caseInfo['id'] = $data['PermohonanForm']['id'];
            //$caseInfo['requestor_ref'] = 1;
            $caseInfo['report_no'] = $data['PermohonanForm']['report_no'];
            $caseInfo['investigation_no'] = $data['PermohonanForm']['investigation_no'];
            $caseInfo['case_summary'] = $data['PermohonanForm']['case_summary'];
            $caseInfo['case_status'] = array_search("Pending",Yii::$app->mycomponent->getMasterData('master_status_status'));
            
            $caseInfo['created_by'] = $session->get('userId');
            //$caseInfo['updated_by'] = $session->get('userId');
            if(isset($data['PermohonanForm']['application_purpose']) && !empty($data['PermohonanForm']['application_purpose']))
            { 
            $caseInfo['master_status_purpose_of_application_id'] = implode(",",$data['PermohonanForm']['application_purpose']);
            $caseInfo['purpose_of_application_info'] = $data['PermohonanForm']['application_purpose_info'];
            }
            
            if(isset($data['PermohonanForm']['master_status_status_suspek_id']) && count($data['PermohonanForm']['master_status_status_suspek_id']) > 0)
            { 
                for($i=0;$i<=count($data['PermohonanForm']['master_status_status_suspek_id'])-1;$i++)
                {
                    //$caseStatusSuspek[$i]['case_info_status_suspek_id']  = $data['PermohonanForm']['caseInfoStatusSuspekID'][$i] ? $data['PermohonanForm']['caseInfoStatusSuspekID'][$i]: 0;
                    $caseStatusSuspek[$i]['master_status_suspect_or_saksi_id']  = $data['PermohonanForm']['master_status_suspect_or_saksi_id'][$i] ? $data['PermohonanForm']['master_status_suspect_or_saksi_id'][$i]: 0;
                    $caseStatusSuspek[$i]['master_status_status_suspek_id']  = $data['PermohonanForm']['master_status_status_suspek_id'][$i] ? $data['PermohonanForm']['master_status_status_suspek_id'][$i] : 0;
                    $caseStatusSuspek[$i]['ic']  = $data['PermohonanForm']['ic'][$i] ? $data['PermohonanForm']['ic'][$i] : 0;
                    $caseStatusSuspek[$i]['name']  = $data['PermohonanForm']['name'][$i] ? $data['PermohonanForm']['name'][$i] : "NULL";
                    $caseStatusSuspek[$i]['created_by'] = $session->get('userId');
                    //$caseStatusSuspek[$i]['updated_by'] = $session->get('userId');
                    if(isset($data['PermohonanForm']['others'][$i]) && !empty($data['PermohonanForm']['others'][$i]))
                    {
                        $caseStatusSuspek[$i]['others']  = $data['PermohonanForm']['others'][$i];
                    }
                    $masterSuspekId++;
                    
                }
            }
            if(isset($data['PermohonanForm']['new_master_status_status_suspek_id']) && count($data['PermohonanForm']['new_master_status_status_suspek_id']) > 0)
            { 
                $newMasterSuspekId = 0;
                if($masterSuspekId > 0)
                {
                    $newMasterSuspekId = $masterSuspekId;
                }
                for($i=0;$i<=count($data['PermohonanForm']['new_master_status_status_suspek_id'])-1;$i++)
                { 
                    //$caseStatusSuspek[$newMasterSuspekId]['case_info_id']  = $data['PermohonanForm']['caseInfoID'] ? $data['PermohonanForm']['caseInfoID']: 0;
                    $caseStatusSuspek[$newMasterSuspekId]['master_status_suspect_or_saksi_id']  = $data['PermohonanForm']['new_master_status_suspect_or_saksi_id'][$i] ? $data['PermohonanForm']['new_master_status_suspect_or_saksi_id'][$i]: 0;
                    $caseStatusSuspek[$newMasterSuspekId]['master_status_status_suspek_id']  = $data['PermohonanForm']['new_master_status_status_suspek_id'][$i] ? $data['PermohonanForm']['new_master_status_status_suspek_id'][$i] : 0;
                    $caseStatusSuspek[$newMasterSuspekId]['ic']  = $data['PermohonanForm']['new_ic'][$i] ? $data['PermohonanForm']['new_ic'][$i] : "";
                    $caseStatusSuspek[$newMasterSuspekId]['name']  = $data['PermohonanForm']['new_name'][$i] ? $data['PermohonanForm']['new_name'][$i] : "NULL";
                    $caseStatusSuspek[$newMasterSuspekId]['others']  = "NULL";
                    $caseStatusSuspek[$newMasterSuspekId]['created_by'] = $session->get('userId');
                    //$newSelectedSuspekSakhi[$newMasterSuspekId]['updated_by'] = $session->get('userId');
                    if(isset($data['PermohonanForm']['new_others'][$i]) && !empty($data['PermohonanForm']['new_others'][$i]))
                    {
                        $caseStatusSuspek[$newMasterSuspekId]['others']  = $data['PermohonanForm']['new_others'][$i] ? $data['PermohonanForm']['new_others'][$i] : "NULL";
                        
                    }
                    $newMasterSuspekId++;
                }
                
                
            } 
            if(isset($data['PermohonanForm']['master_social_media_id']) && count($data['PermohonanForm']['master_social_media_id']) > 0)
            { 
                
                for($i=0;$i<=count($data['PermohonanForm']['url'])-1;$i++)
                { 
                    if(!empty($data['PermohonanForm']['master_social_media_id'][$i]))
                    {
                        //$caseInvolvedURL[$i]["case_info_url_involved_id"]  = $data['PermohonanForm']['caseInfoURLInvolvedId'][$i] ? $data['PermohonanForm']['caseInfoURLInvolvedId'][$i] : 0;
                        $caseInvolvedURL[$i]["master_social_media_id"]  = $data['PermohonanForm']['master_social_media_id'][$i] ? $data['PermohonanForm']['master_social_media_id'][$i] : 0;
                        $caseInvolvedURL[$i]["url"]  = $data['PermohonanForm']['url'][$i] ? $data['PermohonanForm']['url'][$i] : "NULL";
                        $caseInvolvedURL[$i]['created_by'] = $session->get('userId');
                        //$caseInvolvedURL[$i]['updated_by'] = $session->get('userId');
                        $masterSocialMediaId++;
                    }
                    
                }
            }
            if(isset($data['PermohonanForm']['new_master_social_media_id']) && count($data['PermohonanForm']['new_master_social_media_id']) > 0)
            {  
                $newMasterSocialMediaId = 0;
                if($masterSocialMediaId > 0)
                {
                    $newMasterSocialMediaId = $masterSocialMediaId;
                }
                
                for($i=0;$i<=count($data['PermohonanForm']['new_master_social_media_id'])-1;$i++)
                { 
                    if(!empty($data['PermohonanForm']['new_master_social_media_id'][$i]) && !empty($data['PermohonanForm']['new_url'][$i]))
                    { 
                        //$caseInvolvedURL[$i]["case_info_id"]  = $data['PermohonanForm']['caseInfoID'] ? $data['PermohonanForm']['caseInfoID'] : 0;
                        $caseInvolvedURL[$newMasterSocialMediaId]["master_social_media_id"]  = $data['PermohonanForm']['new_master_social_media_id'][$i] ? $data['PermohonanForm']['new_master_social_media_id'][$i] : 0;
                        $caseInvolvedURL[$newMasterSocialMediaId]["url"]  = $data['PermohonanForm']['new_url'][$i] ? $data['PermohonanForm']['new_url'][$i] : "NULL";
                        $caseInvolvedURL[$newMasterSocialMediaId]['created_by'] = $session->get('userId');
                       // $caseInvolvedURL[$newMasterSocialMediaId]['updated_by'] = $session->get('userId');
                        $newMasterSocialMediaId++;
                    }
                    
                }

                //echo "<pre>";print_r($caseInvolvedURL);exit;
                
            }    
            //echo json_encode($caseInfo).'<br>';
            //echo json_encode($caseStatusSuspek).'<br>';
            //echo json_encode($caseInvolvedURL).'<br>';
            //echo json_encode($newOffences).'<br>';
            //exit;

            $caseInfoResponse = $client->createRequest()
            ->setFormat(Client::FORMAT_URLENCODED)
            ->setMethod('POST')
            ->setUrl($this->_url_procedure.'case_info')
            ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass,"Accept" => "*/*"])
            ->setData(["caseInfo" => json_encode($caseInfo),"caseStatusSuspek" => json_encode($caseStatusSuspek),"caseInvolvedURL" => json_encode($caseInvolvedURL),"offences" => json_encode($newOffences)])
            ->send();

             
            if($caseInfoResponse->statusCode == 200 && count($caseInfoResponse->data['records']) > 0)
                { 
                    Yii::$app->session->addFlash('success','Successfully reopen case infomation.');
                    return $this->redirect('../permohonan/mediasosial');
                }
                else{
                    Yii::$app->session->addFlash('failed','Reopen case infomation not inserted successfully.');
                    return $this->redirect(Yii::$app->request->referrer);
                }
            
		}    
        if(count($responses->data['records']) > 0)
        {
            $mediaSocialResponse = $responses->data['records'][0];
        }
        
        return $this->render('reopencase', ['model'=>$model,"mediaSocialResponse" => $mediaSocialResponse,"masterStatusSuspect" => $masterStatusSuspect,"purposeOfApplication" => $purposeOfApplication,"newCase" => $newCase,"offences" => $filterOffenceResponse,"suspectOrSaksi" => $suspectOrSaksi,"masterSocialMedia" => $masterSocialMedia]);
       
        
    }
    
    /**
     * View social media page
     *
     * @return string
     */
    public function actionViewSocialMedia($id)
    {  
        $this->layout =  'main';
        $session = Yii::$app->session;
        

      
        $client = new Client();
        $session = Yii::$app->session;
        $mediaSocialResponse = array();
        $session->get('userId');
        $responses = $client->createRequest()
            ->setFormat(Client::FORMAT_URLENCODED)
            ->setMethod('GET')
            //->setUrl($this->_url . 'case_info?filter=requestor_ref,eq,'.$session->get('userId').'&filter=case_status,in,1,2,3&join=master_status&order=id,desc')
            ->setUrl($this->_url . 'case_info?filter=id,eq,'.$id.'&join=case_offence,offence&join=case_info_status_suspek,master_status&join=case_info_url_involved,master_status&order=id,desc')
            ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
            ->send();
            
        if(count($responses->data['records']) > 0)
        {
            $mediaSocialResponse = $responses->data['records'][0];
        }
        return $this->render('viewsocialmedia', ["mediaSocialResponse" => $mediaSocialResponse,"id" => $id]);
       
        
    }

    /**
     * Displays Permohonan Baru page.
     *
     * @return string
     */
    public function actionBlockRequestList()
    {
        
        $client = new Client();
        $session = Yii::$app->session;
        $mediaSocialResponse = array();
        $session->get('userId');
        $case_status_values = "";
        $case_status_values .= array_search("Pending",Yii::$app->mycomponent->getMasterData('master_status_status')).",".array_search("Rejected",Yii::$app->mycomponent->getMasterData('master_status_status')).",".array_search("Closed",Yii::$app->mycomponent->getMasterData('master_status_status')).",".array_search("Reopen",Yii::$app->mycomponent->getMasterData('master_status_status'));
        $responses = $client->createRequest()
            ->setFormat(Client::FORMAT_URLENCODED)
            ->setMethod('GET')
            //->setUrl($this->_url . 'case_info?filter=requestor_ref,eq,'.$session->get('userId').'&filter=case_status,in,1,2,3')
            ->setUrl($this->_url . 'case_info?filter=requestor_ref,eq,'.$session->get('userId').'&filter=case_status,in,'.$case_status_values.'&filter=master_case_info_type_id,eq,2&join=master_status&order=id,desc')
            ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
            ->send();
        $mediaSocialResponse = $responses->data['records'];
        //return $this->render('tplist', ['responses' => $responses]);
        return $this->render('blockrequest/blockrequestlist', ['mediaSocialResponse' => $mediaSocialResponse]);
    }



    /**
     * Edit social media page
     *
     * @return string
     */
    public function actionEditBlockRequest($id)
    { 
        $this->layout =  'main';
        //$model = new PermohonanForm();
        $model = new BlockRequestForm();
        $model->scenario="editBlockRequest";
        $session = Yii::$app->session;
        /******
         * load masterdata from the master component and pass these data into view page
         */
		$newCase = Yii::$app->mycomponent->getMasterData('master_status_new_case');
        $masterSocialMedia = Yii::$app->mycomponent->getMasterData('master_social_media');
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
        $prevSelectedOffences = array();
        $removePrevSelectedOffences = array();
        $offencesListRes = array();

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
            ->setUrl($this->_url . 'case_info?filter=id,eq,'.$id.'&join=case_offence,offence&join=case_info_url_involved&order=id,desc')
            ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
            ->send();
            
        /*********
           * once validation is success then set the data as an array and convert these data into json object and then pass it to stored procedure as a arguments
           * 
           *  */     
          if ($model->load(Yii::$app->request->post()) && $model->validate()) {  
            $data = Yii::$app->request->post();
            if(count($responses->data['records']) > 0)
            {
               foreach($responses->data['records'][0]['case_offence'] as $offenceVal):
                $prevOffences[] = $offenceVal['offence_id'];
               endforeach; 
            }
            $newOffences = $data['BlockRequestForm']['offence'];
            $newSelectedOffences = array_values(array_diff($newOffences,$prevOffences));
            $prevDeletedOffences = array_values(array_diff($prevOffences,$newOffences));
            
            $this->_FileUploadSuratRasmi = Yii::$app->params['FILE_UPLOAD_SURAT_RASMI']."block-request/surat_rasmi/";
            $this->_FileUploadLaporanPolice = Yii::$app->params['FILE_UPLOAD_LAPORAN_POLIS']."block-request/laporan_polis/";
            
            $model->surat_rasmi = UploadedFile::getInstance($model, 'surat_rasmi');
            if(isset($model->surat_rasmi) && !empty($model->surat_rasmi) )
            {  
            $suratRasmiFileName =  $this->_FileUploadSuratRasmi."".'_'.$model->surat_rasmi->baseName .'_'.date('YmdHis'). '.' . $model->surat_rasmi->extension;
            }
            else if(!isset($model->surat_rasmi) && !empty($data['BlockRequestForm']['surat_rasmi_last_attachment'])){ 
                $suratRasmiFileName =  $data['BlockRequestForm']['surat_rasmi_last_attachment'];
            }
           
            $suratRasmiDFFileName = \Yii::getAlias('@webroot')."/". $suratRasmiFileName;
            
            $model->laporan_polis = UploadedFile::getInstance($model, 'laporan_polis'); 
            if(isset($model->laporan_polis) && !empty($model->laporan_polis))
            {
            $loparaPoliceFileName =  $this->_FileUploadLaporanPolice."".'_'.$model->laporan_polis->baseName .'_'.date('YmdHis'). '.' . $model->laporan_polis->extension;
            }
            else if(!isset($model->laporan_polis) && !empty($data['BlockRequestForm']['laporan_polis_last_attachment'])){
                $loparaPoliceFileName =  $data['BlockRequestForm']['laporan_polis_last_attachment'];
            }
            $loparaPoliceDFFileName = \Yii::getAlias('@webroot')."/". $loparaPoliceFileName;
            
            $caseInfo = array();
            $caseStatusSuspek = array();
            $caseInvolvedURL = array();
            $offences = array();
            $newSelectedSuspekSakhi = array();
            $newCaseInvolvedURL = array();
            $newSelectedOffences = array();
            $prevDeletedOffences = array();

            $caseInfo['master_case_info_type_id'] = $data['BlockRequestForm']['master_case_info_type_id'];
            $caseInfo['requestor_ref'] = $session->get('userId');
            //$caseInfo['requestor_ref'] = 1;
            $caseInfo['id'] = $data['BlockRequestForm']['id'];
            $caseInfo['investigation_no'] = $data['BlockRequestForm']['investigation_no'];
            $caseInfo['case_summary'] = $data['BlockRequestForm']['case_summary'];
            $caseInfo['surat_rasmi'] = $suratRasmiFileName;
            $caseInfo['laporan_polis'] = $loparaPoliceFileName;
            $caseInfo['attachment_url'] = isset($data['BlockRequestForm']['attachmentURL']) ? $data['BlockRequestForm']['attachmentURL'] : "NULL";
            $caseInfo['case_status'] = array_search("Pending",Yii::$app->mycomponent->getMasterData('master_status_status'));
            
            //$caseInfo['created_by'] = $session->get('userId');
            $caseInfo['updated_by'] = $session->get('userId');
            if(isset($data['BlockRequestForm']['master_social_media_id']) && count($data['BlockRequestForm']['master_social_media_id']) > 0)
            {
                for($i=0;$i<=count($data['BlockRequestForm']['url'])-1;$i++)
                { 
                    if(!empty($data['BlockRequestForm']['master_social_media_id'][$i]))
                    { 
                        if(isset($data['BlockRequestForm']['caseInfoURLInvolvedId']) && count($data['BlockRequestForm']['caseInfoURLInvolvedId']) > 0)
                        {
                        $caseInvolvedURL[$i]["case_info_url_involved_id"]  = $data['BlockRequestForm']['caseInfoURLInvolvedId'][$i] ? $data['BlockRequestForm']['caseInfoURLInvolvedId'][$i] : 0;
                        }
                        $caseInvolvedURL[$i]["master_social_media_id"]  = $data['BlockRequestForm']['master_social_media_id'][$i] ? $data['BlockRequestForm']['master_social_media_id'][$i] : 0;
                        $caseInvolvedURL[$i]["url"]  = $data['BlockRequestForm']['url'][$i] ? $data['BlockRequestForm']['url'][$i] : "NULL";
                        //$caseInvolvedURL[$i]['created_by'] = $session->get('userId');
                        $caseInvolvedURL[$i]['updated_by'] = $session->get('userId');
                    }
                    
                }
            }
            if(isset($data['BlockRequestForm']['new_master_social_media_id']) && count($data['BlockRequestForm']['new_master_social_media_id']) > 0)
            {  
                for($i=0;$i<=count($data['BlockRequestForm']['new_master_social_media_id'])-1;$i++)
                { 
                    if(!empty($data['BlockRequestForm']['new_master_social_media_id'][$i]) && !empty($data['BlockRequestForm']['new_url'][$i]))
                    { 
                        $newCaseInvolvedURL[$i]["case_info_id"]  = $data['BlockRequestForm']['id'] ? $data['BlockRequestForm']['id'] : 0;
                        $newCaseInvolvedURL[$i]["master_social_media_id"]  = $data['BlockRequestForm']['new_master_social_media_id'][$i] ? $data['BlockRequestForm']['new_master_social_media_id'][$i] : 0;
                        $newCaseInvolvedURL[$i]["url"]  = $data['BlockRequestForm']['new_url'][$i] ? $data['BlockRequestForm']['new_url'][$i] : "NULL";
                        $newCaseInvolvedURL[$i]['created_by'] = $session->get('userId');
                        $newCaseInvolvedURL[$i]['updated_by'] = $session->get('userId');
                    }
                    
                }
                
            }  
            
            //echo json_encode($caseInfo).'<br>';
            //echo json_encode($caseStatusSuspek).'<br>';
            //echo json_encode($newSelectedSuspekSakhi).'<br>';
            //echo json_encode($caseInvolvedURL).'<br>';
            //echo json_encode($newCaseInvolvedURL).'<br>';
            //echo json_encode($newSelectedOffences).'<br>';
            //echo json_encode($prevDeletedOffences).'<br>';exit;
            
            $caseInfoResponse = $client->createRequest()
            ->setFormat(Client::FORMAT_URLENCODED)
            ->setMethod('POST')
            ->setUrl($this->_url_procedure.'case_info_edit') 
            ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass,"Accept" => "*/*"])
            //->setData(["caseInfo" => json_encode($caseInfo),"caseStatusSuspek" => json_encode($caseStatusSuspek),"caseInvolvedURL" => json_encode($caseInvolvedURL),"newOffences" => json_encode($newSelectedOffences),"deleteOffences" => json_encode($prevDeletedOffences)])
            ->setData(["caseInfo" => json_encode($caseInfo),"caseStatusSuspek" => json_encode($caseStatusSuspek),"newCaseStatusSuspek" => json_encode($newSelectedSuspekSakhi),"caseInvolvedURL" => json_encode($caseInvolvedURL),"newCaseInvolvedURL" => json_encode($newCaseInvolvedURL),"newOffences" => json_encode($newSelectedOffences),"deleteOffences" => json_encode($prevDeletedOffences)])
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
                    return $this->redirect('../permohonan/block-request-list');
                }
                else{
                    Yii::$app->session->addFlash('failed','New case infomation not inserted successfully.');
                    return $this->redirect(Yii::$app->request->referrer);
                }
            
		}    
        
        if(count($responses->data['records']) > 0)
        {
            $mediaSocialResponse = $responses->data['records'][0];
                foreach($mediaSocialResponse['case_offence'] as $key => $offenceInfo):
                  if(array_key_exists($offenceInfo['offence_id'], $filterOffenceResponse))
                  {
                    $prevSelectedOffences[$offenceInfo['offence_id']] = $filterOffenceResponse[$offenceInfo['offence_id']];
                    $offencesListRes[$offenceInfo['offence_id']] = array("selected"=>true);
                  }
                endforeach;

                foreach($filterOffenceResponse as $key => $offenceInfo):
                    if(array_key_exists($key, $prevSelectedOffences))
                    {
                        unset($filterOffenceResponse[$key]);
                    }
                      
                  endforeach;
                  
        }
        return $this->render('blockrequest/editblockrequest', ['model'=>$model,"mediaSocialResponse" => $mediaSocialResponse,"newCase" => $newCase,"offences" => $filterOffenceResponse,"masterSocialMedia" => $masterSocialMedia,"prevSelectedOffences" => $prevSelectedOffences,"offencesListRes" => $offencesListRes]);
       
        
    }






    /*****
     * 
     * delete surath rasmi attachement of block request page fucntion
     * request value : id,path
     * @return json response either successfully deltion of failed.
     */
    public function actionDeleteBlockRequestSuratRasmi()
    {

        //$this->_FileTrashFolderBlockRequestSuratRasmi = Yii::$app->params['FILE_TRASH_BLOCK_REQUEST_SURAT_RASMI'];;
        //$this->__FileTrashFolderBlockRequestLaporanPolice
        $deleteResponse = array();
        if (Yii::$app->request->get('id') && Yii::$app->request->get('path')) {
            $trashPath = "";
             $imageName = explode("/",Yii::$app->request->get('path'));
             if(!empty(Yii::$app->request->get('path')) && Yii::$app->request->get('path') != "NULL")
             {
                $trashPath = \Yii::getAlias('@webroot').$this->_FileTrashFolderBlockRequestSuratRasmi.$imageName[3];
             }
             if(file_exists(\Yii::getAlias('@webroot')."/".Yii::$app->request->get('path')))
            {  
                $client = new Client();
                $fileResponse = $client->createRequest()
                ->setFormat(Client::FORMAT_URLENCODED)
                ->setMethod('POST')
                ->setUrl($this->_url_files."".ltrim($this->_FileTrashFolderBlockRequestSuratRasmi, $this->_FileTrashFolderBlockRequestSuratRasmi[0]))
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
     * delete laporan polis attachement of block request page fucntion
     * request value : id,path
     * @return json response either successfully deltion of failed.
     */
    public function actionDeleteBlockRequestLaporanPolis()
    {
        $deleteResponse = array();
        if (Yii::$app->request->get('id') && Yii::$app->request->get('path')) {
            $trashPath = "";
             $imageName = explode("/",Yii::$app->request->get('path'));
             if(!empty(Yii::$app->request->get('path')) && Yii::$app->request->get('path') != "")
             {
                $trashPath = \Yii::getAlias('@webroot').$this->_FileTrashFolderBlockRequestLaporanPolice.$imageName[3];
             }
             if(file_exists(\Yii::getAlias('@webroot')."/".Yii::$app->request->get('path')))
            {  
                $client = new Client();
                $fileResponse = $client->createRequest()
                ->setFormat(Client::FORMAT_URLENCODED)
                ->setMethod('POST')
                ->setUrl($this->_url_files."".ltrim($this->_FileTrashFolderBlockRequestLaporanPolice, $this->_FileTrashFolderBlockRequestLaporanPolice[0]))
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


    /**
     * reopen case
     *
     * @return string
     */
    public function actionReopenBlockRequest($id)
    { 
        $this->layout =  'main';
        $model = new BlockRequestForm();
        $model->scenario="reOpenBlockRequest";
        $session = Yii::$app->session;
        /******
         * load masterdata from the master component and pass these data into view page
         */
		$masterSocialMedia = Yii::$app->mycomponent->getMasterData('master_social_media');
        $mediaSocialResponse = array();
        $client = new Client();
        $offenceResponse = array();
        $filterOffenceResponse = array();
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
            
        /*********
           * once validation is success then set the data as an array and convert these data into json object and then pass it to stored procedure as a arguments
           * 
           *  */     
          if ($model->load(Yii::$app->request->post()) && $model->validate()) {  
            $data = Yii::$app->request->post();
            $newOffences = $data['BlockRequestForm']['offence'];
            $masterURLInvolvedId = 0;
            
            $caseInfo = array();
            $caseStatusSuspek = array();
            $caseInvolvedURL = array();
            $offences = array();
            $newSelectedSuspekSakhi = array();
            $newCaseInvolvedURL = array();
            $newSelectedOffences = array();
            $prevDeletedOffences = array();
            $caseInfo['master_case_info_type_id'] = $data['BlockRequestForm']['master_case_info_type_id'];
            $caseInfo['requestor_ref'] = $session->get('userId');
            $caseInfo['id'] = $data['BlockRequestForm']['id'];
            $caseInfo['investigation_no'] = $data['BlockRequestForm']['investigation_no'];
            $caseInfo['case_summary'] = $data['BlockRequestForm']['case_summary'];
            $caseInfo['created_by'] = $session->get('userId');
            $caseInfo['case_status'] = array_search("Pending",Yii::$app->mycomponent->getMasterData('master_status_status'));
            
            if(isset($data['BlockRequestForm']['master_social_media_id']) && count($data['BlockRequestForm']['master_social_media_id']) > 0)
            { 
                for($i=0;$i<=count($data['BlockRequestForm']['url'])-1;$i++)
                { 
                    if(!empty($data['BlockRequestForm']['master_social_media_id'][$i]))
                    {
                        $caseInvolvedURL[$i]["master_social_media_id"]  = $data['BlockRequestForm']['master_social_media_id'][$i] ? $data['BlockRequestForm']['master_social_media_id'][$i] : 0;
                        $caseInvolvedURL[$i]["url"]  = $data['BlockRequestForm']['url'][$i] ? $data['BlockRequestForm']['url'][$i] : "NULL";
                        $caseInvolvedURL[$i]['created_by'] = $session->get('userId');
                        $masterURLInvolvedId++;
                    }
                    
                }
            }
            if(isset($data['BlockRequestForm']['new_master_social_media_id']) && count($data['BlockRequestForm']['new_master_social_media_id']) > 0)
            {  $newCaseInvolvedURLId = 0;
                if($masterURLInvolvedId > 0)
                {
                    $newCaseInvolvedURLId = $masterURLInvolvedId;
                }
                for($i=0;$i<=count($data['BlockRequestForm']['new_master_social_media_id'])-1;$i++)
                { 
                    if(!empty($data['BlockRequestForm']['new_master_social_media_id'][$i]) && !empty($data['BlockRequestForm']['new_url'][$i]))
                    { 
                        $caseInvolvedURL[$newCaseInvolvedURLId]["master_social_media_id"]  = $data['BlockRequestForm']['new_master_social_media_id'][$i] ? $data['BlockRequestForm']['new_master_social_media_id'][$i] : 0;
                        $caseInvolvedURL[$newCaseInvolvedURLId]["url"]  = $data['BlockRequestForm']['new_url'][$i] ? $data['BlockRequestForm']['new_url'][$i] : "NULL";
                        $caseInvolvedURL[$newCaseInvolvedURLId]['created_by'] = $session->get('userId');
                        
                    }
                    
                }
                
            }
            
            //echo json_encode($caseInfo).'<br>';
            //echo json_encode($caseStatusSuspek).'<br>';
            //echo json_encode($caseInvolvedURL).'<br>';
            //echo json_encode($newOffences).'<br>';exit;
            
            $caseInfoResponse = $client->createRequest()
            ->setFormat(Client::FORMAT_URLENCODED)
            ->setMethod('POST')
            ->setUrl($this->_url_procedure.'case_info')
            ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass,"Accept" => "*/*"])
            //->setData(["caseInfo" => json_encode($caseInfo),"caseStatusSuspek" => json_encode($caseStatusSuspek),"caseInvolvedURL" => json_encode($caseInvolvedURL),"newOffences" => json_encode($newSelectedOffences),"deleteOffences" => json_encode($prevDeletedOffences)])
            ->setData(["caseInfo" => json_encode($caseInfo),"caseStatusSuspek" => json_encode($caseStatusSuspek),"caseInvolvedURL" => json_encode($caseInvolvedURL),"offences" => json_encode($newOffences)])
            ->send(); 
            if($caseInfoResponse->statusCode == 200 && count($caseInfoResponse->data['records']) > 0)
                { 
                    Yii::$app->session->addFlash('success','Successfully created reopend case infomation.');
                    return $this->redirect('../permohonan/block-request-list');
                }
                else{
                    Yii::$app->session->addFlash('failed','Reopen case infomation not inserted successfully.');
                    return $this->redirect(Yii::$app->request->referrer);
                }
            
		}    
        if(count($responses->data['records']) > 0)
        {
            $mediaSocialResponse = $responses->data['records'][0];
        }
        return $this->render('blockrequest/reopenblockrequest', ['model'=>$model,"mediaSocialResponse" => $mediaSocialResponse,"offences" => $filterOffenceResponse,"masterSocialMedia" => $masterSocialMedia]);
       
        
    }

    /**
     * Displays MNTL - MNP search page.
     *
     * @return string
     */
    public function actionSearch()
    {
        $client = new Client();
        $model = new SearchForm();
        $telcoResponse = array();
        $MntlResponse = array();
        $returnResponse = array();
        $returnResponse['success'] = "false";
        
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()) && $model->validate()) { 
            $client = new Client();
            $data = Yii::$app->request->post();
            $telcoResponse = $client->createRequest()
                ->setFormat(Client::FORMAT_URLENCODED)
                ->setMethod('GET')
                ->setUrl($this->_urlCrawler . 'func.telco.php?search=' . $data['SearchForm']['phone_number'] . '&mnp=nomnp')
                ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
                ->send();
            if(isset($telcoResponse->data) && count($telcoResponse->data) > 0)
            {
                $MntlResponse = $client->createRequest()
                ->setFormat(Client::FORMAT_URLENCODED)
                ->setMethod('GET')
                ->setUrl($this->_urlCrawler . 'func.mntl.php?search=auto&value=CMS12345')
                ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
                ->send();
               
            } 
            if(isset($telcoResponse->data) && count($telcoResponse->data) > 0) 
            {   $returnResponse['success'] = "true";
                $returnResponse['telco_info']  =  $telcoResponse->data[0];
                $returnResponse['telco_info']['ported_to']  =  $telcoResponse->data[0]['ported-to'];
                $returnResponse['telco_info']['telco_info']  =  $telcoResponse->data[0]['telco-info'];
            } 
            if(isset($MntlResponse->data) && count($MntlResponse->data) > 0) 
            { 
                $days = (strtotime(date('Y-m-d')) - strtotime($MntlResponse->data[0]['active_date'])) / (60 * 60 * 24);
                $returnResponse['mntl_info']  =  $MntlResponse->data[0];
                $returnResponse['mntl_info']['days_count_filter'] = "false";
                if(isset($days) && !empty($days) && $days <= 90)
                {
                    $returnResponse['mntl_info']['days_count_filter'] = "true";
                }
            } 
            return $this->asJson($returnResponse);
           
        }
        return $this->render('mntl/search', ['model' => $model]);
    }


    /**
     * Displays MNTL list page.
     *
     * @return string
     */
    public function actionMntlList()
    { 
        $session = Yii::$app->session;
        $case_status_values = "";
        $case_status_values .= array_search("Pending",Yii::$app->mycomponent->getMasterData('master_status_status')).",".array_search("Rejected",Yii::$app->mycomponent->getMasterData('master_status_status')).",".array_search("Closed",Yii::$app->mycomponent->getMasterData('master_status_status')).",".array_search("Reopen",Yii::$app->mycomponent->getMasterData('master_status_status'));
        $client = new Client();
        $thisyear = date("Y");
        $responses = $client->createRequest()
            ->setFormat(Client::FORMAT_URLENCODED)
            ->setMethod('GET')
            //->setUrl($this->_urlCrawler . 'func.mntl.php?search=list&max=10&page=1&order=DESC&year=' . $thisyear)
            ->setUrl($this->_url . 'case_info?filter=requestor_ref,eq,'.$session->get('userId').'&filter=case_status,in,'.$case_status_values.'&filter=master_case_info_type_id,eq,3&join=case_info_mntl,tipoff&order=id,desc')
            ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
            ->send();
        return $this->render('mntl/mntlList', ['responses' => $responses]);
    }



    // Edit existing LEA user
	public function actionLeaEdit()
	{ 
        $this->layout =  'main';
		$model = new LeaForm();
        $client = new Client();
		$session = Yii::$app->session;
        $session->get('userId');
        $userResponse = array();
        $masterEmailType = array();
        $masterUnitName = array();
        $masterOrganizationName = array();
        $masterBranch = array();
        $masterState = array();
        $masterDistrict = array();
        $masterPostcode = array();
        $masterEmailType = Yii::$app->mycomponent->getMasterData('email_type');
        $masterUnitName = Yii::$app->mycomponent->getMasterData('master_department');
        $masterOrganizationName = Yii::$app->mycomponent->getMasterData('master_organization');
        $masterBranch = Yii::$app->mycomponent->getMasterData('master_branch');
        $masterState = Yii::$app->mycomponent->getMasterData('master_state');
        $masterDistrict = Yii::$app->mycomponent->getMasterData('master_district');
        $masterPostcode = Yii::$app->mycomponent->getMasterData('master_postcode');
        $response = $client->createRequest()
            ->setFormat(Client::FORMAT_URLENCODED)
            ->setMethod('GET')
            //->setUrl($this->_url . 'case_info?filter=requestor_ref,eq,'.$session->get('userId').'&filter=case_status,in,1,2,3&join=master_status&order=id,desc')
            ->setUrl($this->_url . 'user?filter=id,eq,'.$session->get('userId'))
            ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
            ->send();
        if(isset($response) && count($response->data['records']) > 0)
        {
            $userResponse = $response->data['records'][0];
              
        }    
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) { 
            $session = Yii::$app->session;

			$data = Yii::$app->request->post();
            $telegram_verification = 0;
            $mobile_verification = 0;
            if(isset($data['LeaForm']['notification'][0]) &&  $data['LeaForm']['notification'][0] == "1")
              {
                $telegram_verification = 1;
              }
            if(isset($data['LeaForm']['notification'][1]) &&  $data['LeaForm']['notification'][1] == "2")
              {
                $mobile_verification = 1;
              }
			$responses = $client->createRequest()
				->setFormat(Client::FORMAT_URLENCODED)
				->setMethod('PUT')
				->setUrl($this->_url . 'user/'.$session->get('userId'))
				->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
				->setData([
					"email" => $data['LeaForm']['email'],
					"email_type" => $data['LeaForm']['email_type'],
					"fullname" => $data['LeaForm']['name'],
					"ic_no" => $data['LeaForm']['icno'],
					"department" => $data['LeaForm']['unit_name'],
					"organization" => $data['LeaForm']['organization_name'],
					"branch" => $data['LeaForm']['branch'],
					"master_district_id" => $data['LeaForm']['district'],
					"master_postcode_id" => $data['LeaForm']['postcode'],
					"master_state_id" => $data['LeaForm']['state'],
					"mobile_no" => $data['LeaForm']['mobile_no'],
					"office_phone_no" => $data['LeaForm']['office_phone_no'],
					"telegram_id" => $data['LeaForm']['telegram_id'],
                    "telegram_verification" => $telegram_verification,
                    "mobile_verification" => $mobile_verification,
                    "updated_by" => $session->get('userId')
				])
				->send();
			if ($responses->isOk) {
				Yii::$app->session->addFlash('success', 'Successfully updated profile.');
                return $this->redirect('../dashboard/index');
			}
		} 
        $notificationInfo = array();
        if(isset($userResponse['mobile_verification']) && $userResponse['mobile_verification'] == 1)
        {
            $notificationInfo[] = 1;

        }
        if(isset($userResponse['telegram_verification']) && $userResponse['telegram_verification'] == 1)
        {
            $notificationInfo[] = 2;

        }
        $userResponse['notificationInfo'] = $notificationInfo;
        return $this->render('/permohonan/lea/leaedit', ['model' => $model,"userResponse" => $userResponse,"masterEmailType" => $masterEmailType,"masterUnitName" => $masterUnitName,"masterOrganizationName" => $masterOrganizationName,"masterBranch" => $masterBranch,"masterState" => $masterState,"masterDistrict" => $masterDistrict,"masterPostcode" => $masterPostcode]);
	}


    /****
     * 
     * Download Garis Panduan document
     */
    public function actionGuidelines()
    { 
        $name = "Manual-FMS-v1.pdf";
        $guidelinesFile = \Yii::getAlias('@guidelines')."". $name;
        
        $pdf = file_get_contents($guidelinesFile);
        header('Content-Type: application/pdf');
        header('Cache-Control: public, must-revalidate, max-age=0'); // HTTP/1.1
        header('Pragma: public');
        header('Content-Length: '.strlen($pdf));
        header('Content-Disposition: inline; filename="'.basename($guidelinesFile).'";');
        flush(); 
        echo $pdf;
        }

    /****
     * 
     * About CMS view page
     */
    public function actionAboutcms()
    { 
        return $this->render('/permohonan/lea/aboutcms');
    }
    
    /****
     * 
     * Download Garis Panduan document
     */
    public function actionCheckloporanno()
    {
        $responseInfo['message'] = 'failed';
        $laporanPoliceNoCount = 0;
        $masterResult = array();
        $data = Yii::$app->request->post();
        //echo $data['laporan_police'];exit;
        $client = new Client();
        $responses = $client->createRequest()
            ->setFormat(Client::FORMAT_URLENCODED)
            ->setMethod('GET')
            ->setUrl($this->_url . 'case_info?filter=report_no,eq,'.$data['laporan_police'].'&size=1')
            ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
            ->send();
        if(count($responses->data['records']) > 0){ $laporanPoliceNoCount = count($responses->data['records']);}
        $response = array();
        if($laporanPoliceNoCount > 0)
        {
            $responseInfo['status'] = 200;
            $responseInfo['strlength'] = strlen($responses->data['records'][0]['report_no']);
            $responseInfo['message'] = 'success';
            $responseInfo['result'] = "Laporan Police number already exists.";
            
        }
        else{
            $responseInfo['message'] = 'failed';
            $responseInfo['status'] = 200;
            $responseInfo['result'] = "Laporan Police number not exists.";
        }
        return $this->asJson($responseInfo);
    }

    /****
     * 
     * Download Garis Panduan document
     */
    public function actionCheckWhiteListDomain()
    {
        $responseInfo['message'] = 'failed';
        $domainCount = 0;
        $masterResult = array();
        $data = Yii::$app->request->post();
        $domain = $this->find_occurence_from_end($data['email'], ".", 2);
        //echo $data['laporan_police'];exit;
        $client = new Client();
        $responses = $client->createRequest()
            ->setFormat(Client::FORMAT_URLENCODED)
            ->setMethod('GET')
            ->setUrl($this->_url . 'email_domain_whitelist?filter=name,eq,'.$domain.'&size=1')
            ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
            ->send();
        if(count($responses->data['records']) > 0){ $domainCount = count($responses->data['records']);}
        $response = array();
        //echo "123<pre>";print_r($responses->data['records']);exit;
        if($domainCount > 0)
        {
            $responseInfo['status'] = 200;
            $responseInfo['strlength'] = strlen($responses->data['records'][0]['name']);
            $responseInfo['message'] = 'success';
            $responseInfo['result'] = "Valid domain";
            
        }
        else if(strlen($domain) == 0)
        {
            $responseInfo['message'] = 'failedempty';
            $responseInfo['strlength'] = 0;
            $responseInfo['status'] = 200;
            $responseInfo['result'] = "Invalid domain";
        }
        else{
            $responseInfo['message'] = 'failed';
            $responseInfo['strlength'] = 0;
            $responseInfo['status'] = 200;
            $responseInfo['result'] = "Invalid domain";
        }
        return $this->asJson($responseInfo);
    }

    public function find_occurence_from_end($haystack, $needle, $num) {
        $actual = $haystack;
       
           for ($i=1; $i <=$num ; $i++) {
       
               # first loop return position of needle
               if($i == 1) {
                   $pos = strrpos($haystack, $needle);
               }
       
               # subsequent loops trim haystack to pos and return needle's new position
               if($i != 1) {
       
                   $haystack = substr($haystack, 0, $pos);
                   $pos = strrpos($haystack, $needle);
                   $realString = substr($actual,$pos);
       
               }
       
           }
       
           return $realString;
       
       }
    

}
