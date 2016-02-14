<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "user_note".
 *
 * @property integer $using_status_id
 * @property string $note_id
 * @property string $user_id
 */
class UserNote extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_note';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['using_status_id', 'note_id', 'user_id'], 'required'],
            [['using_status_id', 'note_id', 'user_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'using_status_id' => 'Using Status ID',
            'note_id' => 'Note ID',
            'user_id' => 'User ID',
        ];
    }

    public function getUsingStatus()
    {
        return $this->hasOne(UsingStatus::className(), ['id' => 'using_status_id']);
    }

    public static function getUsingStatusList()
    {
        $droptions = UsingStatus::find()->asArray()->all();
        return Arrayhelper::map($droptions, 'id', 'status_name');
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function getNotesCountList($userId)
    {
        $counts = UsingStatus::find()
            ->select('status_value, COUNT(status_value) AS cnt')
            ->joinWith(['userNotes'])
            ->where(['user_id' => $userId])
            ->groupBy('status_value')
            ->orderBy('status_value')
            ->all();
        $countsMap = Arrayhelper::map($counts, 'status_value', 'cnt');
        $tabs = UsingStatus::getStatusMap();
        foreach ($tabs as $value=>$name){
            if (!array_key_exists($value, $countsMap)) {
                $countsMap[$value] = 0;
            }
        }
        return $countsMap;
    }

    public static function deleteUserNote($noteId, $userId)
    {
        $userNote = UserNote::findOne([
            'user_id' => $userId,
            'note_id' => $noteId
            ])->delete();
        return true;
    }
}
