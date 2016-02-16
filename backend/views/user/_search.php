<?php
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;
use common\models\User;
/* @var $this yii\web\View */
/* @var $model backend\models\search\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="user-search">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <?= $form->field($model, 'id') ?>
    <?= $form->field($model, 'username') ?>
    <?php echo $form->field($model, 'email') ?>
    <?= $form->field($model, 'role_id')->dropDownList(User::getroleList(),
        [ 'prompt' => '- Виберіть роль -' ]);?>
    <?= $form->field($model, 'status_id')->dropDownList($model->statusList,
        [ 'prompt' => '- Виберіть статус -' ]);?>
    <?= $form->field($model, 'created_at')->widget(DatePicker::className(),
        [
            'clientOptions' => [
                'dateFormat' => 'yyyy-mm-dd',
                'timeFormat' => 'hh:mm',
                'changeMonth' => true,
                'changeYear' => true,
            ],
            'options' => ['class' => 'form-control']
        ]); ?>
    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i> Шукати', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Скинути', ['class' => 'btn btn-default']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
