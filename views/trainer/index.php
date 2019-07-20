<?php

use app\models\Country;
use app\models\Language;
use app\models\Service;
use app\models\Trainer;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/**
 * @var $this yii\web\View
 * @var \yii\data\ActiveDataProvider $provider
 * @var [] $thumbsProvider
 * @var \app\models\trainer\TrainerCondition $condition
 */

$this->title = 'Teachers | Liberty Academy';

$meta_desc =  'Find a skilled liberty horsemanship trainer worldwide';

$this->registerMetaTag(['name' => 'keywords', 'content' =>
    'liberty academy, liberty training, liberty trainers, liberty trainer, liberty horse, liberty horsemanship, liberty horse training']);
$this->registerMetaTag(['name' => 'description', 'content' => $meta_desc]);
$this->registerMetaTag(['og:title' => $this->title]);
$this->registerMetaTag(['og:type' => 'website']);
$this->registerMetaTag(['og:description' => $meta_desc]);

$this->registerCssFile('/build/list_layout.css');

$trainers = $provider->getModels();
$trainersNumber = $provider->pagination->totalCount;

//----

$smallThumbsQuery = clone $provider->query;
$smallThumbs = $smallThumbsQuery->select('thumb')->andwhere('thumb<>""')->limit(3)->column();
$smallThumbsNumber = count($smallThumbs);

//----

$nameList = Trainer::find()
    ->select(["CONCAT(name, ' ', surname)"])
    ->where('name<>""')
    ->indexBy('name')
    ->orderBy('name')
    ->column();

$countryListSubQuery = (new \yii\db\Query())
    ->select(['country_id'])
    ->from('trainer_teachcountry')
    ->distinct();

$countryList = Country::find()
    ->select('country_name')
    ->where(['in', 'id', $countryListSubQuery])
    ->indexBy('id')
    ->orderBy('id')
    ->column();

//--------

$serviceListSubQuery = (new \yii\db\Query())
    ->select(['service_id'])
    ->from('trainer_service')
    ->distinct();

$serviceList = Service::find()
    ->select('service_name')
    ->indexBy('id')
    ->orderBy('id')
    ->column();

//--------

$langListSubQuery = (new \yii\db\Query())
    ->select(['lang_id'])
    ->from('trainer_language')
    ->distinct();

$langList = Language::find()->select('lang_name')->where(['in', 'id', $langListSubQuery])
    ->indexBy('id')->orderBy('id')->column();

?>

<div class="site-container flex-container">
    <aside class="filter-column trainer-filter-column">
        <div class="filter-column-top">
            <?php if ($trainers) {

                $smallThumbsList = '';

                foreach ($smallThumbs as $smallThumb) {
                    $smallThumbsList .= "<li class='small-thumb'><img src='{$smallThumb}'/></li>";
                }

                if ($trainersNumber != 0 && $trainersNumber < 3 && $smallThumbsNumber < $trainersNumber) {
                    for ($i = 0; $i < $trainersNumber; $i++) {
                        $smallThumbsList .= "<li class='small-thumb'></li>";
                    }
                };

                if ($smallThumbsList != '') {
                    echo '<ul class="small-thumbs-list trainers-thumbs-list">' . $smallThumbsList . '</ul>';
                }

            } ?>
            <span class="number trainers-number">
                <?= $trainersNumber ?> teacher<?= (($trainersNumber !== 1) ? 's' : null) ?>
            </span>
        </div>

        <h1 class="visually-hidden">Liberty horse trainers</h1>
        <h2 class="filter-title">Find a skilled teacher</h2>

        <div class="form-wrapper">
            <?php $form = ActiveForm::begin([
                'layout' => 'default',
                'action' => Url::to(['trainer/index']),
                'method' => 'GET',
                'options' => ['class' => 'filter-form']
            ]); ?>

            <div class="fields-container">

                <?= $form->field($condition, 'name', ['horizontalCssClasses' => ['wrapper' => false, 'offset' => false]],
                    ['options' => ['class' => 'sort-select-field-2']])->widget(Select2::class, [
                    'data' => $nameList,
                    'options' => [
                        'placeholder' => 'Name',
                        'onchange' => 'this.form.submit()',
                        'class' => 'form-control',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'margin' => '0 8px'

                    ]])->label(false) ?>

                <?= $form->field($condition, 'teachcountry_id')
                    ->dropDownList($countryList, [
                        'prompt' => 'Teaching in...',
                        'onchange' => 'this.form.submit()'
                    ])->label(false); ?>

                <?= $form->field($condition, 'lang_id')
                    ->dropDownList($langList, [
                        'prompt' => 'Language',
                        'onchange' => 'this.form.submit()'
                    ])->label(false); ?>

                <?= $form->field($condition, 'service_id', [
                    'horizontalCssClasses' => [
                        'wrapper' => false,
                        'offset' => false,
                        'label' => 'col-sm-12',
                    ],
                    'options' => [
                        'class' => 'filter-checkbox-list form-group'
                    ]
                ])
                    ->checkboxList($serviceList, [
                        'itemOptions' => ['onchange' => 'this.form.submit()']
                    ])
                    ->label('Service'); ?>

                <?php ActiveForm::end(); ?>
            </div>

            <?= Html::a('Clear all filters', ['/trainer/index'], ['class' => 'clear-filter']) ?>
        </div>
    </aside>

    <section class="trainers-grid main-grid" id="main-grid">
        <?= ($trainersNumber == 0) ? '<p class="nothing-found-message">No teachers found :-(</p>' : null ?>

        <ul class="trainers-list">

            <?php foreach ($trainers as $trainer) {

                echo "<li class='item trainer-item'>";

                if ($trainer->languages) {
                    echo '<ul class="lang-flag-list">';

                    foreach ($trainer->languages as $language) {
                        $lang_flag = $language->lang_flag == '' ? $language->lang_code :
                            $language->lang_flag;
                        echo "<li class='lang-flag'><img alt='$lang_flag' src='/img/flags/$lang_flag.svg' /></li>";
                    }

                    echo '</ul>';
                }

                $style = $trainer->thumb ?
                    "style='background:url({$trainer->thumb}) no-repeat center center; background-size: cover'" : null ?>

                <div class='item-thumbnail trainer-thumbnail' <?= $style ?>></div>

                <h2 class='name item-name trainer-name'>
                    <?= Html::a($trainer->fullName, ['/trainer/profile', 'id' => $trainer->id]) ?>
                </h2>

                <?php if ($trainer->services) { ?>

                    <ul class='service-list'>

                        <?php $serviceNewList = '';
                        foreach ($trainer->services as $service) {
                            $serviceNewList .= '<li class="service">' . $service->service_name . '</li> ';
                        } ?>

                        <?= $serviceNewList ?>

                    </ul>

                <?php }

                if ($trainer->teachCountries) { ?>
                    <ul class='teach-country-list'>
                        <?php $profileCountryList = '';
                        foreach ($trainer->teachCountries as $country) {
                            $profileCountryList .= '<li class="teach-country-item">' . $country->country_name . '</li>,' . '&nbsp';
                        }

                        echo substr($profileCountryList, 0, -6); ?>

                    </ul>
                <?php }
                echo '</li>';
            } ?>
        </ul>

        <?= LinkPager::widget([
            'pagination' => $provider->pagination,
        ]); ?>

    </section>
</div>