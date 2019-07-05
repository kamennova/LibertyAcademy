<?php

namespace app\controllers;

use app\models\Article;
use app\models\article\ArticleCondition;
use app\models\article\ArticleForm;
use app\models\ArticleTag;
use app\models\Comment;
use app\models\CommentForm;
use Yii;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TrainerController implements the CRUD actions for Trainer model.
 */
class ArticleController extends Controller
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
        $condition = new ArticleCondition();
        $condition->load(Yii::$app->request->get());

        return $this->render('index', [
            'provider' => $condition->search(),
            'condition' => $condition,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        if (!$article = Article::findOne($id)) {
            throw new NotFoundHttpException();
        }

        $model = new CommentForm();

        if ($model->load(Yii::$app->request->post())) {

            $model->article_id = $id;
            $model->date = date('Y-m-d');

            if ($model->validate() && $model->save()) {
                return $this->refresh();
            }
        }

        return $this->render('view', [
            'article' => $article,
            'model' => $model
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidParamException
     */

    public function actionCreate()
    {
        $model = new ArticleForm();

        if ($model->load(Yii::$app->request->post())) {

            $model->trainer_id = Yii::$app->user->id;
            $model->date = date('Y-m-d');

            if ($model->upload()) {
                if ($model->imageFile) {
                    $model->imageFile->saveAs('./img/article/thumb/' . $model->imageFile->baseName . '.' . $model->imageFile->extension);
                }

                $model->save(false);
            }

            ArticleTag::deleteAll(['article_id' => $model->id]);

            foreach ($model->tags as $tag) {
                $at = new ArticleTag();
                $at->article_id = $model->id;
                $at->tag_id = $tag;

                $at->save();
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', ['model' => $model]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        if (!$model = $this->findModelForm($id)) {
            throw new NotFoundHttpException();
        }

        $errors = '';

        if ($model->load(Yii::$app->request->post())) {
            ArticleTag::deleteAll(['article_id' => $id]);

            foreach ($model->tags as $tag) {
                $at = new ArticleTag();
                $at->article_id = $model->id;
                $at->tag_id = $tag;

                if (!$at->save()) {
                    $errors .= Html::errorSummary($at) . '<br>';
                }
            }

            if($model->upload()){ // todo
                if ($model->imageFile) {
                    $model->imageFile->saveAs('./img/article/thumb/' . $model->imageFile->baseName . '.' . $model->imageFile->extension);
                }
            }

            if ($model->save(false)) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public
    function actionError()
    {
        return $this->render('/trainer/error');
    }


    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $articleComments = Comment::find()->where(['article_id' => $id])->all();

        foreach ($articleComments as $comment) {
            $comment->delete();
        }

        $this->findModel($id)->delete();

        return $this->redirect(['/trainer/myarticles']);
    }

    /**
     * @param $id
     * @return Article|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param $id
     * @return ArticleForm|null
     * @throws NotFoundHttpException
     */
    protected function findModelForm($id)
    {
        if (($model = ArticleForm::findOne($id)) !== null) {
            $model->tags = $model->getTags()->select('id')->column();

            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}