<?php

namespace backend\models\search;

use common\models\NoteStatus;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\note;

/**
 * NoteSearch represents the model behind the search form about `common\models\note`.
 */
class NoteSearch extends Note
{
    public $noteTypeName;
    public $note_type_id;
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

    public function search($params, $status)
    {
        $query = note::find();
        if (!is_null($status)) {
            $query->where([
                'note.note_status_id' => $status
            ])->joinWith(['noteStatus']);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->setSort([
            'attributes' => [
                'name' => [
                    'asc' => ['note.name' => SORT_ASC],
                    'desc' => ['note.name' => SORT_DESC],
                    'label' => 'Name'
                ],
                'noteTypeName' => [
                    'asc' => ['note_type.note_type_name' => SORT_ASC],
                    'desc' => ['note_type.note_type_name' => SORT_DESC],
                    'label' => 'Note Type'
                ],
            ]
        ]);
        if (!($this->load($params) && $this->validate())) {
            $query->joinWith(['noteType']);
            return $dataProvider;
        }
        $this->addSearchParameter($query, 'name', true);
        $this->addSearchParameter($query, 'note_type_id');

        // filter by note type name
        $query->joinWith(['noteType' => function ($q) {
            $q->where('note_type.type_name LIKE "%' . $this->noteTypeName . '%"');
        }]);
        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

    protected function addSearchParameter($query, $attribute, $partialMatch = false)
    {
        if (($pos = strrpos($attribute, '.')) !== false) {
            $modelAttribute = substr($attribute, $pos + 1);
        } else {
            $modelAttribute = $attribute;
        }
        $value = $this->$modelAttribute;
        if (trim($value) === '') {
            return;
        }
        /*
        * The following line is additionally added for right aliasing
        * of columns so filtering happen correctly in the self join
        */
        $attribute = "note.$attribute";
        if ($partialMatch) {
            $query->andWhere(['like', $attribute, $value]);
        } else {
            $query->andWhere([$attribute => $value]);
        }
    }
}
