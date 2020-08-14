<?php
use yii\bootstrap\ActiveForm;
use app\modules\dashboard\models\forms\MailingCreateForm;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\dashboard\models\forms\MailingCreateForm */
/* @var $dataLatter app\modules\dashboard\models\Letter */
/* @var $dataEmailGroup app\modules\dashboard\models\EmailGroups */

$this->title = Yii::t('app', 'WEBME_MAILING_CREATE');
$this->params['breadcrumbs'][] = ['label' =>Yii::t('app', 'NAV_DASHBOARD'), 'url' => ['/dashboard']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'WEBME_MAILING'), 'url' => ['/dashboard/mailing']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row user-create">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="card-body">
                <?= $this->render('_form', [
                    'model' => $model,
                    'dataLatter' => $dataLatter,
                    'dataEmailGroup' => $dataEmailGroup,
                    'id'   => '',
                ]) ?>
            </div>
            <div class="card-footer">
                <div class="form-group">

                </div>

            </div>
        </div>
    </div>
</div>
