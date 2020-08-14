<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\dashboard\models\Mailing */

$this->title ='test';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row user-profile">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="card-body">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id_user',
                        'id_mailing_settings'
                    ],
                ]) ?>

            </div>
            <div class="card-footer">
                <p>
                    <?= Html::a(Yii::t('app', 'BUTTON_CREATE').'<i class="fa fa-cogs fa-lg ml-3"></i>', ['create'], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a(Yii::t('app', 'BUTTON_UPDATE').'<i class="fa fa-cogs fa-lg ml-3"></i>', ['update'], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a(Yii::t('app', 'LINK_PASSWORD_CHANGE').'<i class="fa fa-lock fa-lg ml-3"></i>', ['password-change'], ['class' => 'btn btn-primary']) ?>
                </p>
            </div>
        </div>
    </div>
</div>