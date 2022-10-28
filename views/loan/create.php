<?php

use yii\helpers\Html;
/** @var yii\web\View $this */
/** @var app\models\Loan $model */
$this->title = 'Hacer préstamo';
$this->params['breadcrumbs'][] = ['label' => 'Prestamos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="loan-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
