<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use app\modules\dashboard\models\forms\EmailUpdateForm;

/* @var $this yii\web\View */
/* @var $model app\modules\dashboard\models\forms\EmailUpdateForm */
/* @var $emailGroups app\modules\dashboard\models\EmailGroups */



$this->title = Yii::t('app', 'WEBME_EMAIL_UPDATE');
$this->params['breadcrumbs'][] = ['label' =>Yii::t('app', 'NAV_DASHBOARD'), 'url' => ['/dashboard']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'WEBME_EMAIL'), 'url' => ['/dashboard/email']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row user-profile-update">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="card-body">
                <?= $this->render('_form', [
                    'model' => $model,
                    'emailGroups' => $emailGroups,
                    'id'   => $model->id,
                ]) ?>
             </div>
            <div class="card-footer">

            </div>
        </div>
    </div>
</div>