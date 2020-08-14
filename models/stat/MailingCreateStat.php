<?php

namespace app\modules\dashboard\models\stat;

use app\modules\dashboard\models\MailingStat;
use app\modules\dashboard\models\Mailing;
use app\modules\user\models\User;
use yii\base\Model;
use Yii;

/**
 * Mailing update form
 */
class MailingCreateStat extends Model
{
    public $id;
    public $id_user;
    public $id_mailing;
    public $date_create;
    public $date_change;
    public $count;

    public function rules()
    {
        return [

            ['id_mailing', 'required'],

            ['date_create', 'required'],

        ];
    }

    /**
     * Add date for statistics
     * @return array|mixed
     */
    public function jsonAddDate()
    {
        $mailingKeySearch = date('Y-m-d H:i:s');
        $arrayMailing = (Mailing::findAllEmail($this->id_mailing) == 0) ? array() : Mailing::findAllEmail($this->id_mailing);
        $arrM = implode(',', $arrayMailing);
        if (is_array($arrayDate = json_decode($this->date_change, true))) {
            $arrayDate[$mailingKeySearch] = $arrM;
        } else {
            $arrayDate = array($mailingKeySearch => $arrM);
        }
        return $arrayDate;
    }

    /**
     * Create statistic
     * @param $id_mailing
     * @return MailingStat|null
     */
    public function create($id_mailing)
    {
        $mailing_stat = new MailingStat();
        $mailing_stat->id_user = User::getUserId();
        $mailing_stat->id_mailing = $id_mailing;
        $mailing_stat->date_create = date('Y-m-d H:i:s');
        $mailing_stat->date_change = json_encode($this->jsonAddDate());
        $mailing_stat->count = 1;
        if ($mailing_stat->save()) {
            return $mailing_stat;
        }

        return null;
    }
}
