<?php

namespace app\models;

use yii\base\Model;

/**
 * @property Trainer|null $user This property is read-only.
 *
 */
class ChangePasswordForm extends Model
{
    public $password;
    public $repeat;
    public $old_password;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['password', 'old_password', 'repeat'], 'required'],
            [['password', 'repeat'], 'string', 'min' => 4, 'max' => 100],
            ['repeat', 'compare', 'compareAttribute' => 'password', 'message' => "Passwords don't match"],
        ];
    }
}