<?php

namespace app\modules\dashboard\models;

use Yii;
use app\modules\user\models\User;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%email_groups}}".
 *
 * @property int $id
 * @property int $id_user
 * @property string $title
 * @property string $description
 * @property string $color
 * @property string $date_create
 * @property string $date_change
 * @property int $sort
 */
class EmailGroups extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%email_groups}}';
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_user' => Yii::t('app', 'Id User'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'color' => Yii::t('app', 'Color'),
            'date_create' => Yii::t('app', 'Date Create'),
            'date_change' => Yii::t('app', 'Date Change'),
            'sort' => Yii::t('app', 'Sort'),
        ];
    }

    /**
     * Найти элемент по id
     * */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'id_user' => User::getUserId()]);
    }

    /**
     * Найти количество элементов по ключу
     * */
    public static function findIdentityCount($key, $id)
    {
        return static::find()->where([$key => $id])->count();
    }

    /**
     * Найти все группы имейлов пользователя и вернуть в виде массива
     * */
    public static function getAllGroupsReturnArray()
    {
        return static::find()->where(['id_user' => User::getUserId()])->indexBy('id')->asArray()->all();
    }

    /**
     * Найти все группы имейлов пользователя, вернуть массив с ключами равными id группы
     * */
    public static function findIdentityAllArrayIndexId()
    {
        return static::find()->where(['id_user' => User::getUserId()])->indexBy('id')->asArray()->all();
    }

    /**
     * Найти все группы имейлов пользователя, вернуть массив с id и title
     * */
    public static function mapIdTitle()
    {
        return ArrayHelper::map(static::find()->select('id,title')->where(['id_user' => User::getUserId()])->asArray()->all(),
            'id', 'title');
    }
}
