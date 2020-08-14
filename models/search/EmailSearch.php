<?php

namespace app\modules\dashboard\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\dashboard\models\Email;
use app\modules\user\models\User;

/**
 * EmailSearch represents the model behind the search form of `app\modules\dashboard\models\Email`.
 */
class EmailSearch extends Model
{
    public $id;
    public $id_user;
    public $id_groups;
    public $email;
    public $sort;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_user', 'id_groups'], 'integer'],
            [['email', 'sort'], 'string']
        ];
    }


    /**
     * Search field labels
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'id_user' => Yii::t('app', 'Id User'),
            'email' => Yii::t('app', 'Email'),
            'sort' => 'Sort',
        ];
    }


    /**
     * Basic search model
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Email::find()->where(['id_user' => User::getUserId()]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 25,
                'pageSizeLimit' => [25, 250]
            ],
            'sort' => [
                'defaultOrder' => [
                    /*'sort' => SORT_ASC,*/
                    'email' => SORT_ASC
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
