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

    <?= $form->field($model, 'note_type_id')
        ->dropDownList(
            $model->noteTypeList,
            ['prompt' => '- Виберіть тип запису -']
        );?>

    <div class="row">
        <div class="col-md-3">
            <div class="input-group list-box-div">
                <?= $form->field(
                    $model,
                    'higherNotes'
                )->listBox(
                    $model->higherNotesList,
                    ['multiple' =>true, 'class' => 'form-control list-box', 'size' => '8']
                )->label('Використовує:');?>
            </div>
        </div>

        <div class="col-md-1">
            <a id="toHigher" class="btn btn-info link-button">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            </a>
            <a id="fromHigher" class="btn btn-default link-button">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            </a>
        </div>

        <div class="col-md-4">
            <label for="assocNotes">Непід'єднані записи</label>
            <select class="form-control link-form" id="assocNotes"  multiple title="Непід'єднані записи" size="8">
                <?php foreach ($model -> otherNotesList as $id => $name) {
                    echo '<option value="' . $id . '">' . $name . '</option>';
                } ?>
            </select>
        </div>

        <div class="col-md-1">
            <a id="toLower" class="btn btn-info link-button">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            </a>
            <a id="fromLower" class="btn btn-default link-button">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            </a>
        </div>

        <div class="col-md-3">
            <div class="input-group list-box-div">
                <?= $form->field(
                    $model,
                    'lowerNotes'
                )->listBox(
                    $model->lowerNotesList,
                    ['multiple' =>true, 'class' => 'form-control list-box', 'size' => '8']
                )->label('Використовується у:');?>
            </div>
        </div>
    </div>
<br>
    <div class="form-group">
        <?php
            $cancelLink = $model->isNewRecord ? ['/profile'] : ['view', 'id' => $model->id];
            echo Html::submitButton($model->isNewRecord ? 'Створити' : 'Зберегти',
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
            echo Html::a('Відміна', $cancelLink, ['class' => 'btn']);
        ?>
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
