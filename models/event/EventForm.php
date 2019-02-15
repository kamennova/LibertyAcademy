<?php

namespace app\models\event;

use app\models\Event;
use Yii;

/**
 * This is the model class for table "event".
 * @inheritdoc
 * @property array $tags
 */
class EventForm extends Event
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
        return array_merge(parent::attributeLabels(), [
            ['tags' => 'Topics']
        ]);
    }

    public function upload()
    {
        if ($this->validate()) {

            if ($this->imageFile) {
                $this->imageFile->saveAs(Yii::getAlias('@webroot') . '/img/event/thumb/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            }

            return true;
        } else {
            return false;
        }
    }

}
