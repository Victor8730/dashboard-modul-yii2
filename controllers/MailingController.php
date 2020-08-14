<?php

namespace app\modules\dashboard\controllers;

use app\modules\user\models\User;
use app\modules\dashboard\models\Mailing;
use app\modules\dashboard\models\Letter;
use app\modules\dashboard\models\MailingStat;
use app\modules\dashboard\models\EmailGroups;
use app\modules\dashboard\models\search\MailingSearch;
use app\modules\dashboard\models\forms\MailingCreateForm;
use app\modules\dashboard\models\forms\MailingUpdateForm;
use app\modules\dashboard\models\send\MailingSend;
use app\modules\dashboard\models\stat\MailingCreateStat;
use app\modules\dashboard\models\stat\MailingUpdateStat;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\base\ErrorException;
use Yii;


/**
 * Class MailingController
 * Mailing controller for the `dashboard` module
 * @package app\modules\dashboard\controllers
 */
class MailingController extends Controller
{

    /**
     * @return Mailing the loaded model
     */
    protected function findModelMailing($id)
    {
        if (($model = Mailing::findIdentity($id)) !== null) {
            return $model;
        }
    }

    /**
     * @return MailingStat the loaded model
     */
    protected function findModelMailingStat($id)
    {
        if (($model = MailingStat::findMailingStat($id)) !== null) {
            return $model;
        }
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MailingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $statModel = MailingStat::findUserStatMailing();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'statModel' => $statModel,
        ]);
    }

    /**
     * Create new mailing
     * @return mixed
     */
    public function actionCreate()
    {
        $dataLatter = ArrayHelper::map(Letter::findAllLatterUser(), 'id', 'title');
        $dataEmailGroup = EmailGroups::mapIdTitle();
        $model = new MailingCreateForm();
        if ($model->load(Yii::$app->request->post()) && $model->create()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'dataLatter' => $dataLatter,
                'dataEmailGroup' => $dataEmailGroup
            ]);
        }
    }

    /**
     * Updating the existing mailing list
     * @param $id
     * @param string $method
     * @param string $sort
     * @return int
     */
    public function actionUpdate($id, $method = '', $sort = '')
    {
        if ($mailing = $this->findModelMailing($id)) {
            $dataLatter = ArrayHelper::map(Letter::findAllLatterUser(), 'id', 'title');
            $dataEmailGroup = EmailGroups::mapIdTitle();
            $model = new MailingUpdateForm($mailing);
            if ($model->load(Yii::$app->request->post()) && $model->update()) {
                if ($method == 'apply') {
                    return $this->render('update',
                        ['model' => $model, 'dataLatter' => $dataLatter, 'dataEmailGroup' => $dataEmailGroup]);
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
                        'dataLatter' => $dataLatter,
                        'dataEmailGroup' => $dataEmailGroup
                    ]);
                }
            }
        } else {
            throw new \yii\web\NotFoundHttpException(Yii::t('app', 'ERROR_DO_NOT_HAVE_ACCESS'));
        }
    }

    /**
     * Viewing or launching one mailing
     * @param $id
     * @return array
     */
    public function actionView($id)
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $data_request = Yii::$app->request->post();
            //return $model->send($id,$data_request['recursion']);
            $mailing = $this->findModelMailing($id);
            $model = new MailingSend($mailing);
            $result = $model->send($id, $data_request['recursion']);
            if ($result['step'] == 0) {
                if ($mailingStatExist = $this->findModelMailingStat($id)) {
                    $model_stat = new MailingUpdateStat($mailingStatExist);
                    $model_stat->update();//обновляем статистику по рассылке
                } else {
                    $model_stat = new MailingCreateStat();//сохраняем статистику по рассылке
                    $model_stat->create($id);
                }
            }
            return $result;
        } else {
            if ($this->findModelMailing($id)) {
                return $this->render('view', [
                    'model' => $this->findModelMailing($id),
                ]);
            } else {
                throw new \yii\web\NotFoundHttpException(Yii::t('app', 'ERROR_DO_NOT_HAVE_ACCESS'));
            }
        }
    }

    /**
     * We load the mailing statistics into the information table
     * @param $id
     * @return array
     */
    public function actionStat($id)
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $data_request = Yii::$app->request->post();
            $mailingStat = $this->findModelMailingStat($id);
            $arrayDate = json_decode($mailingStat->date_change);
            $result = ArrayHelper::getValue($arrayDate, $data_request['date']);
            if (!empty($result)) {
                return array(
                    "err" => 0,
                    "success" => Yii::t('app', 'WEBME_MAILING_LOAD_STAT'),
                    "data" => explode(',', $result)
                );;
            } else {
                return array("err" => Yii::t('app', 'WEBME_MAILING_LOAD_STAT_ERR'));
            }
        }
    }

    /**
     * Sorting the mailing list
     * @return array
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
     * Delete Mailing by id
     * @param $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModelMailing($id)->delete();
        $this->findModelMailingStat($id)->delete();

        return $this->redirect(['index']);
    }

}
