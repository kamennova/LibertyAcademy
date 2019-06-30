<?php

namespace app\models\trainer;

use app\models\Trainer;

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
        if ($this->validate(['services', 'teachCountries', 'languages'])) {
            return true;
        }

        return false;
    }
}