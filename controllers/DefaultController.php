<?php

namespace app\modules\dashboard\controllers;

use app\modules\user\models\User;
use app\modules\dashboard\models\Email;
use app\modules\dashboard\models\Mailing;
use app\modules\dashboard\models\Letter;
use app\modules\dashboard\models\search\MailingSearch;
use app\modules\dashboard\models\search\LetterSearch;
use app\modules\dashboard\models\search\EmailSearch;
use app\modules\dashboard\models\MailingStat;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\base\ErrorException;
use Yii;

/**
 * Default controller for the `dashboard` module
 */
class DefaultController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'dashboardData' => [
                [
                    Yii::t('app', 'WEBME_EMAIL'),
                    Yii::t('app', 'WEBME_EMAIL_INFO'),
                    Email::findIdentityCount('id_user',User::getUserId()),
                    'email',
                    'info'
                ],
                [
                    Yii::t('app', 'WEBME_LETTER'),
                    Yii::t('app', 'WEBME_LETTER_INFO'),
                    Letter::findIdentityCount('id_user',User::getUserId()),
                    'letter',
                    'secondary'
                ],
                [
                    Yii::t('app', 'WEBME_MAILING'),
                    Yii::t('app', 'WEBME_MAILING_INFO'),
                    Mailing::findIdentityCount('id_user',User::getUserId()),
                    'mailing',
                    'success'
                ]
            ],
        ]);
    }

}
