<?php

namespace app\modules\dashboard\models;

use Yii;
use app\modules\user\models\User;

/**
 * This is the model class for table "{{%letter}}".
 *
 * @property int $id
 * @property int $title
 */
class Letter extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%letter}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['title', 'string', 'min' => 2, 'max' => 50, 'message' => Yii::t('app', 'ERROR_FIO_TEXT')],
            ['title', 'required'],
            ['text', 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'title' => Yii::t('app', 'WEBME_NEW_LETTER_NAME'),
            'text' => Yii::t('app', 'WEBME_NEW_LETTER_TEXT'),
        ];
    }

    /**
     * Find element by id
     * @param $id
     * @return mixed
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'id_user' => User::getUserId()]);
    }

    /**
     * Find all data for one user
     * @return mixed
     */
    public static function findIdentityAll()
    {
        return static::find()->where(['id_user' => User::getUserId()])->all();
    }

    /**
     * Find the number of items by key
     * @param $key
     * @param $id
     * @return mixed
     */
    public static function findIdentityCount($key, $id)
    {
        return static::find()->where([$key => $id])->count();
    }

    /**
     * Find all user elements
     * @return mixed
     */
    public static function findAllLatterUser()
    {
        return static::find()->where(['id_user' => User::getUserId()])->all();
    }

}
