<?php

namespace app\controllers;

use app\models\event\EventCondition;
use app\models\event\EventForm;
use app\models\EventTag;
use app\models\Trainer;
use Yii;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \app\models\Event;
use yii\web\UploadedFile;

/**
 * EventController implements the CRUD actions for Event model.
 */
class EventController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $condition = new EventCondition();
        $condition->start = null;
        $condition->load(Yii::$app->request->get());

        return $this->render('index', [
            'provider' => $condition->search(),
            'condition' => $condition,
        ]);
    }

    public function actionView($id)
    {
        if (!$event = Event::findOne($id)) {
            throw new NotFoundHttpException();
        }

        return $this->render('view', [
            'event' => $event,
        ]);
    }

    public function actionCreate()
    {
        $model = new EventForm();
        $curatorName = $this->getEventCurator()->getFullName();

        if ($model->load(Yii::$app->request->post())) {

            $model->trainer_id = Yii::$app->user->id;
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if ($model->upload() &&
                ($model->thumb = '/img/event/thumb/' . $model->imageFile->baseName . '.' . $model->imageFile->extension)
                && $model->save(false)) {
                foreach ($model->tags as $tag) {
                    $et = new EventTag();
                    $et->event_id = $model->id;
                    $et->tag_id = $tag;
                    $et->save();
                }
                return $this->redirect(['event/profile', 'id' => $model->id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'curatorName' => $curatorName
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $curatorName = $this->getEventCurator()->getFullName();

        if ($model->load(Yii::$app->request->post())) {

            $model->save();

            foreach ($model->tags as $tag) {

                $at = new EventTag();
                $at->event_id = $model->id;
                $at->tag_id = $tag;

                $at->save();
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'curatorName' => $curatorName
        ]);
    }

    public
    function actionError()
    {
        return $this->render('/trainer/error');
    }

    /**
     * Deletes an existing Event model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */

    public
    function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->goBack();
    }

    /**
     * Finds the Event model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Event the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected
    function findModel($id)
    {
        if (($model = Event::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function getEventCurator()
    {
        if (Yii::$app->user->id) {
            if (($curator = Trainer::findOne(Yii::$app->user->id)) != null) {
                return $curator;
            } else throw new NotFoundHttpException('The requested page does not exist');
        } else throw new ForbiddenHttpException('Access denied');
    }
}

//    public function actionUpdate($id)
//    {
//        $model = $this->findModel($id);
//
//        if ($model->load(Yii::$app->request->post())) {
//
//            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
//            $model->thumb = 'img/trainers/' . $model->imageFile->baseName . '.' . $model->imageFile->extension;
//
//            $t = Yii::$app->db->beginTransaction();
//
//            if ($model->save()) {
//                if (!$model->imageFile->saveAs($model->thumb)) {
//                    throw new Exception('Не удалось сохранить файл.');
//                }
//                $t->commit();
//                return $this->redirect(['view', 'id' => $model->id]);
//            }
//            $t->rollBack();
//        }
//
//        return $this->render('update', [
//            'model' => $model,
//        ]);
//    }