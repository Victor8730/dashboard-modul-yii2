<?php

namespace app\modules\dashboard\models\forms;

use app\modules\dashboard\models\Letter;
use app\modules\user\models\User;
use yii\base\Model;
use Yii;

/**
 * Letter form
 */
class LetterCreateForm extends Model
{

    public $title;
    public $text;


    /**
     * labels
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'title' => Yii::t('app', 'WEBME_NEW_LETTER_NAME'),
            'text' => Yii::t('app', 'WEBME_NEW_LETTER_TEXT'),
        ];
    }

    /**
     * rules
     * @return array
     */
    public function rules()
    {
        return [

            ['title', 'string', 'min' => 2, 'max' => 50, 'message' => Yii::t('app', 'ERROR_FIO_TEXT')],
            ['title', 'required'],
            ['text', 'required'],

        ];
    }

    /**
     * Create new mailing.
     * @return Letter|null the saved model or null if saving data
     */
    public function create()
    {
        $letter = new Letter();
        $letter->id_user = User::getUserId();
        $letter->date_create = date('Y-m-d H:i:s');
        if ($this->validate()) {
            $letter->title = $this->title;
            $letter->text = base64_encode($this->text);
            if ($letter->save()) {
                return $letter;
            }
        }

        return null;
    }

}
