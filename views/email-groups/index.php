<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;
use app\components\SwitchPerPage;

/* @var $this yii\web\View */
/* @var $model app\modules\dashboard\models\EmailGroups */
/* @var $model app\modules\dashboard\models\EmailGroups */
$this->title = Yii::t('app', 'WEBME_EMAIL_GROUPS_LIST');
$this->params['breadcrumbs'][] = ['label' =>Yii::t('app', 'NAV_DASHBOARD'), 'url' => ['/dashboard']];
$this->params['breadcrumbs'][] = Yii::t('app', 'WEBME_EMAIL_GROUPS');

$openFilter=(isset($_GET['EmailGroupsSearch']))? 'show':'';
?>
<div class="row user-profile">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="card-body">


                <?= Html::a(Yii::t('app', 'BUTTON_CREATE').'<i class="fa fa-plus fa-lg ml-3"></i>', ['create'], ['class' => 'btn btn-success my-1']) ?>
                <?= Html::button(Yii::t('app', 'BUTTON_SEARCH').'<i class="fa fa-search fa-lg ml-3" aria-hidden="true"></i>', ['class' => 'btn btn-primary open-block my-1', 'data-class'=>'filter-block']) ?>

                <?= SwitchPerPage::widget(['count' => '25,50,75,100,125,150']) ?>

                <div class="close-block filter-block <?=$openFilter?>">
                    <div class="row py-1">
                        <div class="col-md-12">
                            <div class="card card-accent-primary">
                                <div class="card-header"><?=Yii::t('app', 'BUTTON_SEARCH')?></div>
                                <div class="card-body">
                                    <?= $this->render('_search', ['model' => $searchModel]) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>
                <?= ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemView' => '_li',
                    'summary' => '',
                    'itemOptions' => [
                        'tag' => false
                    ],
                    'options' => [
                        'tag' => 'ul',
                        'class' => 'list-group',
                    ],
                ]); ?>
            </div>
            <div class="card-footer">

            </div>
        </div>
    </div>
</div>