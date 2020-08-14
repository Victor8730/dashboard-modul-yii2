<?php

namespace app\modules\dashboard\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\dashboard\models\EmailGroups;
use app\modules\user\models\User;

/**
 * EmailGroupsSearch represents the model behind the search form of `app\modules\dashboard\models\EmailGroups`.
 */
class EmailGroupsSearch extends Model
{
    public $id;
    public $id_user;
    public $id_email;
    public $title;
    public $description;
    public $sort;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_user', 'id_email'], 'integer'],
            [['description', 'title', 'sort'], 'string']
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
            'title' => Yii::t('app', 'Email'),
            'description' => Yii::t('app', 'Email'),
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
        $query = EmailGroups::find()->where(['id_user' => User::getUserId()]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 25,
                'pageSizeLimit' => [25, 200]
            ],
            'sort' => [
                'defaultOrder' => [
                    'sort' => SORT_ASC,
                    'id' => SORT_DESC
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'title', $this->title]);
        $query->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
