<?php

namespace backend\modules\package\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\package\models\Course;

/**
 * CourseSearch represents the model behind the search form about `\common\models\Course`.
 */
class CourseSearch extends Course
{
    public $price_from, $price_to;
    public $date_from, $date_to;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_deleted'], 'integer'],
            [['code', 'name'], 'safe'],

            [['price_from', 'price_to'], 'safe'],
            [['date_from', 'date_to'], 'safe'],
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
        $query = Course::find()->where(['is_deleted' => 0]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['name' => SORT_ASC]],
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'is_deleted' => $this->is_deleted,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'name', $this->name]);

        if ($this->price_from) $query->andWhere(['>=', 'price', $this->price_from]);
        if ($this->price_to) $query->andWhere(['<=', 'price', $this->price_to]);

        if ($this->date_from) {
            $dateFrom = strtotime(str_replace('/', '-', $this->date_from));
            $query->andWhere(['>=', 'created_at', strtotime('midnight', $dateFrom)]);
        }
        if ($this->date_to) {
            $dateTo = strtotime(str_replace('/', '-', $this->date_to));
            $query->andWhere(['<=', 'created_at', strtotime('tomorrow', $dateTo)-1]);
        }

        return $dataProvider;
    }
}
