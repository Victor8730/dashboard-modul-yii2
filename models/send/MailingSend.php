<?php

namespace app\modules\dashboard\models\send;

use app\modules\dashboard\models\EmailToGroups;
use app\modules\dashboard\models\EmailGroups;

//use app\modules\dashboard\models\MailingStat;
//use app\modules\dashboard\models\stat\MailingUpdateStat;
use app\modules\dashboard\models\Mailing;
use app\modules\dashboard\models\Letter;
use app\modules\dashboard\models\Email;
use app\modules\user\models\User;
use yii\base\Model;
use Yii;

/**
 * Mailing handler send
 */
class MailingSend extends Model
{

    public $id;
    public $id_user;
    public $id_letter;
    public $name;
    public $subject;
    public $text;
    public $email_list;
    public $email_group;
    public $email_from;
    public $email_from_pass;
    public $email_from_port;
    public $email_from_host;
    public $email_from_info;
    public $delay;
    public $amount;
    public $date_create;
    public $date_change;

    private $_mailing;


    public function rules()
    {
        return [

            [['id_letter', 'name', 'subject', 'email_from', 'email_from_info', 'delay', 'amount'], 'required'],

        ];
    }

    /**
     * construct mailing
     * */
    public function __construct(Mailing $mailing, $config = [])
    {
        $this->_mailing = $mailing;
        $this->id = $mailing->id;
        $this->id_letter = $mailing->id_letter;
        $this->name = $mailing->name;
        $this->subject = $mailing->subject;
        $this->text = $mailing->text;
        $this->email_from = $mailing->email_from;
        $this->email_from_pass = $mailing->email_from_pass;
        $this->email_from_port = $mailing->email_from_port;
        $this->email_from_host = $mailing->email_from_host;
        $this->email_from_info = $mailing->email_from_info;
        $this->email_list = $mailing->email_list;
        $this->email_group = $mailing->email_group;
        $this->delay = $mailing->delay;
        $this->amount = $mailing->amount;

        parent::__construct($config);
    }

    /**
     * execute mailing
     * @param $mailing
     * @param string $step
     * @return array
     */
    public function execute($mailing, $step = '')
    {
        $arr_res = array();//return data array for recursion
        if ($mailing['email_list'] == '' && $mailing['email_group'] == 0) {
            $arr_res['err_recursion'] = 1;
        } else {
            $amount = $mailing['amount'];//number sent at a time
            $otherEmail = ($mailing['email_list'] != '') ? explode(',',
                $mailing['email_list']) : 0;//an array of additional emails
            $groupEmail = ($mailing['email_group'] != 0) ? array_map('current',
                Email::getEmailByIdArray(EmailToGroups::getEmailsByGroup($mailing['email_group']))) : 0; //array of emails in the group
            $letterText = Letter::findIdentity($mailing['id_letter']);//we get a linked letter
            $letterText = base64_decode($letterText->text);//decode the letter
            if ($otherEmail == 0 && $groupEmail != 0) {
                $arr_m = $groupEmail;
                $countMail = count($groupEmail);//how many email
            } else {
                if ($groupEmail == 0) {
                    $arr_m = $otherEmail;
                    $countMail = count($otherEmail);//how many email
                } else {
                    $arr_m = array_merge($otherEmail, $groupEmail);
                    $countMail = count($groupEmail) + count($otherEmail);//how many email
                }
            }
            //$arr_m      = 	($otherEmail!=0 && $groupEmail!=0)  ? array_merge($otherEmail,$groupEmail) : ;
            $step_all = ceil($countMail / $amount);//how many steps ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name]);
            for ($i = $step * $amount; $i < ($amount * ($step + 1)); $i++) {
                if (!empty($arr_m[$i])) {
                    # Create a component for sending messages based on swiftmailer
                    $mailer = Yii::createObject([
                        'class' => 'yii\swiftmailer\Mailer',
                        'useFileTransport' => false,
                        'transport' => [
                            'class' => 'Swift_SmtpTransport',
                            'host' => $mailing['email_from_host'],
                            'username' => $mailing['email_from'],
                            'password' => $mailing['email_from_pass'],
                            'port' => $mailing['email_from_port'],
                            'encryption' => '',
                        ],
                    ]);
                    if ($mailer->compose()
                        ->setFrom($mailing['email_from'])
                        ->setTo($arr_m[$i])
                        ->setSubject($mailing['subject'])
                        ->setTextBody($letterText)
                        ->setHtmlBody($letterText)
                        ->send()) {
                        $arr_res['email_send'][$i]['status'] = '<span class="badge badge-success">Отправленно</span>';//we send the sending status
                        if ($mailing['email_group_after'] != 0) {
                            $idEmail = Email::findByEmail($arr_m[$i]);
                            if (empty(EmailToGroups::getEmailToGroup($idEmail->id, $mailing['email_group_after']))) {
                                $model = new EmailToGroups();
                                $model->id_email = $idEmail->id;
                                $model->id_group = $mailing['email_group_after'];
                                if ($model->create() == true) {
                                    $infoGroup = EmailGroups::findIdentity($mailing['email_group_after']);
                                    $arr_res['email_send'][$i]['status'] .= '<span class="badge badge-success">Добавленно в группу ' . $infoGroup->title . '</span>';
                                }
                            }
                        }
                    } else {
                        $arr_res['email_send'][$i]['status'] = '<span class="badge badge-warning">Не отправлено</span>';//we send the sending status
                    }
                    $arr_res['email_send'][$i]['email'] = $arr_m[$i];
                    $arr_res['email_send'][$i]['date'] = date('Y-m-d H:i:s');//send lead time
                }
            }
            $step++;
            $step = ($step_all <= $step) ? 0 : $step;
            $arr_res['num_send'] = ($step === 0) ? $countMail : $amount * $step;//how much was sent
            $arr_res['num_left'] = ($step === 0) ? 0 : $countMail - ($amount * $step);//how much is left to send
            $arr_res['step'] = $step;//what is the sending step
            $arr_res['percent'] = ($step === 0) ? 100 : ceil(100 / $step_all) * $step;//sending percent for progress bar
            $arr_res['err_recursion'] = 0;//no mistakes
        }
        return $arr_res;
    }

    /**
     * Send mailing.
     * @param $id
     * @param string $recursion
     * @return array
     * @return ajax info from mailing send
     */
    public function send($id, $recursion = '')
    {
        if ($this->validate() && $this->id_letter != 0) {
            if (!empty($id)) {
                $mailing = Mailing::findIdentity($id);
                $id_user = User::getUserId();
                if ($id_user === $mailing['id_user']) {
                    $send = $this->execute($mailing, $recursion);
                    if ($send['err_recursion'] === 0) {
                        return [
                            'err' => 0,
                            'id' => $id,
                            'step' => $send['step'],
                            'send_mail' => $send['email_send'],
                            'send_count' => $send['num_send'],
                            'left_count' => $send['num_left'],
                            'percent' => $send['percent'],
                            'how_much_delay' => $mailing['delay']
                        ];
                    } else {
                        return ['err' => 'Нет email для отправки!', 'step' => 0];
                    }
                } else {
                    return ['err' => 'Вы не имеет доступ к данной рассылке!', 'step' => 0];
                }
            } else {
                return ['err' => 'Данной рассылки не существует!', 'step' => 0];
            }
        }
        return ['err' => 'Рассылка требует корректировки, заполненны не все поля!', 'step' => 0];
    }

}