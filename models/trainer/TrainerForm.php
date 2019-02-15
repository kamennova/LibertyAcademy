<?php

namespace app\models\trainer;

use app\models\Service;
use yii\base\NotSupportedException;
use yii\helpers\Html;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;

/**
 * @property Service[] $services
 *
 */
class TrainerForm extends \yii\db\ActiveRecord implements IdentityInterface
{

    public $services;

    /**
     * @inheritdoc
     */

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
           ['serivces', 'safe']
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return parent::attributeLabels();
    }

   public function getServices(){
        return $this->hasMany(Service::className(), ['id' => 'service_id'])->via('trainerService');
   }
}
