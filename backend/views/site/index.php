<?php
use yii\helpers\Html;
use common\models\ValueHelpers;
/**
 * @var yii\web\View $this
 */
$this->title = 'MathMaps Адмін';
$is_admin = ValueHelpers::getRoleValue('Admin');
?>
<div class="site-index">
    <div class="jumbotron">
        <h1>Вітаємо на MathMaps <i class="fa fa-globe"></i> Адмін!</h1>
        <p class="lead">
            Тепер ти можеш керувати користувачами,
            ролями та хоч цілим світом з цією адмінкою.
        </p>
        <p>
            <?php
            if (!Yii::$app->user->isGuest
                        && Yii::$app->user->identity->role_id >= $is_admin) {
                    echo Html::a(
                        'Керувати користувачами',
                        ['user/index'],
                        ['class' => 'btn btn-lg btn-success']
                    );
            } ?>
        </p>
    </div>
    <div class="body-content">
        <div class="row">
            <div class="col-lg-4">
                <h2>Записи</h2>
                <p>
                    Це місце для управління записами.
                    Ти можеш редагувати записи звідси.
                    Простий та інтуїтивний UI,
                    тільки клікни на посилання знизу щоб почати.
                </p>
                <p>
                    <?php
                    if (!Yii::$app->user->isGuest
                        && Yii::$app->user->identity->role_id >= $is_admin) {
                        echo Html::a('Керувати записами', ['note/index'],
                            ['class' => 'btn btn-default']);
                    }
                    ?>
                </p>
            </div>
            <div class="col-lg-4">
                <h2>Типи записів</h2>
                <p>
                    Звідси можна керувати типами записів.
                    Ти можеш редагувати або видаляти,
                    а також можете створювати типи,
                    просто клікни на посилання знизу щоб почати.
                </p>
                <p>
                    <?php
                    if (!Yii::$app->user->isGuest
                        && Yii::$app->user->identity->role_id >= $is_admin) {
                        echo Html::a('Керувати типами', ['note-type/index'],
                            ['class' => 'btn btn-default']);
                    }
                    ?>
                </p>
            </div>
            <div class="col-lg-4">
                <h2>Світ</h2>
                <p>
                    Хочеш керувати світом?
                    Це місце саме для цього.
                    Простий інтуітивний інтерфейс робить це можливим.
                    Просто клікни на посилання знизу щоб почати.
                </p>
                <p>
                    <?php
                    if (!Yii::$app->user->isGuest
                        && Yii::$app->user->identity->role_id >= $is_admin) {
                        echo Html::a('Керувати світом (в розробці)', ['profile/index'],
                            ['class' => 'btn btn-danger disabled']);
                    }
                    ?>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <h2>Користувачі</h2>
                <p>
                    Це місце для керування користувачами.
                    Ти можеш змінювати статуси та ролі користувачів звідси.
                    Інтерфейс інтуітивно простий в користуванні,
                    просто клікни на посилання знизу щоб почати.
                </p>
                <p>
                    <?php
                    if (!Yii::$app->user->isGuest
                        && Yii::$app->user->identity->role_id >= $is_admin) {
                        echo Html::a('Керувати користувачами', ['user/index'],
                            ['class' => 'btn btn-default']);
                    }
                    ?>
                </p>
            </div>
            <div class="col-lg-4">
                <h2>Ролі</h2>
                <p>
                    Це місце для керування ролями.
                    Ти можеш вирішувати хто є адмін і хто не адмін.
                    Ти можеш додати нові ролі, якщо захочеться, просто клікни
                    на посилання знизу щоб почати.
                </p>
                <p>
                    <?php
                    if (!Yii::$app->user->isGuest
                        && Yii::$app->user->identity->role_id >= $is_admin) {
                        echo Html::a('Керувати ролями', ['role/index'],
                            ['class' => 'btn btn-default']);
                    }
                    ?>
                </p>
            </div>
            <div class="col-lg-4">
                <h2>Профайли</h2>
                <p>
                    Потрібно переглянути профайли?
                    Все потрібне можна знайти тут.
                    Ними легко керувати через цей UI.
                    Просто клікни на посилання знизу щоб керувати профайлами.
                </p>
                <p>
                    <?php
                    if (!Yii::$app->user->isGuest
                            && Yii::$app->user->identity->role_id >= $is_admin) {
                        echo Html::a(
                            'Керувати профайлами',
                            ['profile/index'],
                            ['class' => 'btn btn-default']
                        );
                    } ?>
                </p>
            </div>
        </div>
    </div>
</div>