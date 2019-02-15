<?php

namespace app\models\event;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "event_type".
 * @property string $name
 * @property integer $id
 */
class EventType extends ActiveRecord
{

    public static function tableName()
    {
        return 'event_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            ['id', 'integer'],
            ['name', 'string']
        ];
    }
}
