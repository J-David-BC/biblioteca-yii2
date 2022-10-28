<?php

namespace app\controllers;

use app\models\BookCopie;
use app\models\BookCopieSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class BookCopieController extends \yii\web\Controller {

    public function actionCreate($book_id) {
        $model = new BookCopie();
        $model->books_id = $book_id;
        if($this->request->isPost) {
            if($model->load($this->request->post()) && $model->save()){
                return $this->redirect(['view','id'=>$model->id]);
            }
        } else {  $model->loadDefaultValues(); }

        return $this->render('create');
    }

    public function actionIndex() {
        $searchModel = new BookCopieSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate() {
        return $this->render('update');
    }

    public function actionView($id) {
        return $this->render('view',[
            'model' => $this->findModel($id)
        ],);
    }

}
