<?php

use yii\helpers\Html;
/** @var yii\web\View $this *
 * /** @var app\models\Loan $model */
 $this->title = 'Actualizar préstamo: ' . $model->id;
 $this->params['breadcrumbs'][] = ['label' => 'Loans', 'url' => ['index']];
 $this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
 $this->params['breadcrumbs'][] = 'Update';
?>
<div class=loan-update>
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        You may change the content of this page by modifying
        the file <code><?= __FILE__; ?></code>.
    </p>
    <?= $this->render('_formUpdate', [
        'model' => $model,
    ]) ?>
</div>

