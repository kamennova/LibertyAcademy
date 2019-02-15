<?php
// comment out the following two lines when deployed to production
use app\models\Trainer;

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../config/web.php');

new yii\web\Application($config);

var_dump(Yii::getAlias('@webroot'));

$a = \app\models\Article::findOne(1);
\yii\helpers\VarDumper::dump($a->tags, 10, true);
exit();


//$q = Trainer::find()->select(['name'])->innerJoin('inner', 'event', 'trainer.id =  event.trainer_id')->indexBy('id')->column();
$q = Trainer::find()->select('trainer.name, trainer.id')->innerJoin('event', 'trainer.id =  event.trainer_id')->distinct()->indexBy('id')->column();
//indexBy('trainer.id')->

\yii\helpers\VarDumper::dump($q, 10, true);
