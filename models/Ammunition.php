<?php

namespace app\models;

/**
 * This is the model class for table "ammunition".
 * @property string $ammunition_name
 */
class Ammunition extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'ammunition';
    }

    /**
     * @inheritdoc
     */

    public function rules()
    {
        return [
            [['ammunition_name'], 'required'],
            [['ammunition_name'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ammunition_name' => 'Ammunition'
             ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */

}
