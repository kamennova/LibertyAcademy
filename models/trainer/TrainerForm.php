<?php

namespace app\models\trainer;

use app\models\Trainer;
use yii\web\UploadedFile;

/**
 * @inheritdoc
 * @property array $services
 */
class TrainerForm extends Trainer
{
    public $services;
    public $languages;
    public $teachCountries;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
                ['services', 'safe'],
                ['languages', 'safe'],
                ['teachCountries', 'safe']
            ]
        );
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return parent::attributeLabels();
    }

    public function upload()
    {
        if ($this->validate(['services', 'teachCountries', 'languages', 'imageFile'])) {

            if ($this->imageFile = UploadedFile::getInstance($this, 'imageFile')) {
                if ($this->thumb !== '' && $this->thumb !== null) {
                    unlink('.' . $this->thumb);
                }

                do {
                    $filename = uniqid(rand(), false) . '.' . $this->imageFile->extension;
                    if (!file_exists(sys_get_temp_dir() . $filename)) break;
                } while (true);

                $this->thumb = '/img/teacher/thumb/' . $filename;
            }

            return true;
        }

        return false;
    }
}