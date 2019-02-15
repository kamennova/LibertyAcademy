<?php

namespace app\models;

use Yii;
use yii\helpers\Html;
use yii\web\UploadedFile;

/**
 * This is the model class for table "trainer_gallery".
 * @property integer $id
 * @property string $src
 * @property integer $trainer_id
 */
class TrainerStatus extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'trainer_status';
    }

    /**
     * @inheritdoc
     */

    public function rules()
    {
        return [
            [['name'], 'required'],
            ['name', 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ['name' => 'Status'];
    }

    public function getTrainer()
    {
        return $this->hasMany(Trainer::className(), ['id_status' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */

}
