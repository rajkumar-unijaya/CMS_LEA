<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use yii\httpclient\Client;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class MasterDataController extends Controller
{
    private $_url = null;
    private $_DFHeaderKey = null;
    private $_DFHeaderPass = null;
    
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex()
    {
         $this->_url = \Yii::$app->params['DreamFactoryContextURL'];
         $this->_DFHeaderKey = \Yii::$app->params['DreamFactoryHeaderKey'];
         $this->_DFHeaderPass = \Yii::$app->params['DreamFactoryHeaderPass'];
         $client = new Client();
         $masterDataGroupValues =  array();
         $masterDataGroupInfo =  array();
         $masterDataArrangedInfo =  array();
         
         $client = new Client();
         $masterDataGroupValues = $client->createRequest()
         ->setFormat(Client::FORMAT_URLENCODED)
         ->setMethod('GET')
         ->setUrl($this->_url . 'get_master_data_group')
         ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
         ->send();
         $masterDataGroupInfo = $client->createRequest()
         ->setFormat(Client::FORMAT_URLENCODED)
         ->setMethod('GET')
         ->setUrl($this->_url.'master_data')
         ->setHeaders([$this->_DFHeaderKey => $this->_DFHeaderPass])
         ->send();
         foreach($masterDataGroupValues->data['records'] as $key1 => $masterDataGroup):
                    $i = 0;
                 foreach($masterDataGroupInfo->data['records'] as $key => $masterDataGroupInfoVal):
                    if($masterDataGroup['datagroup'] == $masterDataGroupInfoVal['datagroup'])
                    {
                        $masterDataArrangedInfo[$masterDataGroup['datagroup']][$i]['id'] =  $masterDataGroupInfoVal['data_id'];
                        $masterDataArrangedInfo[$masterDataGroup['datagroup']][$i]['name'] =  $masterDataGroupInfoVal['name'];
                        $i++;
                    }
                
                 endforeach;   
            
         endforeach;
         $path =  \Yii::getAlias('@app')."/web/uploads/master-data/";
         $fp = fopen($path.'results.json', 'w');
         if(fwrite($fp, json_encode($masterDataArrangedInfo, JSON_PRETTY_PRINT)) != false)
         {
            fclose($fp);
            echo "import master data succesfully.";
         }
         else{
             echo "import master data failed.";
         }
        return ExitCode::OK;
    }
}
