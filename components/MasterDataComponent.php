<?php 
namespace app\components;


use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
 
class MasterDataComponent extends Component
{
      public function getData()
      { 
            $resultInfo = array();
            $resultInfo = json_decode(file_get_contents(Yii::getAlias('@masterData')."results.json"),true);
            return $resultInfo;
      }
 
}
?>