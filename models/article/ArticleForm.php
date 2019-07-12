<?php

namespace app\models\article;

use app\models\Article;
use yii\web\UploadedFile;

/**
 * This is the form model class for Article model.
 * @inheritdoc
 * @property array $tags
 */
class ArticleForm extends Article
{
    public $tags;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
                ['tags', 'safe']
            ]
        );
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return parent::attributeLabels();
    }

    public function upload()
    {
        if ($this->validate(['tags', 'title', 'source', 'content', 'imageFile'])) {

            if ($this->imageFile = UploadedFile::getInstance($this, 'imageFile')) {
                if ($this->thumb !== '' && $this->thumb !== null && file_exists('.' . $this->thumb)) {
                    unlink('.' . $this->thumb);
                }

                do {
                    $filename = uniqid(rand(), false) . '.' . $this->imageFile->extension;
                    if (!file_exists(sys_get_temp_dir() . $filename)) break;
                } while (true);

                $this->thumb = '/img/article/thumb/' . $filename;
            }

            return true;
        }

        return false;
    }
}