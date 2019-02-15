<?php

namespace app\models;

use Yii;
use yii\helpers\Html;
use yii\web\UploadedFile;

/**
 * This is the model class for table "trainer".
 * @property integer $id
 * @property integer $trainer_id
 * @property string $name
 * @property string $desc
 * @property file $thumb
 * @property string $bigthumb
 * @property string $caption
 * @property integer $age
 * @property string $breed
 * @property string $gender
 */
class Horse extends \yii\db\ActiveRecord
{
        /**
     * @var UploadedFile
     */
    public $imageFile;

    /**
     * @inheritdoc
     */

    public static function tableName()
    {
        return 'horse';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'age', 'gender', 'thumb'], 'required'],
            [['name', 'gender', 'breed', 'caption'], 'string'],
            [['name', 'gender', 'breed', 'caption'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    /**
     * @inheritdoc
     */

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'desc' => 'Description',
            'thumb' => 'Thumbnail',
            'bigthumb' => 'Bigthumb',
            'caption' => 'Caption',
            'edu' => 'Horse Education',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(Event::className(), ['trainer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrainers()
    {
        return $this->hasOne(Trainer::className(), ['trainer_id' => 'id']);
    }

    public function getThumbs()
    {
        return $this->hasMany(Thumb::className(), ['trainer_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return TrainerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TrainerQuery(get_called_class());
    }
}
