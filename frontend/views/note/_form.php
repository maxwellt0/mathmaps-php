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
                <?= $form->field($model, 'higherNotesList')->listBox(
                    $model->higherNotesList,
                    ['multiple' =>true,]
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
            <select class="form-control" id="assocNotes" size="8" multiple>
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
                <?= $form->field($model, 'lowerNotesList')->listBox(
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
    /**
     * Created by Maxwellt on 01.10.2015.
     */
    $("#fromLower").click(function () {
        var selectedItem = $("#note-lowernoteslist option:selected");
        $("#assocNotes").append(selectedItem);
    });

    $("#toLower").click(function () {
        var selectedItem = $("#assocNotes option:selected");
        $("#note-lowernoteslist").append(selectedItem);
    });

    $("#fromHigher").click(function () {
        var selectedItem = $("#note-highernoteslist option:selected");
        $("#assocNotes").append(selectedItem);
    });

    $("#toHigher").click(function () {
        var selectedItem = $("#assocNotes option:selected");
        $("#note-highernoteslist").append(selectedItem);
    });
</script>
