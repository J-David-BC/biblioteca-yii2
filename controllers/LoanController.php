<?php

namespace app\controllers;

use Yii;
use app\models\Loan;
use app\models\LoanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class LoanController extends Controller {

    public function actionCreate()  {
        $model = new Loan();
        if($this->request->isPost&&$model->load($this->request->post())){
            $model->loan_date = date("Y-m-d",strtotime($model->loan_date));
            $model->return_date = date("Y-m-d",strtotime('+'.$model->days.' day',strtotime($model->loan_date)));
            $libros = array_unique(array($model->libro1,$model->libro2,$model->libro3));
            //print_r($libros);
            if($model->validate()&&$model->save()){
                foreach ($libros as $idl) {
                    if(!empty($idl)){
                        $bookCopie = $model->getIdBookCopie($idl);
                        $bookCopie->status = "Prestado";
                        //$bookCopie->loan_status = "Prestado";
                        if($bookCopie!=null){
                            $model->link('bookCopies',$bookCopie);
                        }
                        $bookCopie->extraerLoanStatus($model->id);
                        $bookCopie->save();
                    }
                }
                return $this->redirect(['view','id'=>$model->id]);
            } 
        } else {  $model->loadDefaultValues(); }
        return $this->render('create', ['model'=> $model]);
    }

    public function actionIndex() {
        $searchModel = new LoanSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function obtenerIndex(){
        $searchModel = new LoanSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        return [$searchModel, $dataProvider];
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $i=0;
        foreach($model->bookCopies as $ejemplar){
            $model->libros[$i] = $ejemplar->books->title;
            $i++;
        }
        $model->scenario = "update";
        if($this->request->isPost && $model->load($this->request->post())){
            $model->ejemplarStatus = array($model->status1,$model->status2,$model->status3);
            print_r($model->ejemplarStatus);
            if($model->validate()&&$model->save()){
                $i=0;
                foreach($model->bookCopies as $ejemplar){
                    if(!empty($model->ejemplarStatus[$i])){
                        $ejemplar->status=$model->ejemplarStatus[$i];
                        switch ($ejemplar->status) {
                            case 'Retrasado':
                                $ejemplar->loan_status="No devuelto";
                                break;
                            case 'Perdido':
                                $ejemplar->loan_status="No devuelto";
                                break;
                            case 'Disponible':
                                $ejemplar->loan_status="Devuelto a tiempo";
                                break;
                            case 'Prestado':
                                $ejemplar->loan_status="Prestado";
                                break;
                            default:
                                $ejemplar->loan_status="Prestado";
                                break;
                        }
                        $ejemplar->actualizar($id);
                    }
                    $i++;
                    $ejemplar->save();
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('update', ['model' =>$model]);

    }

    public function actionView($id) {
        return $this->render('view',['model' => $this->findModel($id)],);
    }

    protected function findModel($id){
        if (($model = Loan::findOne(['id' => $id])) !== null) {
            //$model->bookCopies = $model->getBookCopies();//BookCopies::find()->where(['book_id'=>$id])->one();
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
}
