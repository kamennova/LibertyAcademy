<?php
/* @var $this \yii\web\View */

/* @var $content string */

use app\models\Trainer;
use yii\helpers\Html;
use app\assets\AppAsset;

AppAsset::register($this); ?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/favicon.ico"/>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Lato:300,400,700,900|Open+Sans:400,600,700|Roboto:300,400');
    </style>
</head>
<body>

<?php $this->beginBody() ?>
<div class="page-wrapper">

    <header class="main-header">
        <div class="main-header-wrapper transparent">
            <?php
            $controllerName = Yii::$app->controller->id;
            if ($controllerName !== 'site') {
                $this->registerCss(".header-site-nav a[href='/$controllerName/index']::after {
   content: \"\";

  position: absolute;
  top: 50px;
  left: 0;
  right: 0;

  display: block;
  width: 60px;
  height: 3px;
  margin: 0 auto;

  background-color: #303030;

  z-index: 10000;
}");
            } ?>

            <div class="site-container">
                <nav class="main-nav">

                <span class="menu-icon" id="menu-icon">
                    <span></span>
                    <span></span>
                </span>
                    <ul class="site-nav header-site-nav">
                        <li><?= Html::a('Teachers', ['/trainer/index']) ?></li>
                        <li><?= Html::a('Articles', ['/article/index']) ?></li>
                        <li><?= Html::a('Workshops', ['/event/index']) ?></li>
                    </ul>

                </nav>

                <?= Html::a('<img src="/img/logo2.png" width="130" height="37" alt="Liberty Academy" />', '/site/index', ['class' => 'logo header-logo']) ?>

                <ul class="user-nav">
                    <?php
                    if (!Yii::$app->user->isGuest) {

                        $user = Trainer::findOne(Yii::$app->user->id);

                        echo "<li class='dropdown-account'><span class='username'>" .
                            Html::a($user->name . " " . $user->surname, ['/trainer/profile', 'id' => Yii::$app->user->id]) .
                            "</span><p class='user-avatar'>" .
                            ($user->thumb != '' ? "<img src='$user->thumb' />" : null) .
                            "</p>" .

                            '<ul class="sub-menu user-sub-menu">' .
                            '<li>' . Html::a('Update profile', ['/trainer/update', 'id' => Yii::$app->user->id]) . '</li>' .
                            '<li>' . Html::a('My articles', ['/trainer/myarticles']) . '</li>' .
                            '<li>' . Html::a('My events', ['/trainer/myevents']) . '</li>' .
                            '<li>' .
                            Html::beginForm(['/site/logout'], 'post', ['class' => '']) .
                            Html::submitButton(
                                'Log out',
                                ['class' => 'enter logout']
                            ) . '</li></ul>';
                        echo Html::endForm() . '</li><li>';
                    } else {
                        echo '<li>' . Html::a('Join teachers', ['/trainer/register'], ['class' => 'btn btn-join']) . '</li>';
                    }
                    ?>
                </ul>

            </div>
        </div>

        <div class="sub-menu main-nav-sub-menu">
            <div class="site-container">
                <section class="header-sub-menu-links academy-links">
                    <h4>Academy</h4>
                    <ul>
                        <li><?= Html::a('Home', ['/site/index']) ?></li>
                        <li><?= Html::a('About', ['/site/about']) ?></li>
                        <li><?= Html::a('Contact', ['/site/contact']) ?></li>
                    </ul>
                </section>
                <section class="header-sub-menu-links study-materials-links">
                    <h4>Learning liberty</h4>
                    <ul>
                        <li><?= Html::a('Teachers', ['/trainer/index']) ?></li>
                        <li><?= Html::a('Articles', ['/article/index']) ?></li>
                        <li><?= Html::a('Workshops', ['/event/index']) ?></li>
                        <li><?= Html::a('Internship', ['/site/internship']) ?></li>
                    </ul>
                </section>
                <section class="header-sub-menu-links user-links">
                    <h4>For teachers</h4>
                    <ul>
                        <?php
                        if (!Yii::$app->user->isGuest) {

                            $user = Trainer::findOne(Yii::$app->user->id);

                            echo '<li>' . Html::a('Update profile', ['/trainer/update', 'id' => Yii::$app->user->id]) . '</li>' .
                                '<li>' . Html::a('My articles', ['/trainer/myarticles']) . '</li>' .
                                '<li>' . Html::a('My events', ['/trainer/myevents', 'id' => Yii::$app->user->id]) . '</li>' .
                                '<li>' .
                                Html::beginForm(['/site/logout'], 'post', ['class' => '']) .
                                Html::submitButton(
                                    'Log out',
                                    ['class' => 'enter login']
                                ) . '</li>';
                            echo Html::endForm();
                        } else {
                            echo '<li>' . Html::a('Register', ['/trainer/register']) . '</li>' .
                                '<li>' . Html::a('Log in', ['/trainer/login']) . '</li>';
                        }
                        ?>
                    </ul>
                </section>
            </div>
        </div>
    </header>

    <main class="site-content">
        <?= $content ?>
    </main>

    <footer class="main-footer">

        <div class="page-container">
            <?= Html::a("<img src='/img/logo2.png' width='186'  alt='Liberty Academy' />", ['/site/index'], ['class' => 'logo footer-logo']) ?>

            <section class="footer-links footer-academy-links">
                <h4>Academy</h4>
                <ul>
                    <li><?= Html::a('Home', ['/site/index']) ?></li>
                    <li><?= Html::a('About', ['/site/about']) ?></li>
                    <li><?= Html::a('Contact', ['/site/contact']) ?></li>
                </ul>
            </section>
            <section class="footer-links footer-study-materials-links">
                <h4>Learning liberty</h4>
                <ul>
                    <li><?= Html::a('Teachers', ['/trainer/index']) ?></li>
                    <li><?= Html::a('Articles', ['/article/index']) ?></li>
                    <li><?= Html::a('Workshops', ['/event/index']) ?></li>
                    <li><?= Html::a('Internship', ['/site/internship']) ?></li>
                </ul>
            </section>
            <section class="footer-links footer-user-links">
                <h4>For teachers</h4>
                <ul>
                    <?php
                    if (!Yii::$app->user->isGuest) {

                        $user = Trainer::findOne(Yii::$app->user->id);

                        echo '<li>' . Html::a('Update profile', ['/trainer/view', 'id' => Yii::$app->user->id]) . '</li>' .
                            '<li>' . Html::a('My articles', ['/trainer/myarticles']) . '</li>' .
                            '<li>' . Html::a('My events', ['/trainer/myevents', 'id' => Yii::$app->user->id]) . '</li>' .
                            '<li>' .
                            Html::beginForm(['/site/logout'], 'post', ['class' => '']) .
                            Html::submitButton(
                                'Log out',
                                ['class' => 'enter login']
                            ) . '</li>';
                        echo Html::endForm();
                    } else {
                        echo '<li>' . Html::a('Register', ['/trainer/register']) . '</li>' .
                            '<li>' . Html::a('Log in', ['/trainer/login']) . '</li>';
                    }
                    ?>
                </ul>
            </section>
        </div>
        <span class="footer-copyright">© Copyright 2018</span>
    </footer>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>