<?php

namespace app\modules\dashboard\models\forms;

use app\modules\dashboard\models\Mailing;
use app\modules\user\models\User;
use yii\base\Model;
use Yii;

/**
 * Mailing update form
 */
class MailingUpdateForm extends Model
{
    public $id;
    public $id_user;
    public $id_letter;
    public $name;
    public $subject;
    public $text;
    public $email_list;
    public $email_group;
    public $email_group_after;
    public $email_from;
    public $email_from_pass;
    public $email_from_port;
    public $email_from_host;
    public $email_from_info;
    public $delay;
    public $amount;
    public $date_change;
    public $sort;

    /**
     * @var Mailing
     */
    private $_mailing;

    public function __construct(Mailing $mailing, $config = [])
    {
        $this->_mailing = $mailing;
        $this->id = $mailing->id;
        $this->id_letter = $mailing->id_letter;
        $this->name = $mailing->name;
        $this->subject = $mailing->subject;
        $this->text = $mailing->text;
        $this->email_list = $mailing->email_list;
        $this->email_group = $mailing->email_group;
        $this->email_group_after = $mailing->email_group_after;
        $this->email_from = $mailing->email_from;
        $this->email_from_pass = $mailing->email_from_pass;
        $this->email_from_port = $mailing->email_from_port;
        $this->email_from_host = $mailing->email_from_host;
        $this->email_from_info = $mailing->email_from_info;
        $this->delay = $mailing->delay;
        $this->amount = $mailing->amount;
        $this->sort = $mailing->sort;
        parent::__construct($config);
    }

    /**
     * labels
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id_letter' => Yii::t('app', 'WEBME_LETTER_SELECT'),
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
            'email_from_info' => Yii::t('app', 'WEBME_NEW_MAILING_EMAIL_FROM_INFO'),
            'delay' => Yii::t('app', 'WEBME_NEW_MAILING_DELAY'),
            'amount' => Yii::t('app', 'WEBME_NEW_MAILING_AMOUNT'),
            'sort' => 'Сртировка',
        ];
    }

    /**
     * rules
     * @return array
     */
    public function rules()
    {
        return [

            ['id_letter', 'required'],

            ['name', 'string', 'min' => 2, 'max' => 50, 'message' => Yii::t('app', 'ERROR_FIO_TEXT')],
            ['name', 'required'],

            ['subject', 'string', 'min' => 2, 'max' => 100, 'message' => Yii::t('app', 'ERROR_FIO_TEXT')],
            ['subject', 'required'],

            ['text', 'string'],


            ['email_list', 'string', 'message' => Yii::t('app', 'ERROR_FIO_TEXT')],

            ['email_group', 'string', 'message' => Yii::t('app', 'ERROR_FIO_TEXT')],

            ['email_group_after', 'string', 'message' => Yii::t('app', 'ERROR_FIO_TEXT')],


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

            ['sort', 'integer'],

        ];
    }

    /**
     * Update mailing.
     * @return Mailing|null the saved model or null if saving fails
     */

    public function update()
    {
        $mailing = $this->_mailing;
        $mailing->id_user = User::getUserId();
        $mailing->date_change = date('Y-m-d H:i:s');
        if ($this->validate()) {
            $mailing->id_letter = $this->id_letter;
            $mailing->name = $this->name;
            $mailing->subject = $this->subject;
            $mailing->text = $this->text;
            $mailing->email_list = $this->email_list;
            $mailing->email_group = $this->email_group;
            $mailing->email_group_after = $this->email_group_after;
            $mailing->email_from = $this->email_from;
            $mailing->email_from_pass = $this->email_from_pass;
            $mailing->email_from_port = $this->email_from_port;
            $mailing->email_from_host = $this->email_from_host;
            $mailing->email_from_info = $this->email_from_info;
            $mailing->email_from_info = $this->email_from_info;
            $mailing->delay = $this->delay;
            $mailing->amount = $this->amount;
            $mailing->sort = $this->sort;
            if ($mailing->save()) {
                return $mailing;
            }
        }
        return null;
    }

}
