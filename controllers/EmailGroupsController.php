<?php

namespace app\modules\dashboard\controllers;

use app\modules\user\models\User;
use app\modules\dashboard\models\EmailGroups;
use yii\web\Controller;
use app\modules\dashboard\models\search\EmailGroupsSearch;
use app\modules\dashboard\models\forms\EmailGroupsCreateForm;
use app\modules\dashboard\models\forms\EmailGroupsUpdateForm;
use Yii;

/**
 * Class EmailGroupsController
 * EmailGroups controller for the `dashboard` module
 * @package app\modules\dashboard\controllers
 */
class EmailGroupsController extends \yii\web\Controller
{

    /**
     * @return EmailGroups the loaded model
     */
    protected function findModel($id)
    {
        if (($model = EmailGroups::findIdentity($id)) !== null) {
            return $model;
        }
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new EmailGroupsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Create new email
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EmailGroupsCreateForm();
        if ($model->load(Yii::$app->request->post()) && $model->create()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Update exist email group
     * @param $id
     * @param string $method
     * @param string $sort
     * @return int|string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpdate($id, $method = '', $sort = '')
    {
        if ($emailGroups = $this->findModel($id)) {
            $model = new EmailGroupsUpdateForm($emailGroups);
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
                        'model' => $model,
                    ]);
                }
            }
        } else {
            throw new \yii\web\NotFoundHttpException(Yii::t('app', 'ERROR_DO_NOT_HAVE_ACCESS'));
        }
    }

    /**
     * Sort exist email group
     * @return array
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionSort()
    {
        if (Yii::$app->request->isAjax) {
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
     * Delete EmailGroups by id
     * @param $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
}
