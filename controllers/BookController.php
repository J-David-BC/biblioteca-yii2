<?php

namespace app\controllers;

use Yii;
use app\models\Book;
use app\models\BookCopie;
use app\models\BookSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
//use yii\filters\AccessControl;
use yii\web\UploadedFile;
use app\controllers\BookCopieController;
/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends Controller {

    /**
     * @inheritDoc
     */
    public function behaviors() {
        return array_merge(
            parent::behaviors(),
            [   //Para acceso de usuarios loggeados
                /* 'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [['allow'=>true,'roles'=>['@']]]
                ], */
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ] 
        );
    }

    /**
     * Lists all Book models.
     *
     * @return string
     */
    public function actionIndex() {
        $searchModel = new BookSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Book model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Book model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate() {
        $model = new Book();
        if ($this->request->isPost && $model->load(Yii::$app->request->post())) {
            $model->archivo=UploadedFile::getInstance($model,'archivo');
            if($model->validate() && $model->archivo){
                $this->upload($model);
                for($i = 0; $i < $model->copies; $i++){
                    $this->crearBookCopie($model->id);}
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function crearBookCopie($book_id){
        $modelBookCopie = new BookCopie();
        $modelBookCopie->books_id = $book_id;
        if($this->request->isPost&&$modelBookCopie->save()){
            return true;    
        } else { $modelBookCopie->loadDefaultValues(); }
        return false;
    }

    /**
     * Updates an existing Book model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $model->oldCopies = $model->copies;
        if ($this->request->isPost && $model->load(Yii::$app->request->post())) {

            $model->archivo=UploadedFile::getInstance($model,'archivo');
            if($model->validate()){
                $this->upload($model);
                for($i = $model->oldCopies; $i < $model->copies; $i++){
                    $this->crearBookCopie($model->id);}
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                $errors = $model->errors;
            }
        }
        return $this->render('update', [ 'model' => $model, ]);
    }

    /**
     * Deletes an existing Book model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id){
        $model = $this->findModel($id);
        if(file_exists($model->image)) unlink($model->image);
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Book model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Book the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id){
        if (($model = Book::findOne(['id' => $id])) !== null) {
            //$model->bookCopies = $model->getBookCopies();//BookCopies::find()->where(['book_id'=>$id])->one();
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function subirFoto(Book $model) {
        echo "<script>console.log('Punto de control 1. empieza función subirFoto.' );</script>";
        
        if (Yii::$app->request->isPost) {
            echo "<script>console.log('Punto de control 2. Condicional superada Yii::isPost.' );</script>";
            $model->archivo = UploadedFile::getInstance($model, 'archivo');
            echo "<script>console.log('Punto de control 3. Instancia obtenida del archivo.' );</script>";
            if ($model->upload()) {
                // file is uploaded successfully
                echo "<script>console.log('Punto de control 4. Condicional superada archivo subido' );</script>";
                return true;
            }
            echo "<script>console.log('Punto de control 4. Condicional fallida: archivo subido' );</script>";
        }
        echo "<script>console.log('Punto de control 2. Condicional fallida: Yii::isPost' );</script>";
        return false;
    }
    protected function upload(Book $model){
        if($model->archivo){
            if(file_exists($model->image)) unlink($model->image);
            $pathImage = 'uploads/'.time()."_".$model->archivo->basename.".".$model->archivo->extension;
            $model->image = $pathImage;
            $model->save();
            $model->archivo->saveAs($pathImage);
        } else { $model->save(); }
    } 
}
