<?php

namespace app\models;

/**
 * This is the model class for table "trainer_gallery".
 *
 * @property integer $id
 * @property string $src
 * @property integer $trainer_id
 */
class TrainerGallery extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'trainer_gallery';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['trainer_id', 'src'], 'required'],
            ['src', 'string', 'max'=>256],
        ];
    }
}
