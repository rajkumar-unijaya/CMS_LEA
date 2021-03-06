<?php 
namespace app\components;


use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
 
class MasterDataComponent extends Component
{
      public function getMasterData($value = '')
      { 
            $requestVal = $value;
            $arrangedValues =  array();
            $resultInfo = array();
            $resultInfo = json_decode(file_get_contents(Yii::getAlias('@masterData')."results.json"),true);
            if(empty($requestVal) || $requestVal == '' || $requestVal = null)
            { 
                  return "Please provide master table name.";

            } 
            foreach($resultInfo[$value]  as  $val):
                  $arrangedValues[ $val['id']] =  $val['name'];
            endforeach;
            
            return $arrangedValues;
      }


      public function getMasterDataBasedOnParentId($parentId = '',$dataGroupName = '')
      { 

            $requestVal = $parentId;
            $arrangedValues =  array();
            $resultInfo = array();
            $filterResultInfo = array();
            $resultInfo = json_decode(file_get_contents(Yii::getAlias('@masterData')."results.json"),true);
            $filterResultInfo = $resultInfo[$dataGroupName];
            if(empty($requestVal) || $requestVal == '' || $requestVal = null)
            { 
                  return "Please provide master table name.";

            } 
            foreach($filterResultInfo  as  $val): 
                  if($val['parent_id'] == $parentId){ 
                        $arrangedValues[ $val['id']] =  $val['name'];
                  }
            endforeach;
            return $arrangedValues;
      }
 
}
?>