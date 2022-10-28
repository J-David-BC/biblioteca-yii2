<?php

use app\models\Loan;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
/** @var yii\web\View $this */
/** @var app\models\LoanSearch $searchModel */
$this->title = 'Préstamos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Hacer préstamo', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'label' => 'Usuario',
                'format' => 'html',
                'value'  => function ($data){ return $data->users->name; },
            ],
            'loan_date',
            'return_date',
            'days',
            'status',
            //'type',
            //'school',
            //'birth_date',
            //'created_at',
            //'updated_at',
            //'status',
            //'age',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Loan $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

</div>