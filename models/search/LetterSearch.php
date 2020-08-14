<?php

namespace app\modules\dashboard\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\dashboard\models\Letter;
use app\modules\user\models\User;

/**
 * LetterSearch represents the model behind the search form of `app\modules\dashboard\models\Letter`.
 */
class LetterSearch extends Model
{
    public $id;
    public $id_user;

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
        $query = Letter::find()->where(['id_user' => User::getUserId()]);

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
