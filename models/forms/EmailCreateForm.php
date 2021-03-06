<?php

namespace app\modules\dashboard\models\forms;

use app\modules\dashboard\models\Email;
use app\modules\user\models\User;
use yii\base\Model;
use Yii;

/**
 * Email form
 */
class EmailCreateForm extends Model
{

    public $email;
    public $description;


    /**
     * labels
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'email' => Yii::t('app', 'WEBME_NEW_EMAIL_NAME'),
            'description' => Yii::t('app', 'WEBME_NEW_EMAIL_DESC'),
        ];
    }

    /**
     * rules
     * @return \string[][]
     */
    public function rules()
    {
        return [

            ['email', 'string'],
            ['email', 'required'],
            ['email', 'email'],
            ['description', 'string'],

        ];
    }

    /**
     * Create new email.
     * @return Email|null the saved model or null if saving data
     */
    public function create()
    {
        $email = new Email();
        $email->id_user = User::getUserId();
        $email->date_create = date('Y-m-d H:i:s');
        $email->date_change = date('Y-m-d H:i:s');
        if ($this->validate()) {
            $email->email = $this->email;
            $email->description = $this->description;
            if ($email->save()) {
                return $email;
            }
        }

        return null;
    }

}
