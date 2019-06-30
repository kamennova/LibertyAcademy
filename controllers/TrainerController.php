<?php

namespace app\controllers;

use app\models\event\EventSearch;
use app\models\TrainerCountry;
use app\models\TrainerLanguage;
use app\models\TrainerService;
use Yii;
use yii\base\DynamicModel;
use yii\db\StaleObjectException;
use yii\helpers\Html;
use yii\base\Exception;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

use app\models\Trainer;
//use app\models\TrainerGallery;
//use app\models\TrainerPhoto;
use app\models\RegisterTrainer;
use app\models\LoginForm;
use app\models\trainer\TrainerCondition;

use app\models\Article;
use app\models\article\ArticleSearch;

use app\models\Event;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/** @noinspection PhpUndefinedClassInspection */


/**
 * TrainerController implements the CRUD actions for Trainer model.
 */
class TrainerController extends Controller
{
    /**
     * @inheritdoc
     */

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'update', 'view', 'delete'],
                'rules' => [
                    [
                        'actions' => ['logout', 'update', 'view', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $condition = new TrainerCondition();
        $condition->load(Yii::$app->request->get());

        return $this->render('index', [
                'provider' => $condition->trainerSearch(),
                'thumbsProvider' => $condition->formQuery(),
                'condition' => $condition,
            ]
        );
    }


    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionProfile($id)
    {
        if (!$trainer = Trainer::findOne($id)) {
            throw new NotFoundHttpException();
        }

        $eventQuery = Event::find()->where(['trainer_id' => $id]);
        $events = $eventQuery->orderBy('start')->limit(3)->all();
        $eventsNumber = $eventQuery->count();

        $upcomingEvent = Event::find()->where(['trainer_id' => $id])->orderBy(['start' => SORT_ASC])->one();

//        $photos = TrainerPhoto::find()->where(['trainer_id' => $id])->limit(3)->all();

        $articleQuery = Article::find()->where(['trainer_id' => $id]);
        $articles = $articleQuery->orderBy('date')->limit(3)->all();
        $articlesNumber = $articleQuery->count();

        /*if ($photos) {
            foreach ($photos as $photo) {
                $thumbs[] = Html::img($photo->src);
            }
        } else {
            $photo = null;
            $thumbs = null;
        }*/

        return $this->render('profile',
            [
                'trainer' => $trainer,
                'events' => $events,
                'articles' => $articles,
                'upcomingEvent' => $upcomingEvent,
//                'photo' => $photo,
//                'thumbs' => $thumbs,
                'eventsNumber' => $eventsNumber,
                'articlesNumber' => $articlesNumber
            ]);
    }

    /**
     * @return string
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionMyevents()
    {
        $id = Yii::$app->user->id;
        if (!$model = $this->findModel($id)) {
            throw new NotFoundHttpException();
        };

        $thumbsPick = Event::find()
            ->select('thumb')
            ->where('thumb <> ""')
            ->limit(3)
            ->asArray()
            ->column();

        $eventSearchModel = new EventSearch();
        $eventDataProvider = $eventSearchModel->search(Yii::$app->request->get());

        return $this->render('myevents',
            [
                'thumbsPick' => $thumbsPick,
                'model' => $model,
                'eventDataProvider' => $eventDataProvider,
                'eventSearchModel' => $eventSearchModel,
            ]);
    }

    /**
     * @return string
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionMyarticles()
    {
        $id = Yii::$app->user->id;
        if (!$model = $this->findModel($id)) {
            throw new NotFoundHttpException();
        }

        $thumbsPick = Article::find()
            ->select('thumb')
            ->where('thumb <> ""')
            ->limit(3)
            ->asArray()
            ->column();

        $articleSearchModel = new ArticleSearch();
        $articleDataProvider = $articleSearchModel->search(Yii::$app->request->get());

        return $this->render('myarticles',
            [
                'model' => $model,
                'articleDataProvider' => $articleDataProvider,
                'articleSearchModel' => $articleSearchModel,
                'thumbsPick' => $thumbsPick
            ]);
    }

    /**
     * Displays a single Trainer model.
     * @param integer $id
     * @return mixed
     * @throws \yii\db\Exception
     * @throws \yii\web\ForbiddenHttpException
     * @throws \yii\web\NotFoundHttpException
     * @throws \yii\base\InvalidParamException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $errors = '';

        if ($model->load(Yii::$app->request->post())) {

            TrainerService::deleteAll(['trainer_id' => $model->id]);

            foreach ($model->services as $service) {

                $trainerService = new TrainerService();
                $trainerService->trainer_id = $model->id;
                $trainerService->service_id = $service->id;

                if (!$trainerService->save()) {
                    $errors .= Html::errorSummary($trainerService);
                };
            }

            if ($model->imageFile) {
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                $model->thumb = '/img/trainers/' . $model->imageFile->baseName . '.' . $model->imageFile->extension;
            }

            if ($model->galleryFiles) {
                $model->galleryFiles = UploadedFile::getInstances($model, 'galleryFiles');
            }

            $t = Yii::$app->db->beginTransaction();

            try {
                if ($model->save()) {

                    if ($model->imageFile && !($model->imageFile->saveAs(substr($model->thumb, 1)))) {
                        throw new Exception('Не удалось сохранить файл.');
                    }

                    if ($model->galleryFiles) {
                        $model->galleryFiles = UploadedFile::getInstances($model, 'galleryFiles');

                        foreach ($model->galleryFiles as $file) {
                            $path = 'img/trainers/gallery/' . $file->baseName . '.' . $file->extension;
                            $file->saveAs($path);

                            $image = new TrainerGallery();
                            $image->src = '/' . $path;
                            $image->trainer_id = $model->id;
                            $image->save();
                        }
                    }

                    $t->commit();
                    return $this->redirect(['profile', 'id' => $model->id]);
                }
            } catch (Exception $e) {
            }
            $t->rollBack();
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }

    public function actionRegister()
    {
        $model = new DynamicModel(['no_bits', 'no_violence', 'no_sports']);
        $model->addRule(['no_bits'], 'required', ['message' => 'A teacher at Liberty Academy must not use bits.', 'requiredValue' => 1]);;
        $model->addRule(['no_violence'], 'required', ['message' => 'A teacher at Liberty Academy must not punish a horse.', 'requiredValue' => 1]);;
        $model->addRule(['no_sports'], 'required', ['message' => 'A teacher at Liberty Academy must not take part in traditional horse sports.', 'requiredValue' => 1]);;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                return $this->redirect('registerpersonal');
            }
        }

        return $this->render('registerrules', [
            'model' => $model
        ]);
    }


    public function actionRegisterpersonal()
    {
        $model = new RegisterTrainer();

        if ($model->load(Yii::$app->request->post())) {

            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            $model->galleryFiles = UploadedFile::getInstances($model, 'galleryFiles');

            if ($model->upload()) {

                if ($model->imageFile) {
                    $thumbSrc = '/img/teacher/thumb/' . $model->imageFile->baseName . '.' . $model->imageFile->extension;
                } else {
                    $thumbSrc = null;
                }

                if ($model->galleryFiles) {

                    $gallery = array();

                    foreach ($model->galleryFiles as $galleryFile) {
                        $gallery[] = '/img/teacher/gallery/' . $galleryFile->baseName . '.' . $galleryFile->extension;
                    }
                } else {
                    $gallery = null;
                }

                Yii::$app->session->set('register', $model->getAttributes());
                Yii::$app->session->set('registerAdd', [
                    'services' => $model->services,
                    'languages' => $model->languages,
                    'ammunition' => $model->ammunition,
                    'gallery' => $gallery,
                    'thumb' => $thumbSrc
                ]);

                return $this->render('registercontact', [
                    'model' => $model
                ]);
            }

        }

        return $this->render('registerpersonal', [
            'model' => $model
        ]);
    }

    public function actionRegistercontact()
    {
        $model = new RegisterTrainer();

        if (Yii::$app->request->isPost) {
            $model->setAttributes(Yii::$app->session->get('register'));
            $model->setAttributes(Yii::$app->session->get('registerAdd'));
            $model->is_admin = 0;
            $model->load(Yii::$app->request->post());

            if ($model->validate(['teachCountries', 'site', 'soc_fb', 'soc_tw', 'soc_inst', 'email', 'homecountry_id'])) {
                $model->save();

                foreach ($model->languages as $language) {
                    $trainerLanguage = new TrainerLanguage();
                    $trainerLanguage->trainer_id = $model->id;
                    $trainerLanguage->lang_id = $language;
                    $trainerLanguage->save();
                }

                foreach ($model->teachCountries as $country) {
                    $teachCountry = new TrainerCountry();
                    $teachCountry->trainer_id = $model->id;
                    $teachCountry->country_id = $country;
                    $teachCountry->save();
                }

                foreach ($model->services as $service) {
                    $trainerService = new TrainerService();
                    $trainerService->trainer_id = $model->id;
                    $trainerService->service_id = $service;
                    $trainerService->save();
                }

//                if ($gallery) {
//                    foreach ($model->gallery as $galleryPhoto) {
//                        $galleryPhoto = new TrainerGallery();
//                        $galleryPhoto->trainer_id = $model->id;
//                        $galleryPhoto->src = Yii::getAlias('@webroot') . '/img/teacher/gallery/' . $galleryPhoto->baseName . '.' . $galleryPhoto->extension;
//                        $galleryPhoto->save();
//                    }
//                }

                return $this->redirect(['login']);
            }
        }

        return $this->render('registercontact', ['model' => $model]);
    }

    public function actionError()
    {
        return $this->render('error');
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }


    /**
     * Deletes an existing Trainer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws \Exception
     */
    public function actionDelete($id)
    {
        // language delete
        $trainerLanguages = TrainerLanguage::find()->where(['trainer_id' => $id])->all();
        foreach ($trainerLanguages as $language) {
            try {
                $language->delete();
            } catch (StaleObjectException $e) {
            } catch (\Throwable $e) {
            }
        }

        // services delete
        $trainerServices = TrainerService::find()->where(['trainer_id' => $id])->all();
        foreach ($trainerServices as $service) {
            try {
                $service->delete();
            } catch (StaleObjectException $e) {
            } catch (\Throwable $e) {
            }
        }

        // delete teach countries
        $trainerCountries = TrainerCountry::find()->where(['trainer_id' => $id])->all();
        foreach ($trainerCountries as $country) {
            try {
                $country->delete();
            } catch (StaleObjectException $e) {
            } catch (\Throwable $e) {
            }
        }

        // delete articles
//        $trainerCountries = TrainerCountry::find()->where(['trainer_id' => $id])->all();
//        foreach ($trainerCountries as $country){
//            $country->delete();
//        }

        try {
            $this->findModel($id)->delete();
        } catch (StaleObjectException $e) {
        } catch (ForbiddenHttpException $e) {
        } catch (NotFoundHttpException $e) {
        } catch (\Throwable $e) {
        }

        return $this->redirect(['/site/index']);
    }

    /**
     * Finds the Trainer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Trainer the loaded model
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (Yii::$app->user->id !== (int)$id) {
            throw new ForbiddenHttpException('Access denied');
        }

        if (($model = Trainer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

/*
public function actionGallery($id)
    {
        if (!$trainer = Trainer::findOne($id)) {
            throw new NotFoundHttpException();
        }

        $photos = TrainerPhoto::find()->where(['trainer_id' => $id])->limit(3)->all();

        if ($photos) {
            foreach ($photos as $photo) {
                $thumbs[] = Html::img($photo->src);
            }
        } else {
            $photo = null;
            $thumbs = null;
        }

        return $this->render('gallery.php',
            [
                'trainer' => $trainer,
                'photo' => $photo,
                'thumbs' => $thumbs,
            ]);
    }

public function actionChangepass()
{
    $id = Yii::$app->user->id;
    $model = $this->findModel($id);

    return $this->render('changepass', [
        'model' => $model
    ]);

}


    @param $id
     * @return string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     * @throws \yii\web\ForbiddenHttpException
     * @throws \yii\base\InvalidParamException

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->imageFile) {
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                $model->thumb = '/img/trainers/' . $model->imageFile->baseName . '.' . $model->imageFile->extension;
            }

            if ($model->galleryFiles) {
                $model->galleryFiles = UploadedFile::getInstances($model, 'galleryFiles');
            }

            $t = Yii::$app->db->beginTransaction();

            try {
                if ($model->save()) {

                    if ($model->imageFile && !$model->imageFile->saveAs(substr($model->thumb, 1))) {
                        throw new Exception('Не удалось сохранить файл.');
                    }

                    if ($model->galleryFiles) {
                        $model->galleryFiles = UploadedFile::getInstances($model, 'galleryFiles');

                        foreach ($model->galleryFiles as $file) {
                            $path = 'img/trainers/gallery/' . $file->baseName . '.' . $file->extension;
                            $file->saveAs($path);

                            $image = new TrainerGallery();
                            $image->src = '/' . $path;
                            $image->trainer_id = $model->id;
                            $image->save();
                        }
                    }

                    $t->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } catch (Exception $e) {
            }
            $t->rollBack();
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
 */