<?php

namespace app\models\article;

use app\models\Article;
use app\models\Tag;
use Yii;

/**
 * This is the model class for table "article".
 * @inheritdoc
 * @property array $tags
 */
class ArticleForm extends Article
{
    public $tags;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
                ['tags', 'safe']
            ]
        );
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return parent::attributeLabels();
    }

    public function upload()
    {
        if ($this->validate(['tags', 'title', 'source', 'content', 'imageFile'])) {

            if ($this->imageFile) {
                $this->imageFile->saveAs(Yii::getAlias('@webroot') . '/img/article/thumb/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            }

            return true;
        } else {
            return false;
        }
    }

    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->via('articleTag');
    }
}
