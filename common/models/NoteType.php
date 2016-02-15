<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "note_type".
 *
 * @property integer $id
 * @property string $type_name
 */
class NoteType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'note_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_name'], 'required'],
            [['type_name'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_name' => 'Назва типу',
        ];
    }
}
