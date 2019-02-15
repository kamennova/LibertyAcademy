<?php


namespace app\models;

use Yii;


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
    public $ammunition;
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
        if ($this->validate(['pass', 'name', 'services', 'ammunition', 'languages', 'org', 'desc', 'big_desc', 'imageFile', 'galleryFiles'])) {

            if ($this->imageFile) {
                $this->imageFile->saveAs(Yii::getAlias('@webroot') . '/img/teacher/thumb/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            }

            if ($this->galleryFiles) {
                foreach ($this->galleryFiles as $file) {
                    $file->saveAs(Yii::getAlias('@webroot') . '/img/teacher/gallery/' . $file->baseName . '.' . $file->extension);
                }
            }

            return true;
        } else {
            return false;
        }
    }

}
