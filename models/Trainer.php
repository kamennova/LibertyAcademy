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
 * @property string $cover_photo
 * @property string $city
 * @property integer $riding
 * @property integer $is_admin
 *
 * @property Event[] $events
 * @property Language[] $languages
 * @property Service[] $services
 * @property Country[] $teachCountries
 * @property Ammunition[] $ammunition
 * @property Article[] $articles
 *
 */
class Trainer extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @var UploadedFile
     */
    public $imageFile;
    public $galleryFiles;

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
            [['soc_fb', 'city', 'soc_tw', 'soc_inst', 'big_desc'], 'string'],
            [['name', 'org', 'thumb', 'cover_photo', 'desc', 'surname', 'email', 'pass', 'site', 'address'], 'string', 'max' => 255],
            [['id_status', 'homecountry_id'], 'integer'],
            ['email', 'email'],
            ['email', 'unique',
                'message' => 'This email is taken. Already registered? ' . Html::a('Log in', ['site/login'], ['class' => 'enter login'])],
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
            'thumb' => 'Thumb',
            'authorities' => 'Authorities',
            'credo' => 'Credo',
            'id_status' => 'Status',
            'site' => 'Website',
            'address' => 'Address',
            'big_desc' => 'Big Description',
            'caption' => 'Caption',
            'soc_fb' => 'Facebook page',
            'soc_tw' => 'Twitter page',
            'soc_inst' => 'Instagram page',
            'pass' => 'Password',
            'cover_photo' => 'Cover photo',
            'imageFile' => 'Thumbnail'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(Event::className(), ['trainer_id' => 'id']);
    }

    public function getTrainerStatus()
    {
        return $this->hasOne(TrainerStatus::className(), ['id' => 'id_status']);
    }

    public function getFullName()
    {
        return $this->name . ' ' . $this->surname;
    }

    public function getThumbs()
    {
        return $this->hasMany(Thumb::className(), ['trainer_id' => 'id']);
    }

    public function getGallery()
    {
        return $this->hasMany(TrainerGallery::className(), ['trainer_id' => 'id']);
    }


//    --------------------

//    -------------------------------

    public function getTrainerHomeCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'homecountry_id']);
    }


    public function getTrainerCountry()
    {
        return $this->hasMany(TrainerCountry::className(), ['trainer_id' => 'id']);
    }

    public function getTeachCountries()
    {
        return $this->hasMany(Country::className(), ['id' => 'country_id'])
            ->via('trainerCountry');
    }

//    -------------------------

    public function getTrainerAmmunition()
    {
        return $this->hasMany(TrainerAmmunition::className(), ['trainer_id' => 'id']);
    }

    public function getAmmunition()
    {
        return $this->hasMany(Ammunition::className(), ['id' => 'ammunition_id'])
            ->via('trainerAmmunition');
    }

//    -------------------------

    public function getTrainerService()
    {
        return $this->hasMany(TrainerService::className(), ['trainer_id' => 'id']);
    }

    public function getServices()
    {
        return $this->hasMany(Service::className(), ['id' => 'service_id'])
            ->via('trainerService');
    }

//    ---------------------------

    public function getTrainerLanguage()
    {
        return $this->hasMany(TrainerLanguage::className(), ['trainer_id' => 'id']);
    }

    public function getLanguages()
    {
        return $this->hasMany(Language::className(), ['id' => 'lang_id'])
            ->via('trainerLanguage');
    }

//------------------------------------------

    /**
     * @inheritdoc
     * @return TrainerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TrainerQuery(get_called_class());
    }

//************************************

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

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException();
    }
}
