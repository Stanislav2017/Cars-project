<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Car;

/**
 * SearchCar represents the model behind the search form of `app\models\Car`.
 */
class SearchCar extends Car
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'brand_id', 'type_id'], 'integer'],
            [['mileage', 'price', 'phone'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Car::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'brand_id' => $this->brand_id,
            'type_id' => $this->type_id,
        ]);

        $query->andFilterWhere(['like', 'mileage', $this->mileage])
            ->andFilterWhere(['like', 'price', $this->price])
            ->andFilterWhere(['like', 'phone', $this->phone]);

        return $dataProvider;
    }
}
