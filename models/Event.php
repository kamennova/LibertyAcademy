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
 * @property string $start
 * @property string $end
 * @property string $thumb
 * @property string $name
 * @property integer $price
 * @property integer $currency_id
 * @property string $address
 * @property integer $country_id
 * @property mixed $tags
 * @property mixed $type
 * @property mixed $fullPrice
 * @property mixed $trainer
 * @property mixed $eventTag
 * @property mixed $country
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
        return $this->hasOne(Trainer::class, ['id' => 'trainer_id']);
    }

    public function getType()
    {
        return $this->hasOne(EventType::class, ['id' => 'type_id']);
    }

    public function getCountry()
    {
        return $this->hasOne(Country::class, ['id' => 'country_id']);
    }

    public function getFullPrice()
    {
        return $this->hasOne(Currency::class, ['id' => 'currency_id']);
    }

    public function getEventTag()
    {
        return $this->hasMany(EventTag::class, ['event_id' => 'id']);
    }

    public function getTags()
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])
            ->via('eventTag');
    }
}