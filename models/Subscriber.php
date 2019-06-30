<?php

namespace app\models;

/**
 * This is the model class for table "subscriber".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 *
 */
class Subscriber extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subscriber';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'email'], 'required'],
            [['first_name', 'last_name'], 'string', 'max' => 255],
            [['email'], 'string'],
            ['email', 'email'],
            ['email', 'unique', 'message' => 'This email is taken']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'first_name' => 'First name',
            'last_name' => 'Last name',
        ];
    }

    public function getId()
    {
        return $this->id;
    }
}