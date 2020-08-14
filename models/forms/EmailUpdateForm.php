<?php

namespace app\modules\dashboard\models\forms;

use app\modules\dashboard\models\Email;
use app\modules\user\models\User;
use yii\base\Model;
use Yii;

/**
 * Letter form
 */
class EmailUpdateForm extends Model
{

    public $id;
    public $email;
    public $description;
    public $sort;

    /**
     * @var Email
     */
    private $_email;

    public function __construct(Email $email, $config = [])
    {
        $this->_email = $email;
        $this->id = $email->id;
        $this->email = $email->email;
        $this->description = $email->description;
        $this->sort = $email->sort;
        parent::__construct($config);
    }

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
     * Update email.
     * @return Email|null the saved model or null if saving fails
     */

    public function update()
    {
        $email = $this->_email;
        $email->id_user = User::getUserId();
        $email->date_change = date('Y-m-d H:i:s');
        if ($this->validate()) {
            $email->email = $this->email;
            $email->sort = $this->sort;
            $email->description = $this->description;
            if ($email->save()) {
                return $email;
            }
        }
        return null;
    }

}
