<?php
/**
 * Created by PhpStorm.
 * User: Maxwellt
 * Date: 09.02.2016
 * Time: 9:05
 */

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

class PasswordForm extends Model{
    public $oldpass;
    public $newpass;
    public $repeatnewpass;

    private $_user = false;

    public function rules(){
        return [
            [['oldpass','newpass','repeatnewpass'],'required'],
            ['oldpass','findPasswords'],
            ['repeatnewpass','compare','compareAttribute'=>'newpass'],
        ];
    }

    public function findPasswords($attribute, $params){
        $user = $this->getUser();

        if (!$user->validatePassword($this->oldpass)) {
            $this->addError($attribute,'Неправильний старий пароль');
        }
    }

    public function attributeLabels(){
        return [
            'oldpass'=>'Старий пароль',
            'newpass'=>'Новий пароль',
            'repeatnewpass'=>'Повторіть новий пароль',
        ];
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername(Yii::$app->user->identity->username);
        }

        return $this->_user;
    }
}