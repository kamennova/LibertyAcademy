<?php

namespace app\models;

use Yii;
use yii\helpers\Html;
use yii\web\UploadedFile;

/**
 * @inheritdoc *
 * @property boolean $rememberMe
 */
class LoginTrainer extends \yii\db\ActiveRecord
{
    public $rememberMe = true;

    public function rules()
    {
        return array_merge(parent::rules(), [
            ['rememberMe', 'boolean'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return parent::attributeLabels();
    }


    public function login()
    {
        if ($this->validate()) {
//            return Yii::$app->user->login($this->getTrainer(), $this->rememberMe ? 3600*24*30 : 0);
            return Yii::$app->user->login($this->getTrainer(), 0);
        }
        return false;
    }


}


