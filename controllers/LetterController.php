<?php

namespace app\modules\dashboard\controllers;

use app\modules\user\models\User;
use app\modules\dashboard\models\Letter;
use yii\web\Controller;
use app\modules\dashboard\models\search\LetterSearch;
use app\modules\dashboard\models\forms\LetterCreateForm;
use app\modules\dashboard\models\forms\LetterUpdateForm;
use Yii;

/**
 * Class LetterController
 * Letter controller for the `dashboard` module
 * @package app\modules\dashboard\controllers
 */
class LetterController extends \yii\web\Controller
{

    /**
     * @return Letter the loaded model
     */
    protected function findModelLetter($id)
    {
        if (($model = Letter::findIdentity($id)) !== null) {
            return $model;
        }
    }

    public function actionIndex()
    {
        $searchModel = new LetterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Add snippets
     * @return mixed
     */
    public function actionSnippets()
    {
        return $this->renderPartial('snippets');
    }

    /**
     * Create new letter
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LetterCreateForm();
        if ($model->load(Yii::$app->request->post()) && $model->create()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }


    /**
     * Updating letter
     * @param $id
     * @param string $method
     * @param string $sort
     * @return int
     */
    public function actionUpdate($id, $method = '', $sort = '')
    {
        if ($letter = $this->findModelLetter($id)) {
            $model = new LetterUpdateForm($letter);
            if ($model->load(Yii::$app->request->post()) && $model->update()) {
                if ($method == 'apply') {
                    return $this->render('update', ['model' => $model]);
                } else {
                    return $this->redirect(['index']);
                }
            } else {
                if ($method == 'sort') {
                    $model->sort = $sort;
                    if ($model->update() !== null) {
                        return 1;
                    }
                } else {
                    return $this->render('update', [
                        'model' => $model
                    ]);
                }
            }
        } else {
            throw new \yii\web\NotFoundHttpException(Yii::t('app', 'ERROR_DO_NOT_HAVE_ACCESS'));
        }
    }

    /**
     * Sort letter
     * @return array
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionSort()
    {
        if (Yii::$app->request->isAjax) {
            $ids = array();
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $data_request = Yii::$app->request->post();
            $i = $r = 0;
            foreach ($data_request['item'] as $id) {
                $r += $this->actionUpdate($id, 'sort', $i);
                $i++;
            }
            if ($r !== $i) {
                $result = array("err" => Yii::t('app', 'ERROR_SORTED'));
            } else {
                $result = array("err" => 0, "success" => Yii::t('app', 'SUCCESSFULLY_SORTED'));
            }
            return $result;
        }
    }

    /**
     * Delete Letter by id
     * @param $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModelLetter($id)->delete();

        return $this->redirect(['index']);
    }
}
