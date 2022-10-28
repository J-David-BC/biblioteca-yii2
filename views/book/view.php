<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Book $model */

$this->title = "Libro: ".$model->title;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="book-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Esta seguro de querer eliminar este libro?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'author',
            'editorial',
            'year',
            'isbn',
            'image',
            'copies',
            'description:ntext',
        ],
    ]) ?>

    

    <table class="table table-striped table-bordered detail-view">
        <tr>
            <th>Ejemplar #</th>
            <th>Disponibilidad</th>
            <th>Fecha de prestamo</th>
            <th>Fecha de retorno</th>
            <th>Usuario</th>
        </tr>
        <?php
            foreach($model->bookCopies as $ejemplar){
        ?>
        <tr>
            <td width="100"><?= $ejemplar->id?></td>
            <td><?= $ejemplar->status ?></td>
            <td><?= $ejemplar->getFechaPrestamo() ?></td>
            <td><?= $ejemplar->getFechaEntrega() ?></td>
            <td><?= $ejemplar->getNombreUsuario() ?></td>
        </tr>
        <?php
            }
        ?>
    </table>
</div>
