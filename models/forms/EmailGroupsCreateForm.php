<?php

namespace app\modules\dashboard\models\forms;

use app\modules\dashboard\models\EmailGroups;
use app\modules\user\models\User;
use yii\base\Model;
use Yii;

/**
 * Letter form
 */
class EmailGroupsCreateForm extends Model
{

    public $id_user;
    public $title;
    public $description;
    public $color;
    public $sort;


    /**
     * labels
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'email' => Yii::t('app', 'WEBME_NEW_EMAIL_NAME'),
            'description' => Yii::t('app', 'WEBME_NEW_EMAIL_DESC'),
            'title' => Yii::t('app', 'WEBME_EMAIL_GROUPS_TITLE'),
            'color' => Yii::t('app', 'WEBME_EMAIL_GROUPS_COLOR'),
        ];
    }

    /**
     * rules
     * @return array[]
     */
    public function rules()
    {
        return [

            [['id_user', 'sort'], 'integer'],
            [['title', 'description', 'color'], 'string'],
            [['date_create', 'date_change'], 'safe'],

        ];
    }

    /**
     * Create new email groups.
     * @return EmailGroups|null the saved model or null if saving data
     */
    public function create()
    {
        $emailGroups = new EmailGroups();
        $emailGroups->id_user = User::getUserId();
        $emailGroups->date_create = date('Y-m-d H:i:s');
        $emailGroups->date_change = date('Y-m-d H:i:s');
        if ($this->validate()) {
            $emailGroups->title = $this->title;
            $emailGroups->description = $this->description;
            $emailGroups->color = $this->color;
            if ($emailGroups->save()) {
                return $emailGroups;
            }
        }

        return null;
    }

}
