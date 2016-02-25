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
            ['id' => 'used_note_id']
        )->from('note hn')
            ->viaTable(
            'note_note',
            ['note_id' => 'id']
        );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLowerNotes()
    {
        return $this->hasMany(
            Note::className(),
            ['id' => 'note_id']
        )->from('note ln')
            ->viaTable(
            'note_note',
            ['used_note_id' => 'id']
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

    public function getLowerNotesData()
    {
        $conditions = [
            'note.id' => $this->id,
            'note.note_status_id' => 1
        ];
        if (!Yii::$app->user->isGuest) {
            $userId = Yii::$app->user->identity->id;
            $conditions = [
                'and',
                [
                    'note.id' => $this->id
                ],
                [
                    'or',
                    'note.note_status_id' => 1,
                    'user_note.user_id' => $userId
                ]
            ];
        }
        $ids = $this->find()
            ->select(['ln.id', 'ln.name'])
            ->innerJoinWith(['lowerNotes'])
            ->where($conditions)->all();
        return ArrayHelper::toArray($ids, 'id');
    }

    public function getHigherNotesData()
    {
        $conditions = [
            'note.id' => $this->id,
            'note.note_status_id' => 1
        ];
        if (!Yii::$app->user->isGuest) {
            $userId = Yii::$app->user->identity->id;
            $conditions = [
                'and',
                [
                    'note.id' => $this->id
                ],
                [
                    'or',
                    'note.note_status_id' => 1,
                    'user_note.user_id' => $userId
                ]
            ];
        }
        $ids = $this->find()
            ->select(['hn.id', 'hn.name'])
            ->joinWith(['higherNotes'])
            ->joinWith(['noteUserLinks'])
            ->where($conditions)->all();
        return ArrayHelper::toArray($ids, 'id');
    }

    public function getNodesData($full = false)
    {
        $notes = $this->higherNotesData;
        if ($full) {
            $notes = ArrayHelper::merge($this->lowerNotesData, $notes);
        }
        $nodesData = [];
        foreach ($notes as $note){
            $nodesData[] = [ 'data' => [
                'id' => $note['id'],
                'name' => $note['name'],
                'color' => Note::randomColor(),
                'href' => Note::getHref($note['id'])
            ]];
        }
        $nodesData[] = [ 'data' => [
            'id' => $this->id,
            'name' => $this->name,
            'color' => Note::randomColor(),
            'href' => Note::getHref($this->id)
        ]];
        return $nodesData;
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

    public static function hsvToRgb($h, $s, $v)
    {
        $c = $v*$s;
        $ht = $h/60.0;
        $x  = $c*(1 - abs(($ht % 2) -1));
        $rgb1 = [];
        if ($ht>=0 && $ht<1) {
            $rgb1 = [$c, $x, 0];
        }  elseif ($ht>=1 && $ht<2) {
            $rgb1 = [$x, $c, 0];
        } elseif ($ht>=2 && $ht<3) {
            $rgb1 = [0, $c, $x];
        } elseif ($ht>=3 && $ht<4) {
            $rgb1 = [0, $x, $c];
        } elseif ($ht>=4 && $ht<5) {
            $rgb1 = [$x, 0, $c];
        } elseif ($ht>=5 && $ht<6) {
            $rgb1 = [$c, 0, $x];
        } else {
            $rgb1 = [0, 0, 0];
        }
        $m = $v - $c;
        $rgb = [
            floor((($rgb1[0] + $m) * 256) + 1),
            floor((($rgb1[1] + $m) * 256) + 1),
            floor((($rgb1[2] + $m) * 256) + 1)
        ];
        return '#'
        . dechex($rgb[0])
        . dechex($rgb[1])
        . dechex($rgb[2]);
    }

    public static function randomColor()
    {
        $golden_ratio_conjugate = 0.618033988749895;
        $h = rand(0,256);
        $h += $golden_ratio_conjugate;
        $h += $h % 1;
        return Note::hsvToRgb($h, 0.6, 0.95);
    }

    public static function getHref($id)
    {
        return "/note/" . $id;
    }

}
