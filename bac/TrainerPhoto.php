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
class TrainerPhoto extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'trainer_gallery';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['src', 'trainer_id'], 'required'],
            [['src'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
             ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public static function find()
    {
        return new TrainerQuery(get_called_class());
    }
}
