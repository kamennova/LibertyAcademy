<?php namespace app\models\event;


use app\models\Event;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;


class EventSearch extends Event
{

    /**
     * @inheritdoc
     */

    public $tag_id;

    public function rules()
    {
        return [
            [['name', 'id', 'start', 'end', 'tags', 'trainer_id'], 'safe'],
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
     * @return ActiveDataProvider
     * @throws \yii\base\InvalidParamException
     */

    public function search($params)
    {
        $query = Event::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if ($params && !($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        $query->andFilterWhere(['like', 'type_id', $this->type_id]);

        if ($this->tag_id) {
            $query->innerJoin('article_tag', 'article.id=article_tag.article_id');
            $query->filterWhere(['tag_id'=>$this->tag_id]);
        }

        $query->andFilterWhere(['trainer_id' => Yii::$app->user->id]);

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 40,
                ]
        ]);
    }
}

?>