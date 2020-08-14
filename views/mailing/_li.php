<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;



?>
<li class="list-group-item d-flex list-group-item-action justify-content-between align-items-center card-accent-success py-1" id="item-<?=$model->id?>">

    <div class="mr-3">
<?php
if(!empty($sort)){
    echo '<div class="border-icon cursor-pointer"><i class="fa fa-sort" aria-hidden="true" data-toggle="tooltip", title="Сортировать"></i></div>';
}
?>
        <div class="border-icon"><i class="icon-rocket"></i></div>
    <?= Html::a( HtmlPurifier::process($model->name), ['/dashboard/mailing/'.HtmlPurifier::process($model->id).''], ['class'=>'', 'data-toggle'=>'tooltip', 'title'=>'Просмотреть']) ?>
    </div>
    <div class="ml-3">
        <?= Html::a('<span class="fa fa-eye mx-2 fa-2x"></span>', ['/dashboard/mailing/'.HtmlPurifier::process($model->id).''], ['class'=>'', 'data-toggle'=>'tooltip', 'title'=>Yii::t('app', 'BUTTON_SHOW')]) ?>
    <?= Html::a('<span class="fa fa-pencil mx-2 fa-2x"></span>', ['/dashboard/mailing/'.HtmlPurifier::process($model->id).'/update'], ['class'=>'', 'data-toggle'=>'tooltip', 'title'=>Yii::t('app', 'BUTTON_UPDATE')]) ?>
    <?= Html::a('<span class="fa fa-trash-o mx-2 fa-2x"></span>', ['/dashboard/mailing/'.HtmlPurifier::process($model->id).'/delete'], ['class'=>'check-button','data-toggle'=>'tooltip', 'title'=>'Удалить','data-text-answer'=> Yii::t('app', 'WEBME_MAILING_DELETE_SURE')]) ?>
        <span class="text-primary" data-toggle="tooltip" title="Дата создания <?Yii::$app->formatter->locale = 'ru-RU'; echo Yii::$app->formatter->asDate($model->date_create, 'full');?>">
            <span class="fa fa-info mx-2 fa-2x"></span>
        </span>
        <span class="badge badge-info badge-pill" data-toggle="tooltip" title="Сколько раз инициализировано"><?=(!empty($statModel[$model->id]['count'])) ? $statModel[$model->id]['count'] : 0;?></span>
    </div>
</li>
