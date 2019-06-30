<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "trainer_service".
 * @property integer $trainer_id
 * @property integer $service_id
 */
class TrainerService extends ActiveRecord
{

    public static function tableName()
    {
        return 'trainer_service';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['trainer_id', 'service_id'], 'required'],
            [['trainer_id', 'service_id'], 'integer']
        ];
    }
}