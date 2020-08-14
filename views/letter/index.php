<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;
use app\components\SwitchPerPage;

/* @var $this yii\web\View */
/* @var $model app\modules\dashboard\models\Letter */
$this->title = Yii::t('app', 'WEBME_LETTER_LIST');
$this->params['breadcrumbs'][] = ['label' =>Yii::t('app', 'NAV_DASHBOARD'), 'url' => ['/dashboard']];
$this->params['breadcrumbs'][] = Yii::t('app', 'WEBME_LETTER');
$perPage = (!empty($_GET['per-page'])) ? $_GET['per-page'] : 0;
$sortable = ($perPage==999) ? 'sorting sortable'  : '';
?>
<div class="row user-profile">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="card-body">
                <?php
                if(empty($sortable)){
                ?>
                    <?= Html::a(Yii::t('app', 'BUTTON_CREATE').'<i class="fa fa-plus fa-lg ml-3"></i>', ['create'], ['class' => 'btn btn-success my-1']) ?>
                    <?= Html::a(Yii::t('app', 'BUTTON_SORT').'<i class="fa fa-sort fa-lg ml-3"></i>', ['?per-page=999'], ['class' => 'btn btn-primary my-1']) ?>
                    <?= SwitchPerPage::widget(['count' => '25,50,75,100,125,150']) ?>
                <?php
                }else{
                    echo Html::a(Yii::t('app', 'BUTTON_BACK').'<i class="fa fa-arrow-left fa-lg ml-3"></i>', Url::current(['per-page'=>null]), ['class' => 'btn btn-primary']);
                }
                ?>
                <hr>
                <?= ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemView' => '_li',
                    'summary' => '',
                    'itemOptions' => [
                        'tag' => false
                    ],
                    'viewParams' => ['sort' => $sortable],
                    'options' => [
                        'tag' => 'ul',
                        'class' => 'list-group '.$sortable,
                    ],
                ]); ?>
            </div>
            <div class="card-footer">

            </div>
        </div>
    </div>
</div>