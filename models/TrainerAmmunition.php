<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "trainer_ammunition".
 * @property integer $trainer_id
 * @property integer $ammunition_id
 */
class TrainerAmmunition extends ActiveRecord
{

    public static function tableName()
    {
        return 'trainer_ammunition';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['trainer_id', 'ammunition_id'], 'required'],
            [['trainer_id', 'ammunition_id'], 'integer']
        ];
    }
}
