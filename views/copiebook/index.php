<?php

use app\models\BookCopie;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */

$this->title = 'Ejemplares';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book_copies-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        You may change the content of this page by modifying
        the file <code><?= __FILE__; ?></code>.
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'status',
            [
                'class' =>ActionColumn::className(),
                'urlCreator' => function ($action, BookCopie $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ]
        ]
    ]);?>
</div>

