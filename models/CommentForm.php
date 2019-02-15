<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class CommentForm extends Comment
{

    /**
     * @return array the validation rules.
     */
//    public function rules()
//    {
//        return [
//             name, email, subject and body are required
//            [['name', 'email', 'subject', 'body'], 'required'],
            // email has to be a valid email address
//            ['email', 'email'],
            // verifyCode needs to be entered correctly
//            ['verifyCode', 'captcha'],
//        ];
//    }

    /**
     * @return array customized attribute labels
     */


    /**
     *
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return boolean whether the model passes validation
     */

    public function upload()
    {
        if ($this->validate(['author_email', 'author_website', 'content', 'author_name'])) {
            return true;
        } else {
            return false;
        }
    }

//    public function contact($email)
//    {
//        if ($this->validate()) {
//            Yii::$app->mailer->compose()
//                ->setTo($email)
//                ->setFrom([$this->email => $this->name])
//                ->setSubject($this->subject)
//                ->setTextBody($this->body)
//                ->send();
//
//            return true;
//        }
//        return false;
//    }
}
