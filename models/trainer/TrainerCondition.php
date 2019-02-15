<?php

namespace app\models\trainer;

use app\models\Trainer;
use yii\data\ActiveDataProvider;
use yii\db\Query;

class TrainerCondition extends Trainer
{

    public $teachcountry_id;
    public $service_id;
    public $lang_id;

    public function rules()
    {
        return [
            [['teachcountry_id', 'service_id', 'lang_id'], 'safe'],
            [['desc', 'soc_fb', 'soc_tw', 'soc_inst', 'big_desc', 'edu'], 'string'],
            [['id_status', 'homecountry_id',], 'integer'],
            [['name', 'org', 'thumb', 'email', 'pass', 'site', 'address', 'bigthumb', 'caption'], 'string', 'max' => 255],
        ];
    }

    public function formQuery()
    {
        $query = Trainer::find();

        if ($this->name) {
            $query->andWhere(['name' => $this->name]);
        }

        if ($this->org) {
            $query->andWhere(['org' => $this->org]);
        }

        if ($this->id_status) {
            $query->andWhere(['id_status' => $this->id_status]);
        }

        if ($this->teachcountry_id) {
            $query->innerJoin('trainer_teachcountry', 'trainer.id=trainer_teachcountry.trainer_id');
            $query->andWhere(['country_id' => $this->teachcountry_id]);
        }

        if ($this->service_id) {
            $query->innerJoin('trainer_service', 'trainer.id=trainer_service.trainer_id');
            $query->andWhere(['service_id' => $this->service_id]);
        }

        if ($this->lang_id) {
            $query->innerJoin('trainer_language', 'trainer.id=trainer_language.trainer_id');
            $query->andWhere(['lang_id' => $this->lang_id]);
        }

        $data = $query->andWhere('thumb<>""')->limit(3)->select('thumb')->column();


        return [
            'query' => $data,
        ];
    }


    public function trainerSearch()
    {
        $query = Trainer::find();

        if ($this->name) {
            $query->andWhere(['name' => $this->name]);
        }

        if ($this->org) {
            $query->andWhere(['org' => $this->org]);
        }

        if ($this->id_status) {
            $query->andWhere(['id_status' => $this->id_status]);
        }

        if ($this->teachcountry_id) {
            $query->innerJoin('trainer_teachcountry', 'trainer.id=trainer_teachcountry.trainer_id');
            $query->andWhere(['country_id' => $this->teachcountry_id]);
        }

        if ($this->service_id) {
            $query->innerJoin('trainer_service', 'trainer.id=trainer_service.trainer_id');
            $query->andWhere(['service_id' => $this->service_id]);
        }

        if ($this->lang_id) {
            $query->innerJoin('trainer_language', 'trainer.id=trainer_language.trainer_id');
            $query->andWhere(['lang_id' => $this->lang_id]);
        }

        return new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 12,
                ],
            ]
        );
    }
}

//
//<?= $form->field($condition, 'homecountry_id', ['horizontalCssClasses' => ['wrapper' => false, 'offset' => false]])
//    ->dropDownList($countryList, [
//        'prompt' => 'Country',
//        'onchange' => 'this.form.submit()'
//    ])->label(false);
?>
