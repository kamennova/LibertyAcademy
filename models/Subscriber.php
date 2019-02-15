<?php

namespace app\models;

use yii\base\NotSupportedException;

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
            ['email', 'unique',
                'message' => 'This email is taken']
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

    /**
     * @return \yii\db\ActiveQuery
     */
//    public static function find()
//    {
//        return new TrainerQuery(get_called_class());
//    }

//************************************

    public static function findIdentity($id)
    {
        return Subscriber::findOne($id);
    }


    public function getId()
    {
        return $this->id;
    }


    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException();
    }
}
