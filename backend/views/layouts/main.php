<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\models\ValueHelpers;
use backend\assets\FontAwesomeAsset;

/**
 * @var \yii\web\View $this
 * @var string $content
 */
AppAsset::register($this);
FontAwesomeAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport"
              content="width=device-width,initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">
<?php
$is_admin = ValueHelpers::getRoleValue('Admin');
if (!Yii::$app->user->isGuest) {
    NavBar::begin([
        'brandLabel' => 'MathMaps <i class="fa fa-globe"></i> Адмін',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
} else {
    NavBar::begin([
        'brandLabel' => 'MathMaps <i class="fa fa-globe"></i>',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
} // it would be somewhere else
    $menuItems = [
        ['label' => 'Головна', 'url' => ['/site/index']],
    ];
    if (!Yii::$app->user->isGuest
        && Yii::$app->user->identity->role_id >= $is_admin
    ) {
        $userDdown = [];
        $userDdown[] = ['label' => 'Користувачі', 'url' => ['user/index']];
        $userDdown[] = ['label' => 'Профайли', 'url' => ['profile/index']];
        $userDdown[] =  ['label' => 'Ролі', 'url' => ['/role/index']];
        $userDdown[] = ['label' => 'Статуси', 'url' => ['/status/index']];

        $noteDdown = [];
        $noteDdown[] = ['label' => 'Записи', 'url' => ['note/index']];
        $noteDdown[] = ['label' => 'Типи', 'url' => ['note-type/index']];
        $noteDdown[] = ['label' => 'Статуси', 'url' => ['note-status/index']];

    }
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Вхід', 'url' => ['/site/login']];
    } else {
        $ddownItems = [];
        $ddownItems[] = [
            'label' => 'Вийти',
            'url' => ['/site/logout'],
            'linkOptions' => ['data-method' => 'post']
        ];

        $menuItems[] = [
            'label' => 'Записи',
            'items' => $noteDdown,
            'options' => ['style' => 'font-weight: bold']
        ];

        $menuItems[] = [
            'label' => 'Користувачі',
            'items' => $userDdown,
            'options' => ['style' => 'font-weight: bold']
        ];

        $menuItems[] = [
            'label' => Yii::$app->user->identity->username,
            'items' => $ddownItems,
            'options' => ['style' => 'font-weight: bold']
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
?>
    <div class="container main-container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ?
                $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
    </div>
    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; MathMaps <?= date('Y') ?></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>