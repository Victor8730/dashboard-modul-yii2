<?php

namespace app\modules\dashboard\models;

use Yii;
use yii\db\ActiveRecord;
use app\modules\user\models\User;

/**
 * This is the model class for table "{{%mailing_stat}}".
 *
 * @property int $id
 * @property int $id_user
 * @property string $id_mailing
 * @property string $id_letter
 * @property string $date_change
 * @property string $date_create
 * @property string $count
 */
class MailingStat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mailing_stat}}';
    }

    /**
     * Find element by id_mailing
     * @param $id
     * @return mixed
     */
    public static function findMailingStat($id)
    {
        return static::findOne(['id_mailing' => $id, 'id_user' => User::getUserId()]);
    }

    /**
     * Find element by id_user with index by id_mailing
     * @return mixed
     */
    public static function findUserStatMailing()
    {
        return parent::find()->where(['id_user' => User::getUserId()])->indexBy('id_mailing')->asArray()->all();
    }
}
