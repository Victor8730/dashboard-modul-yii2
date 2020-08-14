<?php

namespace app\modules\dashboard\models\forms;

use app\modules\dashboard\models\Letter;
use app\modules\user\models\User;
use yii\base\Model;
use Yii;

/**
 * Letter form
 */
class LetterUpdateForm extends Model
{

    public $id;
    public $title;
    public $text;
    public $sort;

    /**
     * @var Letter
     */
    private $_letter;

    public function __construct(Letter $letter, $config = [])
    {
        $this->_letter = $letter;
        $this->title = $letter->title;
        $this->text = base64_decode($letter->text);
        $this->id = $letter->id;
        $this->sort = $letter->sort;
        parent::__construct($config);
    }

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

            ['title', 'string', 'min' => 2, 'max' => 50, 'message' => Yii::t('app', 'ERROR_FIO_TEXT') ],
            ['title', 'required'],
            ['text', 'required'],
            ['sort', 'integer'],

        ];
    }

    /**
     * Update letter.
     * @return Letter|null the saved model or null if saving fails
     */

    public function update()
    {
        $letter = $this->_letter;
        $letter->id_user = User::getUserId();
        $letter->date_change = date( 'Y-m-d H:i:s');
        if ($this->validate()) {
            $letter->title = $this->title;
            $letter->sort = $this->sort;
            $letter->text =  base64_encode($this->text);
            if ($letter->save()) {
                return $letter;
            }
        }
        return null;
    }

}
