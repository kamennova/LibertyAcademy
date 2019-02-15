<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "tag".
 * @property integer $article_id
 * @property integer $tag_id
 */
class ArticleTag extends ActiveRecord
{

    public static function tableName()
    {
        return 'article_tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'tag_id'], 'required'],
            [['article_id', 'tag_id'], 'integer']
        ];
    }
}
