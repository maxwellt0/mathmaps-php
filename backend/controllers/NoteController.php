<?php

namespace backend\controllers;

use common\models\NoteStatus;
use common\models\UserNote;
use Yii;
use common\models\note;
use backend\models\search\NoteSearch;
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

    /**
     * Lists all note models.
     * @return mixed
     */
    public function actionIndex($status = 0)
    {
        $searchModel = new NoteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $status);

        $statusTabs = NoteStatus::getStatusList();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'statusTabs' => $statusTabs,
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

        $un = UserNote::find()
            ->where([
                'user_id' => Yii::$app->user->identity->id,
                'note_id' => $id
            ])->one();
        $isUserNote = $un? true : false;

        return $this->render('view', [
            'noteModel' => $mainNote,
            'nodesModel' => $nodesModel,
            'linksModel' => $linksModel,
            'isUserNote' => $isUserNote
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
}
