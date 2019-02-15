<?php

namespace app\models;


/**
 * This is the model class for table "tag".
 * @property integer $id
 * @property string $name
 */
class Tag extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'tag';
    }

    /**
     * @inheritdoc
     */

    public function rules()
    {
        return [
            [['name'], 'required'],
            ['name', 'string']
        ];
    }

    /**
     * @inheritdoc
     */

    public function attributeLabels()
    {
        return ['name' => 'Tag'];
    }
}
