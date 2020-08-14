<?php

namespace app\modules\dashboard\models;

use Yii;
use app\modules\user\models\User;

/**
 * This is the model class for table "{{%email}}".
 *
 * @property int $id
 * @property int $id_user
 * @property string $email_groups
 * @property string $email
 * @property string $description
 * @property string $date_create
 * @property string $date_change
 * @property int $sort
 */
class Email extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%email}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user', 'email'], 'required'],
            [['id_user', 'sort'], 'integer'],
            [['email', 'description'], 'string'],
            [['date_create', 'date_change'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_user' => Yii::t('app', 'Id User'),
            'email' => Yii::t('app', 'Email'),
            'description' => Yii::t('app', 'Description'),
            'date_create' => Yii::t('app', 'Date Create'),
            'date_change' => Yii::t('app', 'Date Change'),
            'sort' => Yii::t('app', 'Sort'),
        ];
    }

    /**
     * Найти элемент по id
     * */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'id_user' => User::getUserId()]);
    }

    /**
     * Найти количество элементов по ключу
     * */
    public static function findIdentityCount($key, $id)
    {
        return static::find()->where([$key => $id])->count();
    }

    /**
     * Получить все email пользователя
     * */
    public static function findIdentityAll()
    {
        return static::find()->where(['id_user' => User::getUserId()])->all();
    }

    /**
     * Получить все email пользователя и вернуть в массиве
     * */
    public static function findIdentityAllArray()
    {
        return static::find()->select('id, email, id_user')->where(['id_user' => User::getUserId()])->asArray()->all();
    }

    /**
     * Получить все email пользователя связанные с выбранной групой и вернуть в виде массива
     */
    public static function findIdentityAllByGroupArray($id)
    {
        return static::find()->select('email')->where([
            'id_user' => User::getUserId(),
            'id_groups' => $id
        ])->asArray()->all();
    }

    /**
     * @param $email
     * @return mixed
     * Найти емаил по его названию
     */
    public function findByEmail($email)
    {
        return static::find()->where(['id_user' => User::getUserId(), 'email' => $email])->one();
    }

    /**
     * @param $idArray
     * @return array
     * Получить все email пользователя по id в массиве, перебрать массив и ответить массивом с email
     */
    public static function getEmailByIdArray($idArray)
    {
        $arrayEmail = [];
        foreach ($idArray as $idEmail) {
            $email = self::findIdentity($idEmail['id_email']);
            $arrayEmail[]['email'] = $email->email;
        }
        return $arrayEmail;
    }


}
