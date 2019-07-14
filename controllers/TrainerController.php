<?php

namespace app\controllers;

use app\models\ChangePasswordForm;
use app\models\event\EventSearch;
use app\models\trainer\TrainerForm;
use app\models\TrainerCountry;
use app\models\TrainerLanguage;
use app\models\TrainerService;
use Yii;
use yii\base\DynamicModel;
use yii\db\StaleObjectException;
use yii\helpers\Html;
use yii\base\Exception;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

use app\models\Trainer;
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

        $upcomingEvent = Event::find()->where(['trainer_id' => $id])->orderBy(['start' => SORT_ASC])->one();

        $articleQuery = Article::find()->where(['trainer_id' => $id]);
        $articles = $articleQuery->orderBy('date')->limit(3)->all();

        return $this->render('profile',
            [
                'trainer' => $trainer,
                'events' => $events,
                'articles' => $articles,
                'upcomingEvent' => $upcomingEvent,
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
        $eventSearchModel->trainer_id = $id;
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
        $articleSearchModel->trainer_id = $id;
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
     * @return mixed
     * @throws \yii\web\NotFoundHttpException
     * @throws \yii\base\InvalidParamException
     */
    public function actionUpdate()
    {
        $id = Yii::$app->user->id;
        $model = $this->findModelForm($id);
        $errors = '';

        if ($model->load(Yii::$app->request->post())) {

            $model->update_links();

            TrainerService::deleteAll(['trainer_id' => $id]);

            foreach ($model->services as $service) {
                $ts = new TrainerService();
                $ts->trainer_id = $id;
                $ts->service_id = $service;

                if (!$ts->save()) {
                    $errors .= Html::errorSummary($ts);
                };
            }

            TrainerLanguage::deleteAll(['trainer_id' => $id]);

            foreach ($model->languages as $lang) {
                $tl = new TrainerLanguage();
                $tl->trainer_id = $id;
                $tl->lang_id = $lang;

                if (!$tl->save()) {
                    $errors .= Html::errorSummary($tl);
                };
            }

            TrainerCountry::deleteAll(['trainer_id' => $id]);

            foreach ($model->teachCountries as $country) {
                $tc = new TrainerCountry();
                $tc->trainer_id = $id;
                $tc->country_id = $country;

                if (!$tc->save()) {
                    $errors .= Html::errorSummary($tc);
                };
            }

            if ($model->upload()) {
                if ($model->imageFile) {
                    $model->imageFile->saveAs(Yii::getAlias('@webroot') . $model->thumb);
                }
            }

            try {
                if ($model->save(false)) {
                    return $this->redirect(['profile', 'id' => $model->id]);
                }
            } catch (Exception $e) {
                print_r($model->errors);
                echo $e;
                echo $errors;
            }
        }

        return $this->render('update', [
            'model' => $model
        ]);
    }

    public function actionRegister()
    {
        $model = new DynamicModel(['needs_first', 'no_violence', 'choice']);
        $model->addRule(['needs_first'], 'required', [
            'message' => 'A teacher at Liberty Academy must respect horse`s needs.', 'requiredValue' => 1]);
        $model->addRule(['no_violence'], 'required', [
            'message' => 'A teacher at Liberty Academy must not punish a horse or use ammunition the way it causes pain.',
            'requiredValue' => 1]);
        $model->addRule(['choice'], 'required', [
            'message' => 'The core principle of Liberty training is to let the horse choose for himself.',
            'requiredValue' => 1]);

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

            if ($model->upload()) {
                Yii::$app->session->set('register', $model->getAttributes());
                Yii::$app->session->set('registerAdd', [
                    'services' => $model->services,
                    'languages' => $model->languages,
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

    /**
     * @return string|\yii\web\Response
     */
    public function actionRegistercontact()
    {
        $model = new RegisterTrainer();

        if (Yii::$app->request->isPost) {
            $model->setAttributes(Yii::$app->session->get('register'));
            $model->setAttributes(Yii::$app->session->get('registerAdd'));
            $model->is_admin = 0;
            $model->load(Yii::$app->request->post());

            if ($model->validate(['teachCountries', 'site', 'soc_fb', 'soc_tw', 'soc_inst', 'email', 'homecountry_id'])) {

                $model->update_links();

                try {
                    $hash = Yii::$app->getSecurity()->generatePasswordHash($model->pass);
                    $model->pass = $hash;
                } catch (Exception $e) {
                    echo $e;
                }

                $model->save(false);

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
     * @return mixed
     * @throws \Exception
     */
    public function actionDelete()
    {
        $id = Yii::$app->user->id;

        TrainerLanguage::deleteAll(['trainer_id' => $id]);
        TrainerService::deleteAll(['trainer_id' => $id]);
        TrainerCountry::deleteAll(['trainer_id' => $id]);

        $model = $this->findModel($id);

        foreach ($model->articles as $article) {
            $article->safeDelete();
        }

        Event::deleteAll(['trainer_id' => $id]);


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
        } catch (ForbiddenHttpException $e) {
        } catch (NotFoundHttpException $e) {
        } catch (\Throwable $e) {
        }

        return $this->redirect(['/site/index']);
    }

    public function actionChange_pass($id)
    {

        $model = new ChangePasswordForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $trainer = $this->findModel($id);
            $trainer->pass = Yii::$app->getSecurity()->generatePasswordHash($model->password);
            $trainer->save();

            return $this->redirect(['/site/index']);
        }

        return $this->render('change_pass', [
            'model' => $model,
        ]);
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

    /**
     * @param $id
     * @return TrainerForm|null
     * @throws NotFoundHttpException
     */
    protected function findModelForm($id)
    {
        if (($model = TrainerForm::findOne($id)) !== null) {
            $model->services = $model->getServices()->select('id')->column();
            $model->languages = $model->getLanguages()->select('id')->column();
            $model->teachCountries = $model->getTeachCountries()->select('id')->column();

            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}