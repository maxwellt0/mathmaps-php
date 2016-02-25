<?php
namespace frontend\controllers;

use common\models\User;
use Exception;
use frontend\models\PasswordForm;
use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'change-password', 'change-email'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','change-password', 'change-email'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Дякуємо, що зв\'язались з нами. Ми дамо відповідь якнайшвидше.');
            } else {
                Yii::$app->session->setFlash('error', 'Сталася помилка надсилання email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionFuncAnReview()
    {
        return $this->render('funcAnReview');
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Перевірте свою електронну пошту для подальших інструкцій.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Вибачте, ми не можемо відновити пароль для вказаного email.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'Новий пароль збережено.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionChangePassword(){
        $model = new PasswordForm;
        $modeluser = $this->getCurrentUser();

        if($model->load(Yii::$app->request->post())){
            if($model->validate()){
                try{
                    $modeluser->password = $_POST['PasswordForm']['newpass'];
                    if($modeluser->save()){
                        Yii::$app->getSession()->setFlash(
                            'success','Пароль змінено.'
                        );
                        return $this->redirect(['index']);
                    }else{
                        Yii::$app->getSession()->setFlash(
                            'error','Пароль не змінено.'
                        );
                        return $this->redirect(['index']);
                    }
                }catch(Exception $e){
                    Yii::$app->getSession()->setFlash(
                        'error',"{$e->getMessage()}"
                    );
                    return $this->render('changePassword',[
                        'model'=>$model
                    ]);
                }
            }else{
                return $this->render('changePassword',[
                    'model'=>$model
                ]);
            }
        }else{
            return $this->render('changePassword',[
                'model'=>$model
            ]);
        }
    }

    public function actionChangeEmail(){
        $model = $this->getCurrentUser();

        if ($model->load(Yii::$app->request->post())
                && $model->validate()) {
            if ($model->save()) {
                Yii::$app->getSession()->setFlash(
                    'success','Email змінено.'
                );
            } else {
                Yii::$app->getSession()->setFlash(
                    'error','Email не змінено.'
                );
            }

            return $this->redirect(['profile/update']);
        } else {
            return $this->render('changeEmail',[
                'model'=>$model
            ]);
        }
    }

    private function getCurrentUser()
    {
        return User::find()->where([
            'username'=>Yii::$app->user->identity->username
        ])->one();
    }
}
