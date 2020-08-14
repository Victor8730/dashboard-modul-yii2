<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use app\modules\dashboard\models\EmailToGroups;
/* @var $emailGroups app\modules\dashboard\models\EmailGroups */
/* @var $emailToGroups app\modules\dashboard\models\EmailToGroups */
?>
<li class="list-group-item d-flex list-group-item-action justify-content-between align-items-center card-accent-info py-1" id="item-<?=$model->id?>">
	

    <div class="mr-3">
        <div class="inline-block">
            <div class="collapse email-groups-change">
                <div class="border-icon"><i class="fa fa-refresh" aria-hidden="true"></i> <input type="checkbox" name="check-email[]" class="check-email" value="<?=$model->id?>"></div>
            </div>
        </div>

        <div class="border-icon"><i class="fa fa-at"></i></div>
        <a href="/dashboard/email/<?=HtmlPurifier::process($model->id)?>/update" data-toggle='tooltip' title='<?=Yii::t('app', 'BUTTON_UPDATE')?>'><?=HtmlPurifier::process($model->email)?></a>
        <?php
        if(!empty($emailToGroups)){
            foreach($emailToGroups as $val){
                if($val['id_email'] == $model->id){
                    $color = (!empty($emailGroups[$val['id_group']]['color'])) ? $emailGroups[$val['id_group']]['color'] : 'info';
                    echo '<span class="badge badge-'.$color.'">'.$emailGroups[$val['id_group']]['title'].'</span>';
                }
            }
        }
        ?>
    </div>
    <div class="ml-3">
        <?= Html::a('<span class="fa fa-pencil mx-2 fa-2x"></span>', ['/dashboard/email/'.HtmlPurifier::process($model->id).'/update'], ['class'=>'', 'data-toggle'=>'tooltip', 'title'=>Yii::t('app', 'BUTTON_UPDATE')]) ?>
    <?= Html::a('<span class="fa fa-trash-o mx-2 fa-2x"></span>', ['/dashboard/email/'.HtmlPurifier::process($model->id).'/delete'], ['class'=>'check-button','data-toggle'=>'tooltip', 'title'=>'Удалить','data-text-answer'=> Yii::t('app', 'WEBME_MAILING_DELETE_SURE')]) ?>
        <span class="text-primary" data-toggle="tooltip" title="Дата создания <?Yii::$app->formatter->locale = 'ru-RU'; echo Yii::$app->formatter->asDate($model->date_create, 'full');?>">
            <span class="fa fa-info mx-2 fa-2x"></span>
        </span>
       <!-- ДОработать, нужно получить статистические данные <span class="badge badge-info badge-pill" data-toggle="tooltip" title="В скольки рассыках участвует"><?=(!empty($count_send)) ?  count($count_send) : ''?></span> -->
    </div>
</li>
