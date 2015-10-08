<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "note".
 *
 * @property string $id
 * @property string $name
 * @property integer $note_status_id
 * @property resource $text
 * @property integer $note_type_id
 *
 * @property Note[] $higherNotes
 * @property Note[] $lowerNotes
 * @property NoteType $noteType
 */
class Note extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'note';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'text'], 'required'],
            [['note_status_id', 'note_type_id'], 'integer'],
            [['text'], 'string'],
            [['name'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Назва',
            'note_status_id' => 'Note Status ID',
            'text' => 'Текст',
            'note_type_id' => 'Note Type ID',
            'noteTypeName' => Yii::t('app', 'Тип Запису'),
        ];
    }

    public function getNoteType()
    {
        return $this->hasOne(NoteType::className(), ['id' => 'note_type_id']);
    }

    public function getNoteTypeName()
    {
        return $this->noteType->type_name;
    }
    public static function getNoteTypeList()
    {
        $droptions = NoteType::find()->asArray()->all();
        return Arrayhelper::map($droptions, 'id', 'type_name');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHigherNotes()
    {
        return $this->hasMany(
            Note::className(),
            ['id' => 'note_id']
        )->viaTable(
            'note_note',
            ['used_note_id' => 'id']
        );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLowerNotes()
    {
        return $this->hasMany(
            Note::className(),
            ['id' => 'used_note_id']
        )->viaTable(
            'note_note',
            ['note_id' => 'id']
        );
    }

    public function getLowerNotesList()
    {
        $lowerNotes = $this -> lowerNotes;
        return ArrayHelper::map($lowerNotes, 'id', 'name');
    }

    public function getHigherNotesList()
    {
        $higherNotes = $this -> higherNotes;
        return ArrayHelper::map($higherNotes, 'id', 'name');
    }

    public function getOtherNotesList()
    {
        $ids = [];
        if ($this->id) {
            $ids[] = $this->id;
            foreach($this->lowerNotes as $note){
                $ids[] = $note->id;
            }
            foreach($this->higherNotes as $note){
                $ids[] = $note->id;
            }
        }

        $otherNotes = $this::find()
            ->where(['not in','id', $ids])
            ->all();
        return ArrayHelper::map($otherNotes, 'id', 'name');
    }

    public function linkLowerNotes($ids)
    {
        $this->unlinkAll('lowerNotes', $this->lowerNotes);
        $newNotes = $this::find()
            ->where(['in', 'id', $ids])
            ->all();
        foreach ($newNotes as $note) {
            $this->link('lowerNotes', $note);
        }
    }

    public function linkHigherNotes($ids)
    {
        $this->unlinkAll('higherNotes', $this->higherNotes);
        $newNotes = $this::find()
            ->where(['in', 'id', $ids])
            ->all();
        foreach ($newNotes as $note) {
            $this->link('higherNotes', $note);
        }
    }

    public function getNoteUsers()
    {
        return User::find()
            ->where(['user_note.note_id' => $this->id])
            ->joinWith(['userNoteLinks'])
            ->all();
    }

    public function getNoteUserLinks()
    {
        return $this->hasMany(
            UserNote::className(),
            ['note_id' => 'id']
        );
    }

}
