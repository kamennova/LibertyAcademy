<?php

namespace app\models;

use app\models\event\EventType;

/**
 * This is the model class for table "event".
 * @property integer $id
 * @property integer $type_id
 * @property integer $trainer_id
 * @property string $desc
 * @property string $for
 * @property string $content
 * @property $start
 * @property $end
 * @property $thumb
 * @property string $name
 * @property integer $price
 * @property integer $currency_id
 * @property string $address
 * @property integer $country_id
 * @property string $org
 */
class Event extends \yii\db\ActiveRecord
{

    public $imageFile;

    public static function tableName()
    {
        return 'event';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id', 'trainer_id', 'start', 'name', 'desc'], 'required'],
            [['name', 'thumb', 'desc', 'content', 'org', 'for', 'address'], 'string'],
            [['country_id', 'currency_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'type_id' => 'Type',
            'name' => 'Name',
            'desc' => 'Short description',
            'start' => 'Start date',
            'end' => 'End date',
            'currency_id' => 'Currency',
            'for' => 'Target audience',
            'org' => 'Organization',
            'content' => 'Full description',
            'country_id' => 'Country',
            'trainer_id' => 'Curator',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public static function find()
    {
        return new TrainerQuery(get_called_class());
    }

    public function getTrainer()
    {
        return $this->hasOne(Trainer::className(), ['id' => 'trainer_id']);
    }

    public function getType()
    {
        return $this->hasOne(EventType::className(), ['id' => 'type_id']);
    }

    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    public function getFullPrice()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id']);
    }

    public function getEventTag()
    {
        return $this->hasMany(EventTag::className(), ['event_id' => 'id']);
    }

    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->via('eventTag');
    }

}
