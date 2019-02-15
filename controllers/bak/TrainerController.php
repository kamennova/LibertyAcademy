<?php


namespace app\controllers;

use app\models\Trainer;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\NotFoundHttpException;

class TrainerController extends Controller
{
    public function actionIndex()
    {
        $trainers = Trainer::find()->all();


        $provider = new ActiveDataProvider([
            'query' => Trainer::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->render('index', ['provider' => $provider, 'trainers' => $trainers]);

    }

    public function actionProfile($id)
    {
        if (!$trainer = Trainer::findOne($id)) {
            throw new NotFoundHttpException();
        }

//        VarDumper::dump($trainer, 10, true); exit();

        return $this->render('profile2', ['trainer' => $trainer]);
    }
}