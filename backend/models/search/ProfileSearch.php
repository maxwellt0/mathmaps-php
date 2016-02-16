<?php
namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Profile;

class ProfileSearch extends Profile
{
    public $username;
    public $genderName;
    public $gender_id;
    public $userId;

    public function rules()
    {
        return [
            [['id', 'gender_id'], 'integer'],
            [['username','first_name', 'birthdate', 'genderName', 'userId'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gender_id' => 'Стать',
            'username' => 'Користувач'
        ];
    }

    public function search($params)
    {
        $query = Profile::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->setSort([
            'attributes' => [
                'id',
                'first_name',
                'username' => [
                    'asc' => ['username' => SORT_ASC],
                    'desc' => ['username' => SORT_DESC],
                    'label' => 'User'
                ],
                'birthdate',
                'gender_id' => [
                    'asc' => ['gender.gender_name' => SORT_ASC],
                    'desc' => ['gender.gender_name' => SORT_DESC],
                    'label' => 'Gender'
                ],
                'profileIdLink' => [
                    'asc' => ['profile.id' => SORT_ASC],
                    'desc' => ['Profile.id' => SORT_DESC],
                    'label' => 'ID'
                ],

            ]
        ]);
        if (!($this->load($params) && $this->validate())) {
            $query->joinWith(['gender'])
                ->joinWith(['user']);
            return $dataProvider;
        }
        $this->addSearchParameter($query, 'profile.id');
        $this->addSearchParameter($query, 'first_name', true);
        $this->addSearchParameter($query, 'birthdate', true);
        $this->addSearchParameter($query, 'gender_id');
        $this->addSearchParameter($query, 'user_id');
        // filter by gender name
        $query->joinWith(['gender' => function ($q) {
            $q->where('gender.gender_name LIKE "%' . $this->genderName . '%"');
        }])
        // filter by profile
            ->joinWith(['user' => function ($q) {
                $q->where('user.id LIKE "%' . $this->userId . '%"');
            }]);
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
        $attribute = "profile.$attribute";
        if ($partialMatch) {
            $query->andWhere(['like', $attribute, $value]);
        } else {
            $query->andWhere([$attribute => $value]);
        }
    }
}
