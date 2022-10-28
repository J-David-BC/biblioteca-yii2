<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
/** @var yii\web\View $this */
/** @var app\models\Loan $model */
/** @var ActiveForm $form */ 
$estados = [ 'Disponible' => 'Disponible', 'No disponible' => 'No disponible','Retrasado' => 'Retrasado','Perdido' => 'Perdido', 'Prestado' => 'Prestado', ];
?>
<div class="loan-_form"> 
    
    <?php $form = ActiveForm::begin(); $model->co = 3;?>
        <?= $form->field($model, 'status')->dropDownList([ 'En curso' => 'En curso', 'Finalizado' => 'Finalizado', 'Retraso' => 'Retraso', ], ['prompt' => 'Selecciona un estado'])  ?>
        <?= $form->field($model, 'status1')->dropDownList($estados, ['prompt' => 'Selecciona un estado'])->label('Libro: '.$model->libros[0]) ?>
        <?= $form->field($model, 'status2')->dropDownList($estados, ['prompt' => 'Selecciona un estado'])->label('Libro: '.$model->libros[1]) ?>
        <?= $form->field($model, 'status3')->dropDownList($estados, ['prompt' => 'Selecciona un estado'])->label('Libro: '.$model->libros[2]) ?>
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div><!-- loan-_form -->