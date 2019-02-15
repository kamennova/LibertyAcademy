<?php
namespace app\models;

use yii\helpers\Html;

/**
 * This is the model class for table "comment".
 * @property integer $id
 * @property int $article_id
 * @property string $author_name
 * @property $author_email
 * @property $author_website
 * @property $date
 * @property $content
 */
class Comment extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['author_name', 'content', 'author_email'], 'required'],
            [['author_name', 'content', 'author_website'], 'string'],
            [['author_email'], 'email'],
            [['content', 'author_name'], 'filter', 'filter' => function ($value) {
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
            'author_name' => 'Name',
            'author_email' => 'Email',
            'author_website' => 'Website',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */

//    public function getTrainer()
//    {
//        return $this->hasOne(Trainer::className(), ['id' => 'trainer_id']);
//    }
//
//    public function getLanguage()
//    {
//        return $this->hasOne(Language::className(), ['id' => 'lang_id']);
//    }
//
//    public function getArticleTag()
//    {
//        return $this->hasMany(ArticleTag::className(), ['article_id' => 'id']);
//    }
//
//    public function getTags()
//    {
//        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
//            ->via('articleTag');
//    }


    public static function find()
    {
        return new TrainerQuery(get_called_class());
    }
}
