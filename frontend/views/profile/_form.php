<?php
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;
/**
 * @var yii\web\View $this
 * @var frontend\models\Profile $model
 * @var yii\widgets\ActiveForm $form
 */
?>
<div class="profile-form">
    <?php $form = ActiveForm::begin([
        'id'=>'congig-form',
        'options'=>['class'=>'form-horizontal'],
        'fieldConfig'=>[
            'template'=>"{label}\n<div class=\"col-lg-3\">
                        {input}</div>\n<div class=\"col-lg-5\">
                        {error}</div>",
            'labelOptions'=>['class'=>'col-lg-2 control-label'],
        ],
    ]); ?>
    <?= $form->field($model, 'first_name')->textInput(['maxlength' => 45]) ?>
    <?= $form->field($model, 'birthdate')->widget(DatePicker::className(),
        [
            'clientOptions' => [
                'dateFormat' => 'yy-mm-dd',
                'changeMonth' => true,
                'changeYear' => true,
                'minDate' => '-110Y',
                'maxDate' => '+0D',
                'yearRange' => "-80:+0"
            ],
            'options' => ['class' => 'form-control']
        ]); ?>
    <?= $form->field($model, 'gender_id')->dropDownList($model->genderList,
        ['prompt' => 'Виберіть значення' ]);?>

    <div class="form-group">
        <div class="col-lg-offset-2 col-lg-11">
            <?= Html::submitButton('Зберегти', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

    <p>Змінити <?=Html::a('пароль', ['/site/change-password'])?>
        або <?=Html::a('email', ['/site/change-email'])?>
    </p>

</div>
