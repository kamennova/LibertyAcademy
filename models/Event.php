<?php

namespace app\models;

use app\models\event\EventType;

/**
 * This is the model class for table "event".
 * @property integer $id
 * @property integer $type_id
 * @property integer $trainer_id
 * @property string $desc
 * @property string $content
 * @property string $start
 * @property string $end
 * @property string $thumb
 * @property string $name
 * @property integer $price_min
 * @property integer $price_max
 * @property integer $currency_id
 * @property string $address
 * @property integer $country_id
 * @property mixed $tags
 * @property mixed $type
 * @property mixed $fullPrice
 * @property mixed $trainer
 * @property mixed $eventTag
 * @property mixed $country
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
            [['name', 'thumb', 'desc', 'start', 'end', 'address'], 'string', 'max' => 255],
            ['content', 'string'],
            [['country_id', 'currency_id', 'price_min', 'price_max'], 'integer']
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
            'content' => 'Full description',
            'country_id' => 'Country',
            'trainer_id' => 'Curator',
            'tags' => 'Topics'
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

    public function getLocation(){
        $location = $this->country ? $this->country->country_name : null;
        $location = ($this->address ? $this->address . ', ' : null) . $location;

        return $location;
    }

    public function getFullPrice()
    {
        return $this->hasOne(Currency::class, ['id' => 'currency_id']);
    }

    public function getPriceHtmlString(){
        if($this->price_min) {
            $cur = Currency::find()->where(['id' => $this->currency_id])->asArray()->one()['currency_symbol'];

            $price = '<span class="currency">' . $cur . '</span>';
            $price .= $this->price_min;

            if ($this->price_max) {
                $price .= ' - ' . $this->price_max;
            }

            return $price;
        }

        return null;
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