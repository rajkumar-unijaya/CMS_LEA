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
        18 =>"Tiada maklumat mengenai suspek",
        19 =>"Identiti suspek(Nama dan KPT) sudah dikenalpasti, tetapi belum ditahan",
        20 =>"Suspek telah ditahan",
        21 =>"Suspek dibebaskan dengan jaminan",
        22 =>"Lain-lain sila nyatakan"
  ];
 }

 public function purposeOfApplication()
 {
  return [
        23 => "Mengenalpasti pengendali akaun/laman social / laman web",
        24 => "Maklumat lain, sila nyatakan"
  ];
 }
 public function newCase()
 {
  return [
        6 => "Bagi Pihak",
        7 => "Diri Sendiri"
  ];
 }
 
}
?>