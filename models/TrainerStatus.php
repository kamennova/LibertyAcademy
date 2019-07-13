<?php

namespace app\models;

/**
 * This is the model class for table "trainer_status".
 * @property integer $id
 * @property string $name
 *
 * @property mixed $trainer
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
        return $this->hasMany(Trainer::class, ['id_status' => 'id']);
    }
}