<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "books".
 *
 * @property int $id
 * @property string $title
 * @property string|null $author
 * @property string|null $editorial
 * @property string|null $year
 * @property string|null $isbn
 * @property string|null $section
 * @property string|null $description
 * @property string|null $image
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property BookCopie[] $bookCopies
 */
class Book extends \yii\db\ActiveRecord {

    public $archivo,$oldCopies=0;
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'books';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['title'], 'required'],
            [['year'], 'integer','max' => 3000],
            [['copies'], 'integer', 'min' => 0],
            [['description'], 'string'],
            [['title', 'author', 'editorial','section'], 'string', 'max' => 45],
            [['isbn'], 'string', 'max' => 13],//match,pattern,messagge
            [['archivo'], 'file', 'extensions' => 'jpg,png']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'title' => 'Título',
            'author' => 'Autor',
            'editorial' => 'Editorial',
            'year' => 'Año',
            'isbn' => 'ISBN',
            'section' => 'Sección',
            'copies' => 'Copias',
            'description' => 'Descripción',
            'archivo' => 'Imágen',
        ];
    }

    /**
     * Gets query for [[BookCopies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookCopies() {
        return $this->hasMany(BookCopie::class, ['books_id' => 'id']);
    }
}
