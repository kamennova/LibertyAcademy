<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "trainer_teachcountry".
 * @property integer $trainer_id
 * @property integer $country_id
 */
class TrainerCountry extends ActiveRecord
{

    public static function tableName()
    {
        return 'trainer_teachcountry';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['trainer_id', 'country_id'], 'required'],
            [['trainer_id', 'country_id'], 'integer']
        ];
    }
}
