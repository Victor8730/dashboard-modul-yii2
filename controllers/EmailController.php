<?php

namespace app\modules\dashboard\controllers;

use app\modules\user\models\User;
use app\modules\dashboard\models\Email;
use app\modules\dashboard\models\EmailGroups;
use app\modules\dashboard\models\EmailToGroups;
use yii\web\Controller;
use app\modules\dashboard\models\search\EmailSearch;
use app\modules\dashboard\models\forms\EmailCreateForm;
use app\modules\dashboard\models\forms\EmailUpdateForm;
use Yii;
use yii\web\UploadedFile;
use app\modules\dashboard\models\import\ImportCsv;
use yii\helpers\ArrayHelper;

/**
 * Class EmailController
 * Email controller for the `dashboard` module
 * @package app\modules\dashboard\controllers
 */
class EmailController extends \yii\web\Controller
{

    /**
     * @return Email the loaded model
     */
    protected function findModel($id)
    {
        if (($model = Email::findIdentity($id)) !== null) {
            return $model;
        }
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new EmailSearch();
        $importModel = new ImportCsv();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'importModel' => $importModel,
            'dataProvider' => $dataProvider,
            'emailGroupsList' => EmailGroups::mapIdTitle(),
            'emailToGroups' => EmailToGroups::getGroupsByUser(),
            'emailGroups' => EmailGroups::getAllGroupsReturnArray()
        ]);
    }


    /**
     * Create email
     * @param string $method
     * @param string $fields
     * @return bool
     */
    public function actionCreate($method = '', $fields = '')
    {
        $model = new EmailCreateForm();
        $emailGroups = EmailGroups::mapIdTitle();
        if ($model->load(Yii::$app->request->post()) && $model->create()) {
            return $this->redirect(['index']);
        } else {
            if ($method == 'import') {
                if ($model->load($fields) && $model->create()) {
                    return true;
                }
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'emailGroups' => $emailGroups,
                ]);
            }
        }
    }

    /**
     * Update email
     * @param $id
     * @param string $method
     * @param string $sort
     * @return int|string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpdate($id, $method = '', $sort = '')
    {
        if ($letter = $this->findModel($id)) {
            $model = new EmailUpdateForm($letter);
            $emailGroups = EmailGroups::mapIdTitle();
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
                } elseif ($method == 'group') {
                    $model->id_groups = $sort;
                    if ($model->update() !== null) {
                        return 1;
                    }
                } else {
                    return $this->render('update', [
                        'model' => $model,
                        'emailGroups' => $emailGroups
                    ]);
                }
            }
        } else {
            throw new \yii\web\NotFoundHttpException(Yii::t('app', 'ERROR_DO_NOT_HAVE_ACCESS'));
        }
    }

    /**
     * Working with group
     * @param string $method
     * @param string $all
     * @return array
     */
    public function actionGroup($method = '', $all = '')
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $data_request = Yii::$app->request->post();
            $i = $r = 0;
            $checkEmail = ($all != 'all') ? $data_request['check-email'] : ArrayHelper::getColumn(ArrayHelper::toArray(Email::findIdentityAll(),
                ['app\modules\dashboard\models\Email' => ['id']]), 'id');
            if (!empty($checkEmail) && !empty($data_request['email-group-selected'])) {
                foreach ($checkEmail as $idEmail) {
                    foreach ($data_request['email-group-selected'] as $idGroups) {
                        $exist = EmailToGroups::getEmailToGroup($idEmail, $idGroups);
                        if ($method != 'del') {
                            if (empty($exist)) {
                                $model = new EmailToGroups();
                                $model->id_email = $idEmail;
                                $model->id_group = $idGroups;
                                $r += ($model->create() == true) ? 1 : 0;
                                $i++;
                            }
                            $success = Yii::t('app', 'SUCCESSFULLY_ADD');
                        } else {
                            if (!empty($exist)) {
                                $exist->delete();
                                $success = Yii::t('app', 'SUCCESSFULLY_DEL');
                            }
                        }
                    }
                }
                if ($r !== $i) {
                    $result = array("err" => Yii::t('app', 'ERROR_ADD_NOT_ALL'));
                } else {
                    $result = array("err" => 0, "success" => $success);
                }
            } else {
                $result = array("err" => Yii::t('app', 'ERROR_ADD_MISSING_DATA'));
            }
            return $result;
        }
    }

    // off CSRF
    public function beforeAction($action)
    {
        if ($action->id === 'myFunction') {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    /**
     * Import file with emails
     * @return array|string[]
     */
    public function actionImport()
    {
        $model_csv = new ImportCsv();
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (Yii::$app->request->isPost) {
            $model_csv->csvFile = UploadedFile::getInstances($model_csv, 'csvFile');//get a new file
            $model_csv->csvFile = $model_csv->csvFile[0];
            if (($adrFile = $model_csv->upload()) !== '') {
                if (($handle = fopen($adrFile, "r")) !== false) {
                    while (($data = fgetcsv($handle, 10000, ";")) !== false) {
                        $this->actionCreate('import', array('EmailCreateForm' => ['email' => $data[0]]));
                    }
                    fclose($handle);
                    unlink($adrFile);
                }
                return $result = array("err" => 0, "success" => 'файл загружен, данные обновленны');
            } else {
                return $result = array("err" => 'ошибка получения файла');
            }
        } else {
            return $result = array("err" => 'не пост');
        }
    }

    /**
     * Export all email by user
     * @return string
     */
    public function actionExport()
    {
        //$data_request = Yii::$app->request->post();
        $data = "Email;Description;id groups\r\n";
        $model = Email::findIdentityAll();
        foreach ($model as $value) {
            $data .= $value->email . ';' . $value->description . ';' . $value->id_groups . "\r\n";
        }
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename="export_email_' . date('d.m.Y_H.i.s') . '.csv"');
        return $data;
        //return $result = array("err" => 0, "success" => 'файл выгружен');
    }


    /**
     * Delete Email by id
     * @param $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
}
