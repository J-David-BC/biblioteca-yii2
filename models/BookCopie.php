<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\db\query;
/**
 * This is the model class for table "book_copies".
 *
 * @property int $id
 * @property string $status
 * @property int $books_id
 * @property Book $books
 * @property Loans[] $loans
 * @property LoansHasBookCopies[] $loansHasBookCopies
 */
class BookCopie extends \yii\db\ActiveRecord{
    public $loan_status;
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'book_copies';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['status'], 'string'],
            [['books_id'], 'required'],
            [['books_id'], 'integer'],
            [['books_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::class, 'targetAttribute' => ['books_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'status' => Yii::t('app', 'Status'),
            'books_id' => Yii::t('app', 'Books ID'),
        ];
    }

    /**
     * Gets query for [[Books]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBooks() {
        return $this->hasOne(Book::class, ['id' => 'books_id']);
    }

    /**
     * Gets query for [[Loans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLoans() {
        return $this->hasMany(Loan::class, ['id' => 'loans_id'])->viaTable('loans_has_book_copies', ['book_copies_id' => 'id']);
    }

    public function getPrestamo(){
        if($this->status=="Prestado"||$this->status=="Retrasado"){
            $prestamo = Loan::findOne(["id"=>$this->getLoans()->max("id")]);
            return $prestamo;
        }else
            return "No aplica.";
    }

    public function getNombreUsuario(){
        if(!is_string($this->getPrestamo()))
            return $this->getPrestamo()->users->name;
        return "No aplica";
    }

    public function getFechaPrestamo(){
        if(!is_string($this->getPrestamo()))
            return $this->getPrestamo()->loan_date;
        return "No aplica";
    }

    public function getFechaEntrega(){
        if(!is_string($this->getPrestamo()))
            return $this->getPrestamo()->return_date;
        return "No aplica";
    }

    public function actualizar($id){
        $query = new Query();
        $query->createCommand()->update("loans_has_book_copies",["loan_status"=>$this->loan_status],'book_copies_id='.$this->id.' AND loans_id='.$id)->execute();
        //$query->update('loans_has_book_copies',['loan_status'=>$this->loan_status],' book_copies_id='.$this->id.' AND loans_id='.$id);
    }

    public function extraerLoanStatus($loan_id){
        $query = new Query();
        $loan_status = $query->select(["loan_status"])->from("loans_has_book_copies")->where(["loans_id"=>$loan_id,"book_copies_id"=>$this->id])->one();
    }

    /**
     * Gets query for [[LoansHasBookCopies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLoansHasBookCopies() {
        return $this->hasMany(LoansHasBookCopies::class, ['book_copies_id' => 'id']);
    }
}
