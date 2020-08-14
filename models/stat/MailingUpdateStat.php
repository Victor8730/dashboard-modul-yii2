<?php

namespace app\modules\dashboard\models\stat;

use app\modules\dashboard\models\MailingStat;
use app\modules\dashboard\models\Mailing;
use app\modules\dashboard\models\Email;
use app\modules\user\models\User;
use yii\base\Model;
use Yii;

/**
 * Mailing update form
 */
class MailingUpdateStat extends Model
{
    public $id;
    public $id_user;
    public $id_mailing;
    public $date_change;
    public $count;

    /**
     * @var MailingStat
     */
    private $_mailing_stat;

    public function __construct(MailingStat $mailing_stat, $config = [])
    {
        $this->_mailing_stat = $mailing_stat;
        $this->count = $mailing_stat->count;
        $this->id_user = $mailing_stat->id_user;
        $this->id_mailing = $mailing_stat->id_mailing;
        $this->date_change = $mailing_stat->date_change;
        parent::__construct($config);
    }

    public function rules()
    {
        return [

            ['id_mailing', 'required'],

            ['date', 'required'],

        ];
    }

    /**
     * Create statistic
     * @return array|mixed
     */
    public function jsonAddDate(){
		$mailingKeySearch = date( 'Y-m-d H:i:s');
		$arrM = implode(',',Mailing::findAllEmail($this->id_mailing));
        if(is_array($arrayDate =   json_decode($this->date_change,true))){
            $arrayDate[$mailingKeySearch] =  $arrM;
        }else{
            $arrayDate =   array($mailingKeySearch=>$arrM);
        }
        return $arrayDate;
    }

    /**
     * Save statistic
     * */
    public function update(){
        $mailing_stat = $this->_mailing_stat;
        $mailing_stat->id_mailing = $this->id_mailing;
        $mailing_stat->id_user = $this->id_user;
        $mailing_stat->date_change = json_encode($this->jsonAddDate());
        $mailing_stat->count = $this->count+1;
        if ($mailing_stat->save()) {
            return $mailing_stat;
        }
    }

}
