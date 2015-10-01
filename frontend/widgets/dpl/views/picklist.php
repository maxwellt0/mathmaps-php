<?php
use yii\widgets\ActiveForm;

/* @var $model  */
/* @var $source  */
?>
<!--<div class="row">-->
<!--    <div class="col-md-3">-->
<!--        <label for="higher">Використовує:</label>-->
<!--    </div>-->
<!--    <div class="col-md-6"></div>-->
<!--    <div class="col-md-3">-->
<!--        <label for="lower">Використовується у:</label>-->
<!--    </div>-->
<!--</div>-->
<!--<legend></legend>-->

<section>
    <div class="container">
    <div class="row">
        <?php $form = ActiveForm::begin(); ?>
        <div class="col-md-3">
            <div class="input-group">
                <?= $form->field($model, 'higherNotes')->listBox(
                    $model->higherNotesList,
                    [
                        'multiple' =>true,
                        'inputOptions' => ['id' => 'higher', 'size' => 8]
                    ]
                );?>
<!--                <select name="higher" class="form-control" id="higher" size="8" multiple></select>-->
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
                <?php foreach ($source as $note) {
                    echo '<option value="' . $note.
                        '">' . $note. '</option>';
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
                <?= $form->field($model, 'lowerNotes')->
                listBox(
                    $model->lowerNotesList,
                    ['multiple' =>true,]
                );?>
            </div>
        </div>
    </div>
    </div>
</section>

