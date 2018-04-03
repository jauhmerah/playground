<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

/**
 * UserSearch represents the model behind the search form about `\common\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_disabled', 'is_deleted'], 'integer'],
            [['email', 'name'], 'safe'],
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
        $query = User::find()->where(['is_deleted' => 0]);

        // Hide entry with role 'super'
        $query->join('LEFT JOIN', '{{%auth_assignment}}', '{{%auth_assignment}}.user_id = id')->groupBy('id');
        $query->andWhere(['!=', '{{%auth_assignment}}.item_name', 'super']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'is_disabled' => $this->is_disabled,
            'is_deleted' => $this->is_deleted,
        ]);

        $query->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
