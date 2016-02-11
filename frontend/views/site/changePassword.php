<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Зміна паролю';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-change-password">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Будь ласка, заповніть всі поля для зміни паролю :</p>

    <?php $form = ActiveForm::begin([
        'id'=>'change-password-form',
        'options'=>['class'=>'form-horizontal'],
        'fieldConfig'=>[
            'template'=>"{label}\n<div class=\"col-lg-3\">
                        {input}</div>\n<div class=\"col-lg-5\">
                        {error}</div>",
            'labelOptions'=>['class'=>'col-lg-2 control-label'],
        ],
    ]); ?>
    <?= $form->field($model,'oldpass',['inputOptions'=>[
        'placeholder'=>'Старий пароль'
    ]])->passwordInput() ?>

    <?= $form->field($model,'newpass',['inputOptions'=>[
        'placeholder'=>'Новий пароль'
    ]])->passwordInput() ?>

    <?= $form->field($model,'repeatnewpass',['inputOptions'=>[
        'placeholder'=>'Повторіть новий пароль'
    ]])->passwordInput() ?>

    <div class="form-group">
        <div class="col-lg-offset-2 col-lg-11">
            <?= Html::submitButton('Зберегти',[
                'class'=>'btn btn-primary'
            ]) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>