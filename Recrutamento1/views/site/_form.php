<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

?>

<?php $form = ActiveForm::begin([
    'id' => 'form-edit-tarefa',
    'options' => ['class' => 'form-horizontal'],
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'validationUrl' => ['site/validate-tarefa'],
    'validateOnSubmit' => true,
]); ?>

<?= $form->field($model, 'TituloTarefa')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'Descricao')->textarea(['rows' => 6]) ?>

<?= $form->field($model, 'DataCriacao')->textInput(['type' => 'date']) ?>

<?= $form->field($model, 'DataConclusao')->textInput(['type' => 'date']) ?>

<?= $form->field($model, 'Estado')->dropDownList(['Em Curso' => 'Em Curso', 'Finalizado' => 'Finalizado', 'Pendente' => 'Pendente']) ?>

<div class="form-group">
    <div class="col-sm-offset-3 col-sm-6">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-primary']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
