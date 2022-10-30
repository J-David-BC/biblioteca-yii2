<?php

namespace app\models;

use Yii;
use app\models\User;
use app\models\BookCopie;
use yii\helpers\ArrayHelper;
use yii\db\query;
/**
 * This is the model class for table "loans".
 *
 * @property int $id
 * @property int $days
 * @property string $loan_date
 * @property string|null $return_date
 * @property string $status
 * @property string $status1
 * @property string $status2
 * @property string $status3
 * @property string $created_at
 * @property string $updated_at
 * @property int $users_id
 *
 * @property BookCopie[] $bookCopies
 * @property LoansHasBookCopies[] $loansHasBookCopies
 * @property User $users
 */
class Loan extends \yii\db\ActiveRecord {
    public $libros=[0=>"No aplica",1=>"No aplica",2=>"No aplica"],$libro1,$libro2,$libro3;
    public $ejemplarStatus,$status1,$status2,$status3;
    /**
     * {@inheritdoc} 
     */
    public static function tableName()  {
        return 'loans';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['days', 'loan_date', 'users_id'], 'required'],
            [['days', 'users_id', 'libro1','libro2','libro3'], 'integer' ,'min' => 1],
            [['loan_date', 'return_date', 'created_at', 'updated_at'], 'safe'],
            //['return_date','validateDates'],
            [['status'], 'string'],
            [['users_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['users_id' => 'id']],
            [['status'],'required','on' => 'update'],
        ];
    }

    public function scenarios(){
        $scenarios = parent::scenarios();
        $scenarios['update'] = ['status','status1','status2','status3'];//Scenario Values Only Accepted
	    return $scenarios;
    }

    public function validateDates(){
        if(strtotime($this->return_date) <= strtotime($this->loan_date)){
            $this->addError('loan_date','Please give correct Start and End dates');
            $this->addError('return_date','Please give correct Start and End dates');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'days' => 'Días',
            'loan_date' => 'Fecha del préstamo',
            'return_date' => 'Fecha de regreso',
            'status' => 'Estado',
            //'created_at' => 'Created At',
            //'updated_at' => 'Updated At',
            'users_id' => 'Usuario',
            'libro1' => 'Libro 1',
            'libro2' => 'Libro 2',
            'libro3' => 'Libro 3',
            'status1' => 'Estado del libro 1',
            'status2' => 'Estado del libro 2',
            'status3' => 'Estado del libro 3',
        ];
    }

    /**
     * Gets query for [[BookCopies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookCopies() {
        return $this->hasMany(BookCopie::class, ['id' => 'book_copies_id'])->viaTable('loans_has_book_copies', ['loans_id' => 'id'])->leftJoin('loans_has_book_copies', 'book_copies.id=book_copies_id ')->select('book_copies.*,loan_status');
    }

    /**
     * Gets query for [[LoansHasBookCopies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLoansHasBookCopies() {
        return $this->hasMany(LoansHasBookCopies::class, ['loans_id' => 'id']);
    }


    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers() {
        return $this->hasOne(User::class, ['id' => 'users_id']);
    }

    public function getTitulos(){
        foreach($this->bookCopies as $ejemplar){
            $titulos[]=$ejemplar->books->title;
        }
            
        return implode(", ",$titulos);
    }

    public function getIdBookCopie($bookId){
        return BookCopie::findOne($bookId);
    }

    public function getEjemplares(){
        $query = new Query();
        $ejemplares = $query->select(['book_copies.id AS bc_id', 'books.title AS title'])
        ->from('book_copies')
        ->leftjoin('books','books.id=book_copies.books_id')
        ->where("books.copies>0")
        ->andWhere("book_copies.status='Disponible'")
        ->groupBy("books.id")
        ->all();

        return ArrayHelper::map($ejemplares,'bc_id','title');
    }

    public function getUsuarios(){
        $query = User::find()->all();
        return ArrayHelper::map($query,'id','name');
    }
}
