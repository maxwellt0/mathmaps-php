<?php

namespace frontend\controllers;

use frontend\models\Profile;
use Yii;

class UpgradeController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $name = Profile::find()->where(['user_id' => Yii::$app->user->identity->id])->one();
        return $this->render('index',['name' => $name]);
    }

}
