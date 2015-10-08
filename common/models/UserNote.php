<?php

namespace common\models;

use Yii;

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

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
