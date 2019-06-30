<?php

namespace app\models;

/**
 * This is the model class for table "country".
 * @property string $country_code
 * @property string $country_name
 */
class Country extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'country';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country_name', 'country_code'], 'required'],
            [['country_name', 'country_code'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'country_name' => 'Country name',
            'country_code' => 'Country code',
        ];
    }
}