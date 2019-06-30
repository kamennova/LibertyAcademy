<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "event_tag".
 * @property integer $event_id
 * @property integer $tag_id
 */
class EventTag extends ActiveRecord
{

    public static function tableName()
    {
        return 'event_tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_id', 'tag_id'], 'required'],
            [['event_id', 'tag_id'], 'integer']
        ];
    }
}