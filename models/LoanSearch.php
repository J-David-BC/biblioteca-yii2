<?php
namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Loan;

class LoanSearch extends Loan {
	
	public function rules(){
		return [
			[['id'], 'integer'],
            [[/*'name',*/ 'loan_date', 'return_date','status'], 'safe'],
		];
	}

	public function scenarios(){
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

	public function search($params){
		$query = Loan::find()->orderBy(['id'=>SORT_DESC]);

		$dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize'=>10],
        ]);

        $this->load($params);

		if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

		$query->andFilterWhere([
            'id' => $this->id,
            //'name' => $this->name,
			'loan_date' => $this->loan_date,
			'return_date' => $this->return_date,
            'status'=> $this->status,
            //'created_at' => $this->created_at,
            //'updated_at' => $this->updated_at,
        ]);

		$query->andFilterWhere(['like', 'loan_date', $this->loan_date])
            ->andFilterWhere(['like', 'return_date', $this->return_date])
            ->andFilterWhere(['like', 'status', $this->status]);
 
        return $dataProvider;
	}
}
?>