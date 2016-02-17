<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        Помилка сталася коли Веб сервер працював над Вашим запитом.
    </p>
    <p>
        Будь ласка, зв'яжіться з нами, якщо вважаєте, що це помилка сервера. Дякуємо.
    </p>

</div>
