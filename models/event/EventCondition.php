<?php

namespace app\models\event;

use app\models\Event;
use yii\data\ActiveDataProvider;

class EventCondition extends Event
{

    public $tag_id;
    public $show_archived;

    public function rules()
    {
        return [
            [['start', 'tag_id', 'show_archived'], 'safe'],
            [['name', 'desc'], 'string'],
            [['start'], 'default', 'value' => null],
            ['show_archived', 'default', 'value' => false],
            [['trainer_id', 'country_id', 'type_id'], 'integer']
        ];
    }

    public function search()
    {
        $query = Event::find();

        if (!$this->show_archived) {
            $query->andWhere(['>=', 'start', date("Y-m-d")]);
        }

        if ($this->country_id) {
            $query->andWhere(['country_id' => $this->country_id]);
        }

        if ($this->type_id) {
            $query->andWhere(['type_id' => $this->type_id]);
        }

        if ($this->trainer_id) {
            $query->andWhere(['trainer_id' => $this->trainer_id]);
        }

        if ($this->tag_id) {
            $query->innerJoin('event_tag', 'event.id=event_tag.event_id');
            $query->andWhere(['tag_id' => $this->tag_id]);
        }

        $query->orderBy('start ASC');

        return new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 12,
                ],
            ]
        );
    }
}