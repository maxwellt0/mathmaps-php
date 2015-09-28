<?php

namespace common\models;

use Yii;

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
            'name' => 'Name',
            'note_status_id' => 'Note Status ID',
            'text' => 'Text',
            'note_type_id' => 'Note Type ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHigherNotes()
    {
        return $this->hasMany(Note::className(), ['note_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLowerNotes()
    {
        return $this->hasMany(Note::className(), ['used_note_id' => 'id']);
    }

    public function getNoteType()
    {
        return $this->hasOne(NoteType::className(), ['id' => 'note_type_id']);
    }

    public function getNoteTypeName()
    {
        return $this->noteType->type_name;
    }
}
