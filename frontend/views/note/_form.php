<?php

use frontend\widgets\dpl\PickList;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\note */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="note-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->textarea(['rows'=>10]); ?>

    <?= $form->field($model, 'note_type_id')->dropDownList($model->noteTypeList,
        ['prompt' => 'Please Choose One']);?>

    <?= PickList::widget([
        'source' => $model -> lowerNotesList,
        'model' => $model,
    ]); ?>

<!--    //= $form->field($model, 'note_type_id')->listBox($model->noteTypeList,['multiple' =>true]); -->

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
