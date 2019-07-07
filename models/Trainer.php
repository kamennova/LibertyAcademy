<?php

namespace app\models;

use yii\base\NotSupportedException;
use yii\helpers\Html;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;

/**
 * This is the model class for table "trainer".
 *
 * @property integer $id
 * @property string $name
 * @property string $surname
 * @property string $org
 * @property string $desc
 * @property integer $homecountry_id
 * @property string $email
 * @property $thumb
 * @property string $visibility
 * @property string $soc_tw
 * @property string $soc_fb
 * @property string $soc_inst
 * @property integer $id_status
 * @property string $site
 * @property string $address
 * @property string $big_desc
 * @property string $pass
 * @property string $city
 * @property integer $is_admin
 *
 * @property Event[] $events
 * @property Language[] $languages
 * @property Service[] $services
 * @property Country[] $teachCountries
 * @property mixed $thumbs
 * @property mixed $trainerStatus
 * @property mixed $gallery
 * @property mixed $trainerLanguage
 * @property mixed $trainerCountry
 * @property mixed $trainerHomeCountry
 * @property string $fullName
 * @property mixed $trainerService
 * @property void $authKey
 * @property Article[] $articles
 *
 */
class Trainer extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @var UploadedFile
     */
    public $imageFile;
    public $galleryFiles; // todo

    /**
     * @inheritdoc
     */

    public static function tableName()
    {
        return '{{trainer}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'homecountry_id', 'surname', 'desc', 'pass'], 'required'],
            [['big_desc'], 'string'],
            [['name', 'surname', 'email', 'pass', 'city', 'address', 'soc_tw', 'soc_inst', 'soc_fb', 'site',
                'org', 'thumb'], 'string', 'max' => 255],
            ['desc', 'string', 'max' => 150],
            [['id_status', 'homecountry_id'], 'integer'],
            ['email', 'email'],
            ['email', 'unique',
                'message' => 'This email is taken. Already registered? ' .
                    Html::a('Log in', ['site/login'], ['class' => 'enter login'])],
            ['imageFile', 'file', 'extensions' => 'png, jpg, jpeg'],
            ['galleryFiles', 'file', 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 10],
            ['pass', 'string', 'length' => [3, 255], 'message' => 'The password should contain at least 3 chars'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'First name',
            'surname' => 'Last name',
            'org' => 'Organization',
            'desc' => 'Description',
            'homecountry_id' => 'Country of residence',
            'email' => 'Email',
            'thumb' => 'Thumbnail',
            'id_status' => 'Status',
            'site' => 'Website',
            'address' => 'Address',
            'big_desc' => 'Big description',
            'soc_fb' => 'Facebook page',
            'soc_tw' => 'Twitter page',
            'soc_inst' => 'Instagram page',
            'pass' => 'Password',
            'imageFile' => 'Thumbnail'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(Event::class, ['trainer_id' => 'id']);
    }

    public function getTrainerStatus()
    {
        return $this->hasOne(TrainerStatus::class, ['id' => 'id_status']);
    }

    public function getFullName()
    {
        return $this->name . ' ' . $this->surname;
    }

//    -------------------------------

    public function getTrainerHomeCountry()
    {
        return $this->hasOne(Country::class, ['id' => 'homecountry_id']);
    }

    public function getTrainerCountry()
    {
        return $this->hasMany(TrainerCountry::class, ['trainer_id' => 'id']);
    }

    public function getTeachCountries()
    {
        return $this->hasMany(Country::class, ['id' => 'country_id'])
            ->via('trainerCountry');
    }

    public function getLocation()
    {
        return ($this->city ? "$this->city, " : null) . $this->trainerHomeCountry->country_name;
    }

//    -----

    public function getTrainerService()
    {
        return $this->hasMany(TrainerService::class, ['trainer_id' => 'id']);
    }

    public function getServices()
    {
        return $this->hasMany(Service::class, ['id' => 'service_id'])
            ->via('trainerService');
    }

//    -----

    public function getTrainerLanguage()
    {
        return $this->hasMany(TrainerLanguage::class, ['trainer_id' => 'id']);
    }

    public function getLanguages()
    {
        return $this->hasMany(Language::class, ['id' => 'lang_id'])
            ->via('trainerLanguage');
    }

//   -----

    /**
     * @inheritdoc
     * @return TrainerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TrainerQuery(get_called_class());
    }

//   -----

    public static function findIdentity($id)
    {
        return Trainer::findOne($id);
    }

    public static function findByUsername($email)
    {
        return Trainer::find()->where(['email' => $email])->one();
    }

    public function validatePassword($password)
    {
        return $this->pass === $password;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
//        throw new NotSupportedException();
    }

    public function validateAuthKey($authKey)
    {
//        throw new NotSupportedException();
    }

    /**
     * @param mixed $token
     * @param null $type
     * @return void|IdentityInterface
     * @throws NotSupportedException
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException();
    }

    public static function update_link($link)
    {
        $protocol = 'http';

        if ($link !== '' && substr($link, 0, strlen($protocol)) !== $protocol) {
            $link = $protocol . '://' . $link;
        }

        return $link;
    }

    public function update_links()
    {
        $this->site = Trainer::update_link($this->site);
        $this->soc_fb = Trainer::update_link($this->soc_fb);
        $this->soc_tw = Trainer::update_link($this->soc_tw);
        $this->soc_inst = Trainer::update_link($this->soc_inst);
    }
}