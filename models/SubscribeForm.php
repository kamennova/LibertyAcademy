<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * SubscribeForm is the model behind the subscribe form.
 */
class SubscribeForm extends Subscriber
{
    /**
     * @inheritdoc
     */

    public function rules()
    {
        return parent::rules();
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
        if ($this->validate(['first_name', 'last_name', 'email'])) {
            return true;
        } else {
            return false;
        }
    }
}
