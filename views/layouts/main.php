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
        <meta http-equiv="Content-Language" content="en">
        <link rel="shortcut icon" href="/favicon.ico"/>
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-144204946-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());

            gtag('config', 'UA-144204946-1');
        </script>
        <script type="application/ld+json">
 "@context": "https://schema.org/",
  "@type": "Website",
  "name": "Liberty Academy"
        </script>

        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php
        $this->registerMetaTag(['og:site_name' => 'Liberty Academy']);
        $this->head()
        ?>
        <style>
            @import url('https://fonts.googleapis.com/css?family=Lato:300,400,700,900|Open+Sans:400,600,700'); /* todo */
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
                    <nav class="main-nav" data-content-field="navigation">

                <span class="menu-icon" id="menu-icon">
                    <span></span>
                    <span></span>
                </span>
                        <ul class="site-nav header-site-nav">
                            <li><?= Html::a('Teachers', ['/trainer/index']) ?></li>
                            <li><?= Html::a('Articles', ['/article/index']) ?></li>
                            <li><?= Html::a('Events', ['/event/index']) ?></li>
                        </ul>

                    </nav>

                    <?= Html::a('<img src="/img/logo.png" width="130" height="37" alt="Liberty Academy" />',
                        '/site/index', ['class' => 'logo header-logo']) ?>

                    <ul class="user-nav">
                        <?php
                        if (!Yii::$app->user->isGuest) {

                            $user = Trainer::findOne(Yii::$app->user->id);

                            echo "<li class='dropdown-account'><span class='username'>" .
                                Html::a($user->name . " " . $user->surname, ['/trainer/profile', 'id' => Yii::$app->user->id]) .
                                "</span><p class='user-avatar'>" .
                                ($user->thumb != '' ? "<img src='$user->thumb' alt='$user->fullName' />" : null) .
                                "</p>" .

                                '<ul class="sub-menu user-sub-menu">' .
                                '<li>' . Html::a('Update profile', ['/trainer/update']) . '</li>' .
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
                            <li><?= Html::a('Events', ['/event/index']) ?></li>
                        </ul>
                    </section>
                    <section class="header-sub-menu-links user-links">
                        <h4>For teachers</h4>
                        <ul>
                            <?php
                            if (!Yii::$app->user->isGuest) {

                                $user = Trainer::findOne(Yii::$app->user->id);

                                echo '<li>' . Html::a('Update profile', ['/trainer/update']) . '</li>' .
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
                <?= Html::a("<img src='/img/logo.png' width='186' alt='Liberty Academy' />", ['/site/index'], ['class' => 'logo footer-logo']) ?>

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
                        <li><?= Html::a('Events', ['/event/index']) ?></li>
                    </ul>
                </section>
                <section class="footer-links footer-user-links">
                    <h4>For teachers</h4>
                    <ul>
                        <?php
                        if (!Yii::$app->user->isGuest) {

                            $user = Trainer::findOne(Yii::$app->user->id);

                            echo '<li>' . Html::a('Update profile') . '</li>' .
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
            <p class="footer-info">
                <?= Html::a('<svg xmlns="http://www.w3.org/2000/svg" width="33" height="33" viewBox="0 0 24 24"><path d="M22.367 6.266c-1.07-1.84-2.527-3.293-4.363-4.363s-3.84-1.61-6.016-1.61-4.18.535-6.02 1.61-3.29 2.523-4.36 4.363S0 10.105 0 12.28c0 2.61.762 4.96 2.285 7.047s3.496 3.53 5.9 4.332c.28.05.488.016.625-.11a.62.62 0 0 0 .203-.469l-.02-2.23-.355.063c-.23.04-.52.06-.867.055s-.71-.043-1.086-.11a2.5 2.5 0 0 1-1.047-.469c-.32-.246-.55-.566-.684-.96l-.156-.36c-.105-.238-.27-.504-.492-.797s-.45-.488-.68-.6l-.11-.082c-.074-.05-.14-.113-.203-.187s-.11-.145-.14-.215-.004-.133.078-.18.234-.07.453-.07l.313.047c.207.04.465.164.773.37a2.55 2.55 0 0 1 .754.813c.242.426.53.754.867.977s.68.336 1.023.336a4.52 4.52 0 0 0 .891-.078c.25-.05.484-.13.7-.234.094-.7.352-1.234.766-1.61-.594-.062-1.125-.156-1.598-.28a6.36 6.36 0 0 1-1.469-.605c-.504-.28-.922-.633-1.258-1.047s-.605-.965-.816-1.64-.32-1.457-.32-2.34c0-1.258.4-2.332 1.23-3.215-.383-.95-.348-2.008.11-3.184.305-.094.75-.023 1.344.21s1.027.434 1.305.598l.664.422a11.09 11.09 0 0 1 2.996-.406c1.027 0 2.027.137 2.996.406l.594-.375c.406-.25.883-.477 1.434-.684s.977-.266 1.266-.172c.47 1.176.512 2.234.125 3.184.824.883 1.234 1.957 1.234 3.215 0 .883-.11 1.668-.32 2.348s-.488 1.23-.828 1.64a4.32 4.32 0 0 1-1.266 1.039c-.504.277-.992.48-1.465.605s-1.008.22-1.602.28c.543.47.813 1.207.813 2.22v3.293c0 .188.066.344.195.47s.336.16.617.11c2.414-.8 4.383-2.246 5.906-4.332a11.66 11.66 0 0 0 2.289-7.047c0-2.176-.54-4.18-1.61-6.016zm0 0" fill="rgb(0%,0%,0%)"/></svg>Source code', 'https://github.com/kamennova/LibertyAcademy', ['class' => 'dev-info']) ?>
                | <span class="footer-copyright">© Copyright 2019</span>
            </p>
        </footer>
    </div>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>