<?php

namespace frontend\models;

use Yii;
use common\models\User;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\db\Expression;


/**
 * This is the model class for table "profile".
 *
 * @property string $id
 * @property string $user_id
 * @property string $name
 * @property string $birthdate
 * @property string $gender_id
 *
 * @property Gender $gender
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'gender_id'], 'required'],
            [['user_id', 'gender_id'], 'integer'],
            [['first_name'], 'string'],
            [['birthdate'], 'safe'],
            [['gender_id'], 'in', 'range' => array_keys($this->getGenderList())],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'ID Користувача',
            'first_name' => 'Ім\'я',
            'birthdate' => 'Дата народження',
            'gender_id' => 'Стать',
            'user.eamil' => 'Email',
            'genderName' => Yii::t('app', 'Стать'),
            'userLink' => 'Користувач',
            'profileIdLink' => Yii::t('app', 'Profile'),
            'createdAt' => 'Зареєстровано',
            'updatedAt' => 'Останній візит',
            'username' => 'Користувач'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGender()
    {
        return $this->hasOne(Gender::className(), ['id' => 'gender_id']);
    }

    /**
     * uses magic getGender on return statement
     *
     */
    public function getGenderName()
    {
        return $this->gender->gender_name;
    }

    /**
     * get list of genders for dropdown
     */
    public static function getGenderList()
    {
        $droptions = Gender::find()->asArray()->all();
        return Arrayhelper::map($droptions, 'id', 'gender_name');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @get Username
     */
    public function getUsername()
    {
        return $this->user->username;
    }

    public function getCreatedAt()
    {
        return $this->user->created_at;
    }

    public function getUpdatedAt()
    {
        return $this->user->updated_at;
    }

    /**
     * @getUserId
     */
    public function getUserId()
    {
        return $this->user ? $this->user->id : 'none';
    }

    /**
     * @getUserLink
     */
    public function getUserLink()
    {
        $url = Url::to(['user/view', 'id' => $this->UserId]);
        $options = [];
        return Html::a($this->getUserName(), $url, $options);
    }

    /**
     * @getProfileLink
     */
    public function getProfileIdLink()
    {
        $url = Url::to(['profile/update', 'id' => $this->id]);
        $options = [];
        return Html::a($this->id, $url, $options);
    }

    public function beforeValidate()
    {
        if ($this->birthdate != null) {
            $new_date_format = date('Y-m-d', strtotime($this->birthdate));
            $this->birthdate = $new_date_format;
        }
        return parent::beforeValidate();
    }


}
