<?php

namespace app\modules\dashboard\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\dashboard\models\Mailing;
use app\modules\user\models\User;

/**
 * MailingSearch represents the model behind the search form of `app\modules\dashboard\models\Mailing`.
 */
class MailingSearch extends Model
{
    public $id;
    public $id_user;
    public $id_mailing_settings;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_user'], 'integer'],
        ];
    }


    /**
     * Search field labels
     * @return string[]
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'ID',

        ];
    }

    /**
     * Basic search model
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Mailing::find()->where(['id_user' => User::getUserId()]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'sort' => SORT_ASC,
                    'id' => SORT_DESC
                ],
            ],
        ]);

       /* $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'id_user' => $this->id_user,
        ]);*/

        return $dataProvider;
    }
}
