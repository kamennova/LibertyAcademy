<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "trainer_language".
 * @property integer $trainer_id
 * @property integer $lang_id
 */
class TrainerLanguage extends ActiveRecord
{

    public static function tableName()
    {
        return 'trainer_language';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['trainer_id', 'lang_id'], 'required'],
            [['trainer_id', 'lang_id'], 'integer']
        ];
    }
}