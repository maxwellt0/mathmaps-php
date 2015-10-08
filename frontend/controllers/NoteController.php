<?php

namespace frontend\controllers;

use common\models\User;
use common\models\UsingStatus;
use Yii;
use common\models\note;
use frontend\models\search\NoteSearch;
use yii\data\ActiveDataProvider;
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

        $usingTabs = UsingStatus::getStatusList();

        return $this->render('userList', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'usingTabs' => $usingTabs
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

        $lowerNotes = $mainNote->lowerNotes;
        $mainNoteName = $mainNote->name;
        $mainNoteId = $mainNote->id;

        $node = [$mainNoteId, $mainNoteName];
        $nodesModel = [$node];
        $linksModel = [];

        foreach ($lowerNotes as $note) {
            $node = [$note->id, $note->name];
            $nodesModel[] = $node;

            $link = [$note->id, $mainNoteId];
            $linksModel[] = $link;
        }

        return $this->render('view', [
            'noteModel' => $mainNote,
            'nodesModel' => $nodesModel,
            'linksModel' => $linksModel,
        ]);
    }

    public function actionViewMap($id)
    {
        $mainNote = $this->findModel($id);

        $lowerNotes = $mainNote->lowerNotes;
        $higherNotes = $mainNote->higherNotes;
        $mainNoteName = $mainNote->name;
        $mainNoteId = $mainNote->id;

        $node = [$mainNoteId, $mainNoteName];
        $nodesModel = [$node];
        $linksModel = [];

        foreach ($lowerNotes as $note) {
            $node = [$note->id, $note->name];
            $nodesModel[] = $node;

            $link = [$note->id, $mainNoteId];
            $linksModel[] = $link;
        }
        foreach ($higherNotes as $note) {
            $node = [$note->id, $note->name];
            $nodesModel[] = $node;

            $link = [$mainNoteId, $note->id];
            $linksModel[] = $link;
        }

        return $this->render('map', [
            'noteModel' => $mainNote,
            'nodesModel' => $nodesModel,
            'linksModel' => $linksModel,
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
            $model->linkLowerNotes($note['lowerNotesList']);
            $model->linkHigherNotes($note['higherNotesList']);
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
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
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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

//    protected function getUser($username)
//    {
//        if (($user = User::findByUsername($username)) !== null) {
//            return $user;
//        } else {
//            throw new NotFoundHttpException('The requested page does not exist.');
//        }
//    }

}
