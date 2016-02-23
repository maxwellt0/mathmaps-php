<?php

namespace frontend\controllers;

use common\models\User;
use common\models\UserNote;
use common\models\UsingStatus;
use Yii;
use common\models\Note;
use frontend\models\search\NoteSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NoteController implements the CRUD actions for note model.
 */
class NoteController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (defined('YII_DEBUG') && YII_DEBUG) {
            Yii::$app->assetManager->forceCopy = true;
        }
        return parent::beforeAction($action);
    }

    /**
     * Lists all note models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NoteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUserList($status = 0)
    {
        $searchModel = new NoteSearch();
        $id = Yii::$app->user->identity->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id, $status);

        $usingTabs = UsingStatus::getStatusMap();
        $tabNotesCounts = UserNote::getNotesCountList($id);

        return $this->render('userList', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'usingTabs' => $usingTabs,
            'tabCounts' => $tabNotesCounts
        ]);
    }

    /**
     * Displays a single note model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $mainNote = $this->findModel($id);

        $notesData = $mainNote->getNodesData();

        $linksData = [];
//        $i = 1;
        foreach ($mainNote->higherNotesList as $id => $name) {
            $linksData[] = ['data'=> [
                'id' => $id . $mainNote->id,
                'source' => $id . "",
                'target' => $mainNote->id,
//                'weight' => $i
            ]];
        }

        $userNote = $this->findUserNote($id);
        $isPublished = $mainNote->noteStatus->status_value == 1;
        $userIsOwner = ($userNote && !$isPublished) ? true : false;
        $publStatus = $mainNote->noteStatusValue;

        return $this->render('view', [
            'noteModel' => $mainNote,
            'notesData' => $notesData,
            'linksData' => $linksData,
            'userNote' => $userNote,
            'userIsOwner' => $userIsOwner,
            'publStatus' => $publStatus
        ]);
    }

    public function actionViewMap($id)
    {
        $mainNote = $this->findModel($id);

        $notesData = $mainNote->getNodesData(true);

        $linksData = [];
//        $i = 1;
        foreach ($mainNote->higherNotesList as $id => $name) {
            $linksData[] = ['data'=> [
                'id' => $id . $mainNote->id,
                'source' => $id . "",
                'target' => $mainNote->id,
//                'weight' => $i
            ]];
        }
//        $i++;
        foreach ($mainNote->lowerNotesList as $id => $name) {
            $linksData[] = ['data'=> [
                'id' => $id . $mainNote->id,
                'target' => $id . "",
                'source' => $mainNote->id,
//                'weight' => $i
            ]];
        }

        return $this->render('map', [
            'noteModel' => $mainNote,
            'notesData' => $notesData,
            'linksData' => $linksData,
        ]);
    }

    /**
     * Creates a new note model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new note();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $note = Yii::$app->request->post('Note');
            $model->linkLowerNotes($note['lowerNotes']);
            $model->linkHigherNotes($note['higherNotes']);
            $model->linkNoteToUser(Yii::$app->user->identity->id);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing note model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $userNote = $this->findUserNote($id);
        $isPublished = $model->noteStatus->status_value == 1;
        $userIsOwner = ($userNote && !$isPublished) ? true : false;

        if ($userIsOwner && $model->load(Yii::$app->request->post()) && $model->save()) {
            $note = Yii::$app->request->post('Note');
            $model->linkLowerNotes($note['lowerNotes']);
            $model->linkHigherNotes($note['higherNotes']);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing note model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if ($this->isUserOwner($id)) {
            $this->findModel($id)->unlinkAndDelete();
        } else {
            $userId = Yii::$app->user->identity->id;
            UserNote::deleteUserNote($id,$userId);
        }
        Yii::$app->getSession()->setFlash(
            'success','Запис видалено'
        );

        return $this->redirect(['user-list']);
    }

    public function actionAddToList($id)
    {
        $userId = Yii::$app->user->identity->id;
        $note = $this->findModel($id);
        $note->linkNoteToUser($userId);

        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionChangeStatus($noteId, $statusId)
    {
        $userNote = $this->findUserNote($noteId);
        $userNote->using_status_id = $statusId;
        $userNote->save();

        return $this->redirect(['view', 'id' => $noteId]);
    }


    public function actionOffer($id)
    {
        $model = $this->findModel($id);
        $userNote = $this->findUserNote($id);
        $isPublished = $model->noteStatus->status_value == 1;
        $userIsOwner = ($userNote && !$isPublished) ? true : false;

        if ($userIsOwner) {
            $model->note_status_id = 2;
            $model->save();
            Yii::$app->getSession()->setFlash(
                'success','Запропоновано до публікації'
            );
        }

        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Finds the note model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return note the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = note::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    private function findUserNote($noteId)
    {
        if (!Yii::$app->user->isGuest) {
            return UserNote::find()
                ->where([
                    'user_id' => Yii::$app->user->identity->id,
                    'note_id' => $noteId
                ])->one();
        } else {
            return false;
        }
    }

    /**
     * @param $id
     * @throws NotFoundHttpException
     */
    private function isUserOwner($id)
    {
        $note = $this->findModel($id);
        $userNote = $this->findUserNote($id);
        $isPublished = $note->noteStatus->status_value == 1;

        return ($userNote && !$isPublished) ? true : false;
    }

//    protected function getUser($username)
//    {
//        if (($user = User::findByUsername($username)) !== null) {
//            return $user;
//        } else {
//            throw new NotFoundHttpException('The requested page does not exist.');
//        }
//    }

}
