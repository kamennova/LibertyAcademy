<?php

namespace app\models\event;

use app\models\Event;
use yii\web\UploadedFile;

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

            if ($this->imageFile = UploadedFile::getInstance($this, 'imageFile')) {
                if ($this->thumb !== '' && $this->thumb !== null && file_exists('.' . $this->thumb)) {
                    unlink('.' . $this->thumb);
                }

                do {
                    $filename = uniqid(rand(), false) . '.' . $this->imageFile->extension;
                    if (!file_exists(sys_get_temp_dir() . $filename)) break;
                } while (true);

                $this->thumb = '/img/event/thumb/' . $filename;
            }

            return true;
        } else {
            return false;
        }
    }
}