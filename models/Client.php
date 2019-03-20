<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%clients}}".
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $phone
 * @property string $address
 * @property string $comment
 * @property string $feedbackDataId
 */
class Client extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%clients}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'phone', 'address', 'comment'], 'required'],
            [['comment'], 'string'],
            [['name', 'surname', 'address'], 'string', 'max' => 64],
            [['phone'], 'string', 'max' => 14],
            [['feedbackDataId'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'surname' => 'Surname',
            'phone' => 'Phone',
            'address' => 'Address',
            'comment' => 'Comment',
            'feedbackDataId' => 'Feedback Data ID',
        ];
    }
}
