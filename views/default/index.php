<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\data\ActiveDataProvider;
use app\modules\dashboard\models\Mailing;
use yii\grid\GridView;
use app\components\grid\ActionColumn;
use app\components\grid\SetColumn;
use app\components\grid\LinkColumn;
use app\components\grid\RoleColumn;

/* @var $this yii\web\View */
/* @var $model app\modules\dashboard\models\Mailing */
/* @var $searchModel app\modules\dashboard\models\search\MailingSearch*/
//$this->title = Yii::t('app', 'WEBME_MAILING_LIST');
//$this->params['breadcrumbs'][] = Yii::t('app', 'NAV_DASHBOARD');
//Html::encode($this->title)
?>
<div class="row dashboard-list animated fadeIn">
        <?php
        foreach($dashboardData as $search){
            echo '<div class="col-sm-6 col-md-4 col-lg-4">
                <div class="card card-accent-'.$search[4].'">
                    <div class="card-header"><h1 class="h3 m-0"><a href="dashboard/'.$search[3].'" class="text-'.$search[4].'">'.$search[0].'</a></h1></div>
                    <div class="card-body">'.$search[1].'</div>
                    <div class="card-footer"><span class="text-value">'.$search[2].'</span><i class="fa fa-tags" aria-hidden="true" data-toggle="tooltip" title="'.Yii::t('app', 'WEBME_COUNT').'"></i></div>
                </div>
               
            </div>';
        }
        ?>
        <div class="row">

        </div>
</div>