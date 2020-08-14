<?php

namespace app\modules\dashboard\models;

use yii\behaviors\TimestampBehavior;
use Yii;
use app\modules\user\models\User;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%mailing}}".
 *
 * @property int $id
 * @property int $id_user
 * @property int $id_letter
 * @property string $name
 * @property string $subject
 * @property string $text
 * @property string $email_list
 * @property string $email_group
 * @property string $email_group_after
 * @property string $email_from
 * @property string $email_from_pass
 * @property string $email_from_port
 * @property string $email_from_host
 * @property string $email_from_info
 * @property string $delay
 * @property string $amount
 */
class Mailing extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mailing}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            ['id_letter', 'required'],

            ['name', 'string', 'min' => 2, 'max' => 25, 'message' => Yii::t('app', 'ERROR_FIO_TEXT')],
            ['name', 'required'],

            ['subject', 'string', 'min' => 2, 'max' => 50, 'message' => Yii::t('app', 'ERROR_FIO_TEXT')],
            ['subject', 'required'],

            ['text', 'string', 'message' => Yii::t('app', 'ERROR_FIO_TEXT')],


            ['email_list', 'string', 'message' => Yii::t('app', 'ERROR_FIO_TEXT')],


            ['email_group', 'integer', 'message' => Yii::t('app', 'ERROR_FIO_TEXT')],

            ['email_group_after', 'integer', 'message' => Yii::t('app', 'ERROR_FIO_TEXT')],


            ['email_from', 'string', 'message' => Yii::t('app', 'ERROR_FIO_TEXT')],
            ['email_from', 'required'],

            ['email_from_pass', 'string'],
            ['email_from_pass', 'required'],

            ['email_from_port', 'string'],
            ['email_from_port', 'required'],

            ['email_from_host', 'string'],
            ['email_from_host', 'required'],

            ['email_from_info', 'string', 'message' => Yii::t('app', 'ERROR_FIO_TEXT')],
            ['email_from_info', 'required'],

            ['delay', 'integer', 'message' => Yii::t('app', 'ERROR_FIO_TEXT')],
            ['delay', 'required'],

            ['amount', 'integer', 'message' => Yii::t('app', 'ERROR_FIO_TEXT')],
            ['amount', 'required'],


        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_letter' => Yii::t('app', 'WEBME_LETTTER_SELECT'),
            'name' => Yii::t('app', 'WEBME_NEW_MAILING_NAME'),
            'subject' => Yii::t('app', 'WEBME_NEW_MAILING_SUBJECT'),
            'text' => Yii::t('app', 'WEBME_NEW_MAILING_TEXT'),
            'email_list' => Yii::t('app', 'WEBME_NEW_MAILING_EMAIL_LIST'),
            'email_group' => Yii::t('app', 'WEBME_NEW_MAILING_EMAIL_GROUP'),
            'email_group_after' => Yii::t('app', 'WEBME_NEW_MAILING_EMAIL_GROUP_AFTER'),
            'email_from' => Yii::t('app', 'WEBME_NEW_MAILING_EMAIL_FROM'),
            'email_from_port' => Yii::t('app', 'WEBME_NEW_MAILING_EMAIL_FROM_PORT'),
            'email_from_pass' => Yii::t('app', 'WEBME_NEW_MAILING_EMAIL_FROM_PASS'),
            'email_from_host' => Yii::t('app', 'WEBME_NEW_MAILING_EMAIL_FROM_HOST'),
            'email_from_info' => Yii::t('app', 'WEBME_NEW_MAILING_EMAIL_FROM_INFO'),
            'delay' => Yii::t('app', 'WEBME_NEW_MAILING_DELAY'),
            'amount' => Yii::t('app', 'WEBME_NEW_MAILING_AMOUNT'),
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
     * Find all user's mailings
     * @return mixed
     */
    public static function findIdentityAll()
    {
        return static::find()->where(['id_user' => User::getUserId()])->all();
    }

    /**
     * @param $idMailing
     * @return array|int
     * Find all emails related to the newsletter
     * */
    public static function findAllEmail($idMailing)
    {
        $mailing = static::findIdentity($idMailing);
        $otherEmail = ($mailing->email_list != '') ? explode(',',
            $mailing->email_list) : 0;//an array of additional emails
        $groupEmail = ($mailing->email_group != 0) ? array_map('current',
            Email::getEmailByIdArray(EmailToGroups::getEmailsByGroup($mailing->email_group))) : 0; //array of emails in the group
        if ($otherEmail == 0 && $groupEmail != 0) {
            $arrMail = $groupEmail;
        } else {
            if ($groupEmail == 0) {
                $arrMail = $otherEmail;
            } else {
                $arrMail = array_merge($otherEmail, $groupEmail);
            }
        }
        return $arrMail;
    }
}
