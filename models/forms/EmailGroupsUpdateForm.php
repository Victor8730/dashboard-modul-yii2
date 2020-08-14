<?php

namespace app\modules\dashboard\models\forms;

use app\modules\dashboard\models\EmailGroups;
use app\modules\user\models\User;
use yii\base\Model;
use Yii;

/**
 * EmailGroups form
 */
class EmailGroupsUpdateForm extends Model
{

    public $id;
    public $id_user;
    public $title;
    public $description;
    public $color;
    public $sort;

    /**
     * @var EmailGroups
     */
    private $_emailGroups;

    public function __construct(EmailGroups $emailGroups, $config = [])
    {
        $this->_emailGroups = $emailGroups;
        $this->id = $emailGroups->id;
        $this->title = $emailGroups->title;
        $this->description = $emailGroups->description;
        $this->color = $emailGroups->color;
        $this->sort = $emailGroups->sort;
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
            [['id_user', 'date_create', 'date_change'], 'safe'],

        ];
    }

    /**
     * Update email groups.
     * @return EmailGroups|null the saved model or null if saving fails
     */

    public function update()
    {
        $emailGroups = $this->_emailGroups;
        $emailGroups->id_user = User::getUserId();
        $emailGroups->date_change = date('Y-m-d H:i:s');
        if ($this->validate()) {
            $emailGroups->title = $this->title;
            $emailGroups->sort = $this->sort;
            $emailGroups->description = $this->description;
            $emailGroups->color = $this->color;
            if ($emailGroups->save()) {
                return $emailGroups;
            }
        }
        return null;
    }

}
