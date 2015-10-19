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
            'status_name' => 'Status Name',
            'status_value' => 'Status Value',
        ];
    }

    public static function getIdByValue($value)
    {
        return UsingStatus::findOne(['status_value' => $value])->id;
    }

    public static function getStatusList()
    {
        $tabs = NoteStatus::find()
            ->orderBy('status_value ASC')
            ->asArray()
            ->all();
        return Arrayhelper::map($tabs, 'status_value', 'status_name');
    }
}
