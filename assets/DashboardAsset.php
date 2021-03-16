<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class DashboardAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/styles-admin.css',
        'css/styles-ui-kit.css',
        'css/styles.css',
        'css/dataTables.bootstrap4.min.css',
        
        
        
        

    ];


    public $js = [
        /*'js/jquery.min.js',
        'js/jquery-3.5.1.slim.min.js',*/
        'js/bootstrap.bundle.min.js',
        'js/scripts.js',
      //  'js/all.min.js',
        'js/Chart.min.js',
        'js/chart-area-demo.js',
        'js/chart-bar-demo.js',
        'js/api.js',
       // 'js/chart-pie-demo.js',
        
       'js/jquery.dataTables.min.js',
        'js/dataTables.bootstrap4.min.js',
        'js/datatables-demo.js',
        
        
        
        
        
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
