<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\NoteStatus;

/**
 * NoteStatusSearch represents the model behind the search form about `common\models\NoteStatus`.
 */
class NoteStatusSearch extends NoteStatus
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status_value'], 'integer'],
            [['status_name'], 'safe'],
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
        $query = NoteStatus::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status_value' => $this->status_value,
        ]);

        $query->andFilterWhere(['like', 'status_name', $this->status_name]);

        return $dataProvider;
    }
}
