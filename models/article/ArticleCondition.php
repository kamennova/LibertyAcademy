<?php

namespace app\models\article;

use app\models\Article;
use app\models\ArticleTag;
use yii\data\ActiveDataProvider;

class ArticleCondition extends Article
{
    public $tag_id;

    public function rules()
    {
        return [
            ['tag_id', 'safe'],
            [['title'], 'string'],
            [['trainer_id', 'lang_id'], 'integer']
        ];
    }

    public function search()
    {
        $query = Article::find()->where(['visibility' => true]);

        if ($this->title) {
            $query->andFilterWhere(['like', 'title', $this->title]);
        }

        if ($this->date) {
            $query->andWhere(['date' => $this->date]);
        }

        if($this->trainer_id){
            $query->andWhere(['trainer_id' => $this->trainer_id]);
        }

        if($this->lang_id){
            $query->andWhere(['lang_id' => $this->lang_id]);
        }

        if ($this->tag_id) {

            $tag_sub_query = ArticleTag::find()->where(['tag_id' => $this->tag_id])->select('article_id')->distinct();
            $query->andWhere(['id'=>$tag_sub_query]);
        }

        $query->orderBy('date DESC');

        return new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 15,
                ],
            ]
        );
    }
}