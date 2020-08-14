<?php

namespace app\modules\dashboard\models;

use app\modules\user\models\User;
use Yii;

/**
 * This is the model class for table "{{%email_to_groups}}".
 *
 * @property int $id
 * @property int $id_user
 * @property int $id_email
 * @property int $id_group
 * @property string $date_create
 */
class EmailToGroups extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%email_to_groups}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user', 'id_email', 'id_group', 'date_create'], 'required'],
            [['id_user', 'id_email', 'id_group'], 'integer'],
            [['date_create'], 'safe'],
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
            'id_email' => Yii::t('app', 'Id Email'),
            'id_group' => Yii::t('app', 'Id Groups'),
            'date_create' => Yii::t('app', 'Date Create'),
        ];
    }

    /**
     * @param $id
     * @return mixed
     * Find element by id
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'id_user' => User::getUserId()]);
    }

    /**
     * @return mixed
     * Find all groups associated with a user's email
     */
    public static function getGroupsByUser()
    {
        return static::find()->where(['id_user' => User::getUserId()])->asArray()->all();
    }

    /**
     * @param $id_email
     * @return mixed
     * Find all groups associated with a user's email
     */
    public static function getGroupsByEmail($id_email)
    {
        return static::find()->where(['id_email' => $id_email, 'id_user' => User::getUserId()])->asArray()->all();
    }

    /**
     * @param $id_group
     * @return mixed
     * Return all emails to groups
     */
    public static function getEmailsByGroup($id_group)
    {
        return static::find()->where(['id_group' => $id_group, 'id_user' => User::getUserId()])->asArray()->all();
    }

    /**
     * @param $idEmail
     * @param $idGroups
     * @return mixed
     * Return one, search by id email, id group, id user
     */
    public static function getEmailToGroup($idEmail, $idGroups)
    {
        return static::find()->where([
            'id_user' => User::getUserId(),
            'id_email' => $idEmail,
            'id_group' => $idGroups
        ])->one();
    }

    /**
     * @return Email|null
     */
    public function create()
    {
        $this->id_user = User::getUserId();
        $this->date_create = date('Y-m-d H:i:s');
        if ($this->validate()) {
            if ($this->save()) {
                return true;
            }
        }
        return null;
    }
}
