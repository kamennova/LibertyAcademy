<?php
namespace app\models;

use yii\helpers\Html;

/**
 * This is the model class for table "page".
 * @property integer $id
 * @property $title
 * @property $content
 * @property $date
 */
class Page extends \yii\db\ActiveRecord
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
            [['title', 'content', 'thumb', 'source'], 'string'],
            ['lang_id', 'integer'],
            ['imageFile', 'file', 'extensions' => 'png, jpg, jpeg'],
            ['title', 'filter', 'filter' => function ($value) {
                $value = Html::encode(strip_tags($value));
                return $value;
            }]
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
        return $this->hasOne(Trainer::className(), ['id' => 'trainer_id']);
    }

    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['id' => 'lang_id']);
    }

    public function getArticleTag()
    {
        return $this->hasMany(ArticleTag::className(), ['article_id' => 'id']);
    }

    public function getArticleComment()
    {
        return $this->hasMany(Comment::className(), ['article_id' => 'id']);
    }

    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->via('articleTag');
    }

    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['article_id' => 'id']);
    }


    public static function find()
    {
        return new TrainerQuery(get_called_class());
    }
}
