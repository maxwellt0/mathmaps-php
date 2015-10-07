<?php

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

    <div class="row">
        <div class="col-md-3">
            <div class="input-group">
                <?= $form->field(
                    $model,
                    'higherNotes',
                    ['inputOptions'=>['size'=>8]]
                )->listBox(
                    $model->higherNotesList,
                    ['multiple' =>true]
                );?>
            </div>
        </div>

        <div class="col-md-1">
            <a id="toHigher" class="btn btn-info btn-add">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            </a>
            <a id="fromHigher" class="btn btn-default btn-add">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            </a>
        </div>

        <div class="col-md-4">
            <label for="assocNotes">Непід'єднані записи</label>
            <select class="form-control" id="assocNotes" size="8" multiple title="Непід'єднані записи">
                <?php foreach ($model -> otherNotesList as $id => $name) {
                    echo '<option value="' . $id . '">' . $name . '</option>';
                } ?>
            </select>
        </div>

        <div class="col-md-1">
            <a id="toLower" class="btn btn-info btn-add">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            </a>
            <a id="fromLower" class="btn btn-default btn-add">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            </a>
        </div>

        <div class="col-md-3">
            <div class="input-group">
                <?= $form->field(
                    $model,
                    'lowerNotes',
                    ['inputOptions'=>['size'=>8]]
                )->listBox(
                    $model->lowerNotesList,
                    ['multiple' =>true,]
                );?>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update',
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    $("#fromLower").click(function () {
        var selectedItem = $("#note-lowernotes option:selected");
        $("#assocNotes").append(selectedItem);
    });

    $("#toLower").click(function () {
        var selectedItem = $("#assocNotes option:selected");
        $("#note-lowernotes").append(selectedItem);
    });

    $("#fromHigher").click(function () {
        var selectedItem = $("#note-highernotes option:selected");
        $("#assocNotes").append(selectedItem);
    });

    $("#toHigher").click(function () {
        var selectedItem = $("#assocNotes option:selected");
        $("#note-highernotes").append(selectedItem);
    });
</script>
