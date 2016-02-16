<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "note_status".
 *
 * @property integer $id
 * @property string $status_name
 * @property integer $status_value
 */
class NoteStatus extends \yii\db\ActiveRecord
{

    public $cnt;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'note_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status_name', 'status_value'], 'required'],
            [['status_value'], 'integer'],
            [['status_name'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status_name' => 'Назва статусу',
            'status_value' => 'Значення',
        ];
    }

    public static function getIdByValue($value)
    {
        return UsingStatus::findOne(['status_value' => $value])->id;
    }

    public static function getStatusMap()
    {
        $tabs = NoteStatus::find()
            ->orderBy('status_value ASC')
            ->asArray()
            ->all();
        return Arrayhelper::map($tabs, 'status_value', 'status_name');
    }

    public static function getNotesCountsMap($userId = false)
    {
        $query = NoteStatus::find()
            ->select('status_value, COUNT(status_value) AS cnt')
            ->where(['is not', 'note.id', null])
            ->joinWith(['notes']);
        if ($userId) {
            $query->where(['user_note.user_id' => $userId])
                ->joinWith(['notes.noteUserLinks']);
        }
        $counts = $query->groupBy('status_value')
            ->orderBy('status_value')
            ->all();
        $countsMap = Arrayhelper::map($counts, 'status_value', 'cnt');
        $tabs = NoteStatus::getStatusMap();
        // if there are no notes with certain status value
        foreach ($tabs as $value=>$name){
            if (!array_key_exists($value, $countsMap)) {
                $countsMap[$value] = 0;
            }
        }
        return $countsMap;
    }

    public function getNotes()
    {
        return $this->hasMany(Note::className(), ['note_status_id' => 'status_value']);
    }


}
