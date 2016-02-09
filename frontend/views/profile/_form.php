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
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'first_name')->textInput(['maxlength' => 45]) ?>
    <br/>
    <?= $form->field($model, 'birthdate')->widget(DatePicker::className(),
        [
            'clientOptions' => ['dateFormat' => 'yyyy-mm-dd'],
            'options' => ['class' => 'form-control']
        ]); ?>
    <br/>
    <?= $form->field($model, 'gender_id')->dropDownList($model->genderList,
        ['prompt' => 'Виберіть значення' ]);?>
    <div class="form-group">
        <?= Html::submitButton('Зберегти', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
