<?php

namespace app\models;


/**
 * CommentForm is the model behind the comment form.
 */
class CommentForm extends Comment
{

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['author_email', 'email'],
            [['author_website', 'content', 'author_name'], 'string'],
            [['author_name', 'author_email', 'content'], 'required'],
        ];
    }
}