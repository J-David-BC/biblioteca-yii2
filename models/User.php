<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $name
 * @property string|null $last_name
 * @property string|null $address
 * @property string|null $phone_number
 * @property string|null $email
 * @property string $type
 * @property string|null $school
 * @property string|null $birth_date
 * @property string $created_at
 * @property string $updated_at
 * @property string $status
 * @property int|null $age
 *
 * @property Loans[] $loans
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['name'], 'required'],
            [['type', 'status'], 'string'],
            [['birth_date', 'created_at', 'updated_at'], 'safe'],
            [['birth_date'],'date', 'format' => 'yyyy-MM-dd'],
            [['age'], 'integer'],
            [['name', 'last_name', 'address', 'school'], 'string', 'max' => 45],
            [['email'],'email'],
            [['phone_number'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nombre',
            'last_name' => 'Apellido',
            'address' => 'Dirección',
            'phone_number' => 'Número de telefóno',
            'email' => 'Email',
            'type' => 'Tipo',
            'school' => 'Escuela',
            'birth_date' => 'Fecha de nacimiento',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Estado',
            'age' => 'Edad',
        ];
    }

    /**
     * Gets query for [[Loans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLoans()
    {
        return $this->hasMany(Loan::class, ['users_id' => 'id']);
    }
}
