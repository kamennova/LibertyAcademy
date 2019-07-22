<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
//        'build/site.css',
    ];
    public $js = [
        ['build/site.js', 'position'=>View::POS_END]
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'djabiev\yii\assets\AutosizeTextareaAsset',
    ];
}