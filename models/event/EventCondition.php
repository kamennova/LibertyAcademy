<?php

namespace app\models\event;

use app\models\Event;
use yii\data\ActiveDataProvider;

class EventCondition extends Event
{

    public $tag_id;

    public function rules()
    {
        return [
            [[], 'required'],
            [['start', 'tag_id'], 'safe'],
            [['name', 'desc'], 'string'],
            [['start'], 'default', 'value' => null],
            [['trainer_id', 'country_id', 'type_id'], 'integer']
        ];
    }

    public function search()
    {
        $query = Event::find();

        if ($this->country_id) {
            $query->andWhere(['country_id' => $this->country_id]);
        }

        if ($this->type_id) {
            $query->andWhere(['type_id' => $this->type_id]);
        }

        if($this->trainer_id){
            $query->andWhere(['trainer_id' => $this->trainer_id]);
        }

        if($this->name){
            $query->andWhere(['name' => $this->name]);
        }

        if($this->start){
//            $this->start = date('Y-j-d', strtotime($this->start));
            $query->andWhere(['start' => $this->start]);
        }

        if ($this->tag_id) {
            $query->innerJoin('event_tag', 'event.id=event_tag.event_id');
            $query->andWhere(['tag_id'=>$this->tag_id]);
        }


        return new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 12,
                ],
            ]
        );
    }
}
