<?php 
namespace app\components;


use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
 
class MasterDataComponent extends Component
{
 public function statusSuspect()
 {
  return [
        "Tiada maklumat mengenai suspek",
        "Identiti suspek(Nama dan KPT) sudah dikenalpasti, tetapi belum ditahan",
        "Suspek telah ditahan",
        "Suspek dibebaskan dengan jaminan",
        "Lain-lain sila nyatakan"
  ];
 }
 
}
?>