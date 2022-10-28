<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
/** @var yii\web\View $this */
/** @var app\models\Loan $model */
/** @var ActiveForm $form */ 
?>
<div class="loan-_form"> 
    
    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'days')->textInput(['type' => 'number']) ?>
        <?= $form->field($model, 'loan_date')->widget(DatePicker::className(),['options'=> ['class' => 'form-control'],'dateFormat' => 'dd-MM-yyyy','clientOptions' => [ 'onSelect' => new yii\web\JsExpression('function(selected) { var dt = new Date(selected); dt.setDate(dt.getDate() + 1); $("#filter-date-to").datepicker("option", "minDate", dt); }')]])  ?>
        <?= $form->field($model, 'users_id')->dropDownList($model->getUsuarios(), ['prompt' => 'Selecciona un usuario']) ?>
        <?= $form->field($model, 'libro1')->dropDownList($model->getEjemplares(), ['prompt' => 'Selecciona un libro']) ?>
        <?= $form->field($model, 'libro2')->dropDownList($model->getEjemplares(), ['prompt' => 'Selecciona un libro']) ?>
        <?= $form->field($model, 'libro3')->dropDownList($model->getEjemplares(), ['prompt' => 'Selecciona un libro']) ?>
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div><!-- loan-_form -->
