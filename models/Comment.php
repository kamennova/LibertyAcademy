<?php
namespace app\models;

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
            [['content', 'author_name', 'author_website'], 'filter', 'filter' => '\yii\helpers\Html::encode'],
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
    public static function find()
    {
        return new TrainerQuery(get_called_class());
    }
}