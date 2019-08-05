<?php

namespace app\models;

use Yii;
use yii\db\StaleObjectException;
use yii\helpers\Html;

/**
 * This is the model class for table "article".
 * @property integer $id
 * @property integer $trainer_id
 * @property string $title
 * @property string $content
 * @property string $date
 * @property integer $lang_id
 * @property string $thumb
 * @property boolean $visibility
 *
 * @property mixed $tags
 * @property mixed $language
 * @property \yii\db\ActiveQuery $trainer
 * @property mixed $comments
 * @property mixed $articleTag
 * @property mixed $articleComment
 */
class Article extends \yii\db\ActiveRecord
{

    public $imageFile;

    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content'], 'required'],
            [['title', 'content', 'thumb'], 'string'],
            ['lang_id', 'integer'],
            ['visibility', 'boolean'],
            ['imageFile', 'file', 'extensions' => 'png, jpg, jpeg'],
            ['title', 'filter', 'filter' => '\yii\helpers\Html::encode'],
            ['content', 'filter', 'filter' => '\yii\helpers\HtmlPurifier::process'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => 'Title',
            'content' => 'Content',
            'lang_id' => 'Language'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getTrainer()
    {
        return $this->hasOne(Trainer::class, ['id' => 'trainer_id']);
    }

    public function getLanguage()
    {
        return $this->hasOne(Language::class, ['id' => 'lang_id']);
    }

    public function getArticleTag()
    {
        return $this->hasMany(ArticleTag::class, ['article_id' => 'id']);
    }

    public function getArticleComment()
    {
        return $this->hasMany(Comment::class, ['article_id' => 'id']);
    }

    public function getTags()
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])
            ->via('articleTag');
    }

    public function getComments()
    {
        return $this->hasMany(Comment::class, ['article_id' => 'id']);
    }

    public static function find()
    {
        return new TrainerQuery(get_called_class());
    }

    public function safeDelete()
    {
        Comment::deleteAll(['article_id' => $this->id]);
        ArticleTag::deleteAll(['article_id' => $this->id]);

        if ($this->thumb !== '' && $this->thumb !== null &&
            file_exists(Yii::getAlias('@webroot') . $this->thumb)) {
            try {
                unlink(Yii::getAlias('@webroot') . $this->thumb);
            } catch (\Exception $e) {
                echo $e;
            }
        }

        try {
            $this->delete();
        } catch (StaleObjectException $e) {
        } catch (\Throwable $e) {
        }
    }
}