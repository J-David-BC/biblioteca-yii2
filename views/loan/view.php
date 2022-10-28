<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\ActionColumn;
use yii\grid\GridView;
/** @var yii\web\View $this */
/** @var app\models\Loan $model */

$this->title = 'Préstamo';
$this->params['breadcrumbs'][] = ['label' => 'Loans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Esta seguro de querer eliminar este préstamo?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            [
                'label'=>'Usuario',
                'value'=>$model->users->name,
            ],
            'days',
            'loan_date',
            'return_date',
            'status',
        ],
    ]) ?>

    <--<table class="table table-striped table-bordered detail-view">
        <tr>
            <th>Ejemplar #</th>
            <th>Título</th>
            <th>Estado</th>
        </tr>
        <?php
            foreach($model->bookCopies as $ejemplar){
        ?>
        <tr>
            <td width="100"><?= $ejemplar->id?></td>
            <td width="200"><?= $ejemplar->books->title ?></td>
            <td width="100"><?= $ejemplar->status ?></td>
        </tr>
        <?php
            }
        ?>
    </table>-->
</div>
