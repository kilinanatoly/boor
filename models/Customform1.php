<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customform1".
 *
 * @property integer $id
 * @property string $phone
 * @property string $fio
 * @property string $email
 * @property string $year
 * @property string $month
 * @property string $day
 */
class Customform1 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customform1';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone', 'fio', 'email', 'year', 'month', 'day'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phone' => 'Phone',
            'fio' => 'Fio',
            'email' => 'Email',
            'year' => 'Year',
            'month' => 'Month',
            'day' => 'Day',
        ];
    }
}
