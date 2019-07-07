<?php

namespace app\controllers;

use app\models\event\EventCondition;
use app\models\event\EventForm;
use app\models\EventTag;
use app\models\Trainer;
use Yii;
use yii\db\StaleObjectException;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \app\models\Event;
use yii\web\UploadedFile;

/**
 * EventController implements the CRUD actions for Event model.
 *
 * @property mixed $eventCurator
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
                'class' => VerbFilter::class,
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

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        if (!$event = Event::findOne($id)) {
            throw new NotFoundHttpException();
        }

        return $this->render('view', [
            'event' => $event,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionCreate()
    {
        $model = new EventForm();

        $curatorName = $this->getEventCurator()->getFullName();

        if ($model->load(Yii::$app->request->post())) {

            $model->trainer_id = Yii::$app->user->id;
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if ($model->upload()) {
                if ($model->imageFile) {
                    $model->imageFile->saveAs(Yii::getAlias('@webroot') . $model->thumb);
                }

                if ($model->save(false)) {
                    foreach ($model->tags as $tag) {
                        $et = new EventTag();
                        $et->event_id = $model->id;
                        $et->tag_id = $tag;
                        $et->save();
                    }
                    return $this->redirect(['event/view', 'id' => $model->id]);
                }
            }
        }
        return $this->render('create', [
            'model' => $model,
            'curatorName' => $curatorName
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        if (!$model = $this->findModelForm($id)) {
            throw new NotFoundHttpException();
        }

        $curatorName = $this->getEventCurator()->getFullName();

        if ($model->load(Yii::$app->request->post())) {

            if ($model->upload()) { // todo
                if ($model->imageFile) {
                    $model->imageFile->saveAs(Yii::getAlias('@webroot') . $model->thumb);
                }
            }

            if ($model->save()) {

                EventTag::deleteAll(['event_id' => $id]);

                foreach ($model->tags as $tag) {
                    $at = new EventTag();
                    $at->event_id = $model->id;
                    $at->tag_id = $tag;

                    $at->save();
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }
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
     * @throws NotFoundHttpException
     */
    public
    function actionDelete($id)
    {
        $model = $this->findModel($id);

        EventTag::deleteAll(['event_id' => $id]);

        if ($model->thumb !== '' && $model->thumb !== null) {
            try {
                unlink(Yii::getAlias('@webroot') . $model->thumb);
            } catch (\Exception $e) {
                echo $e;
            }
        }

        try {
            $model->delete();
        } catch (StaleObjectException $e) {
        } catch (NotFoundHttpException $e) {
        } catch (\Throwable $e) {
        }

        return $this->redirect(['/trainer/myevents']);
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

    /**
     * @return Trainer|null
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    protected function getEventCurator()
    {
        if (Yii::$app->user->id) {
            if (($curator = Trainer::findOne(Yii::$app->user->id)) != null) {
                return $curator;
            } else throw new NotFoundHttpException('The requested page does not exist');
        } else throw new ForbiddenHttpException('Access denied');
    }

    /**
     * @param $id
     * @return EventForm|null
     * @throws NotFoundHttpException
     */
    protected function findModelForm($id)
    {
        if (($model = EventForm::findOne($id)) !== null) {
            $model->tags = $model->getTags()->select('id')->column();
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}