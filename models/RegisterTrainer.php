<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * @inheritdoc
 * @property array $services
 * @property array $ammunition
 * @property array $languages
 * @property array $teachCountries
 */
class RegisterTrainer extends Trainer
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
                [['services', 'ammunition', 'languages'], 'safe'],
                [['services', 'languages', 'teachCountries'], 'required']
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            ['services' => 'Services']
        ]);
    }

    public function upload()
    {
        if ($this->validate(['name', 'surname', 'pass', 'services', 'languages', 'org', 'desc', 'big_desc', 'imageFile'])) {

            if ($this->imageFile = UploadedFile::getInstance($this, 'imageFile')) {
                do {
                    $filename = uniqid(rand(), false) . '.' . $this->imageFile->extension;
                    if (!file_exists(sys_get_temp_dir() . $filename)) break;
                } while (true);

                $this->thumb = '/img/teacher/thumb/' . $filename;

                $this->imageFile->saveAs(Yii::getAlias('@webroot') . $this->thumb);
            }

            return true;
        }

        return false;
    }
}