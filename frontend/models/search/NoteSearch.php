<?php

namespace frontend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\note;

/**
 * NoteSearch represents the model behind the search form about `common\models\note`.
 */
class NoteSearch extends note
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'note_status_id', 'note_type_id'], 'integer'],
            [['name', 'text'], 'safe'],
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
        $query = note::find();

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
            'note_status_id' => $this->note_status_id,
            'note_type_id' => $this->note_type_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'text', $this->text]);

        return $dataProvider;
    }
}
