<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "using_status".
 *
 * @property integer $id
 * @property string $status_value
 * @property string $status_name
 */
class UsingStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'using_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status_value', 'status_name'], 'required'],
            [['id', 'status_value'], 'integer'],
            [['status_name'], 'string', 'max' => 25]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status_value' => 'Status Value',
            'status_name' => 'Status Name',
        ];
    }

    public static function getIdByValue($value)
    {
        return UsingStatus::findOne(['status_value' => $value])->id;
    }

    public static function getStatusList()
    {
        $tabs = UsingStatus::find()->asArray()->all();
        return Arrayhelper::map($tabs, 'status_value', 'status_name');
    }
}
