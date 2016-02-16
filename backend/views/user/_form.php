<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/**
 * @var yii\web\View $this
 * @var common\models\User $model
 * @var yii\widgets\ActiveForm $form
 */
?>
<div class="user-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'status_id')->dropDownList($model->statusList,
        [ 'prompt' => '- Виберіть статус -' ]);?>
    <?= $form->field($model, 'role_id')->dropDownList($model->roleList,
        [ 'prompt' => '- Виберіть роль -' ]);?>
    <?= $form->field($model, 'username')->textInput(['maxlength' => 25]) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => 25]) ?>
    <div class="form-group">
        <?= Html::submitButton('Зберегти', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
