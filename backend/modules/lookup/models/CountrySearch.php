<?php

namespace backend\modules\lookup\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\OptCountry;

/**
 * CountrySearch represents the model behind the search form about `\common\models\OptCountry`.
 */
class CountrySearch extends OptCountry
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = OptCountry::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'name', $this->name.'%', false]);

        return $dataProvider;
    }
}
