<?php

use app\modules\dashboard\models\forms\LetterCreateForm;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\dashboard\models\forms\EmailCreateForm */
/* @var $emailGroups app\modules\dashboard\models\EmailGroups */

$this->title = Yii::t('app', 'WEBME_EMAIL_CREATE');
$this->params['breadcrumbs'][] = ['label' =>Yii::t('app', 'NAV_DASHBOARD'), 'url' => ['/dashboard']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'WEBME_EMAIL'), 'url' => ['/dashboard/email']];
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
                    'emailGroups' => $emailGroups,
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
