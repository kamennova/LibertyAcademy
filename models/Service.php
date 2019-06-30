<?php

namespace app\models;

/**
 * This is the model class for table "service".
 * @property string $service_name
 */
class Service extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'service';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service_name'], 'required'],
            [['service_name'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'service_name' => 'Service name'
             ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
}