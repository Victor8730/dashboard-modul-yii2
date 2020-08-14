<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
$count_send  = (!empty($count_send)) ?  count($count_send) : '';
?>
<li class="list-group-item d-flex list-group-item-action justify-content-between align-items-center card-accent-info py-1" id="item-<?=$model->id?>">
    <div class="mr-3">
        <div class="border-icon"><i class="fa fa-at text-<?=$model->color?>" data-toggle="tooltip" title="id группы, для импорта emails"> <?=$model->id?> </i></div>
        <?=($model->description) ? ' <div class="border-icon"><i class="fa fa-info-circle" data-toggle="tooltip" title="'.$model->description.'"></i></div>' : '' ;?>

    <a href="/dashboard/email-groups/<?=HtmlPurifier::process($model->id)?>/update" data-toggle='tooltip' title='<?=Yii::t('app', 'BUTTON_UPDATE')?>'><?=HtmlPurifier::process($model->title)?></a>
    </div>
    <div class="ml-3">
        <?= Html::a('<span class="fa fa-pencil mx-2 fa-2x"></span>', ['/dashboard/email-groups/'.HtmlPurifier::process($model->id).'/update'], ['class'=>'', 'data-toggle'=>'tooltip', 'title'=>Yii::t('app', 'BUTTON_UPDATE')]) ?>
    <?= Html::a('<span class="fa fa-trash-o mx-2 fa-2x"></span>', ['/dashboard/email-groups/'.HtmlPurifier::process($model->id).'/delete'], ['class'=>'check-button','data-toggle'=>'tooltip', 'title'=>'Удалить','data-text-answer'=> Yii::t('app', 'WEBME_MAILING_DELETE_SURE')]) ?>
        <span class="text-primary" data-toggle="tooltip" title="Дата создания <?Yii::$app->formatter->locale = 'ru-RU'; echo Yii::$app->formatter->asDate($model->date_create, 'full');?>">
            <span class="fa fa-info mx-2 fa-2x"></span>
        </span>
        <span class="badge badge-info badge-pill" data-toggle="tooltip" title="В скольки рассыках участвует"><?=$count_send?></span>
    </div>
</li>
