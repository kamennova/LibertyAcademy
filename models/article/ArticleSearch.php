<?php namespace app\models\article;

use app\models\Article;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;


class ArticleSearch extends Article
{

    /**
     * @inheritdoc
     */

    public $tag_id;

    public function rules()
    {
        return [
            [['title', 'content', 'tag_id', 'lang_id', 'id', 'date', 'trainer_id'], 'safe'],
            [['lang_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */

    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     * @throws \yii\base\InvalidParamException
     */

    public function search($params)
    {
        $query = Article::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if ($params && !($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id]);

        $query->andFilterWhere(['lang_id' => $this->lang_id]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        $query->andFilterWhere(['trainer_id' => $this->trainer_id]);

        $query->andFilterWhere(['like', 'date', $this->date]);

        if ($this->tag_id) {
            $query->innerJoin('article_tag', 'article.id=article_tag.article_id');
            $query->filterWhere(['tag_id' => $this->tag_id]);
        }

        $query->andFilterWhere(['trainer_id' => Yii::$app->user->id]);


//        foreach ($this->tags as $tag) {
//            $query->innerJoin('article_tag', 'article.id=article_tag.article_id');
//            $query->andFilterWhere(['tag_id'=>$tag->id]);
//            $query->andFilterWhere(['tag_id' => $tag->id]);
//        }
//        if ($this->tag_id) {
//            $query->innerJoin('article_tag', 'article.id=article_tag.article_id');
//            $query->filterWhere(['tag_id'=>$this->tag_id]);
//        }

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => '40'
            ]
        ]);
    }
}

?>