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
            ['note_status_id', 'default', 'value' => 0],
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
            'note_status_id' => 'Статус запису',
            'text' => 'Текст',
            'note_type_id' => 'Тип запису',
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

    public function getNoteStatus()
    {
        return $this->hasOne(NoteStatus::className(), ['status_value' => 'note_status_id']);
    }

    public function getNoteStatusName()
    {
        return $this->noteStatus->status_name;
    }

    public function getNoteStatusValue()
    {
        return $this->noteStatus->status_value;
    }

    public static function getNoteStatusList()
    {
        $droptions = NoteStatus::find()->asArray()->all();
        return Arrayhelper::map($droptions, 'id', 'status_name');
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

    public function countNoteUsers()
    {
        return sizeof($this->noteUsers);
    }

    public function getNoteUserLinks()
    {
        return $this->hasMany(
            UserNote::className(),
            ['note_id' => 'id']
        );
    }

    /* it can be done by function 'link()' ?
     http://stackoverflow.com/questions/26763298/how-do-i-work-with-many-to-many-relations-in-yii2 */
    public function linkNoteToUser($userId)
    {
        $statusId = UsingStatus::getIdByValue(0);
        $link = new UserNote([
            'user_id' => $userId,
            'note_id' => $this->id,
            'using_status_id' => $statusId
        ]);
        $this->link('noteUserLinks', $link);
    }

    public function unlinkAndDelete()
    {
        $userNotes = UserNote::findAll([
            'note_id' => $this->id
        ]);
        foreach ($userNotes as $un){
            $un->delete();
        }
        $this->unlinkAll('lowerNotes', $this->lowerNotes);
        $this->unlinkAll('higherNotes', $this->higherNotes);
        $this->save();
        $this->delete();
    }

}
