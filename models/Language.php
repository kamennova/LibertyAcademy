<?php

namespace app\models;

/**
 * This is the model class for table "language".
 * @property string $lang_code
 * @property string $lang_flag
 * @property string $lang_name
 */
class Language extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'language';
    }

    /**
     * @inheritdoc
     */

    public function rules()
    {
        return [
            [['lang_name', 'lang_code'], 'required'],
            [['lang_name', 'lang_code', 'lang_flag'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'lang_name' => 'Language name',
            'lang_code' => 'Language code',
            'lang_flag' => 'Language flag',
             ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */

}
