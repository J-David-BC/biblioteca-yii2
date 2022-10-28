<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\widgets\LinkPager;
/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var $pagination */

$this->title = "Usuario ".$model->name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
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
                'confirm' => '¿Esta seguro de querer eliminar este usuario?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'name',
            'last_name',
            'address',
            'phone_number',
            'email:email',
            'type',
            'school',
            'birth_date',
            //'created_at',
            //'updated_at',
            'status',
            'age',
        ],
    ]) ?>

    <table class="table table-striped table-bordered detail-view">
        <thead>
            <tr>
                <th colspan="6">Historial de préstamos</th>
            </tr>
            <tr>
                <th>#</th>
                <th>ID</th>
                <th>Fecha de préstamo</th>
                <th>Fecha de retorno</th>
                <th>Estado</th>
                <th>Libros</th>
            </tr>
        </thead>
        
        <?php
            $i=0;
            foreach($model->loans as $loan){ $i++;
        ?>
        <tr>
            <td width="10"><?= $i ?></td>
            <td width="10"><?= $loan->id?></td>
            <td width="200"><?= $loan->loan_date?></td>
            <td width="200"><?= $loan->return_date?></td>
            <td width="100"><?= $loan->status ?></td>
            <td><?= $loan->getTitulos() ?></td>
        </tr>
        <?php
            }
        ?>
    </table>
    <?php LinkPager::widget(['pagination'=>$pagination]); ?>

</div>
