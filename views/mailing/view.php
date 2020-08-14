<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use app\modules\dashboard\models\EmailToGroups;
use app\modules\dashboard\models\MailingStat;

/* @var $this yii\web\View */
/* @var $model app\modules\dashboard\models\Mailing */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' =>Yii::t('app', 'NAV_DASHBOARD'), 'url' => ['/dashboard']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'WEBME_MAILING'), 'url' => ['/dashboard/mailing'], 'class'=>'check-button', 'data-text-content'=>Yii::t('app', 'WEBME_MAILING_SEND_HREF_CONTENT')];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row user-view">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="card-body">
                <?= Html::a(Yii::t('app', 'BUTTON_PLAY'), 
				['start', 'id' => $model->id], 
				[
				'class' => 'btn btn-success send-mailing', 
				'data-id'=>$model->id, 
				'title'=>'Запустить', 
				'data-toggle'=>'tooltip', 
				]) 
				?>
                <?= Html::a(Yii::t('app', 'BUTTON_UPDATE'), 
				['update', 'id' => $model->id], 
				[
				'class' => 'btn btn-primary check-button',
				'data-text-answer'=>Yii::t('app','BUTTON_UPDATE'),
				'data-text-content'=>Yii::t('app','WEBME_MAILING_SEND_HREF_CONTENT'),
				'title'=>Yii::t('app','BUTTON_UPDATE'), 'data-toggle'=>'tooltip',
				]) 
				?>
                <?= Html::a(Yii::t('app', 'BUTTON_CLOSE'), ['/dashboard/mailing'], ['class' => 'btn btn-danger check-button','data-text-answer'=>Yii::t('app','BUTTON_CLOSE'), 'data-text-content'=>Yii::t('app','WEBME_MAILING_SEND_HREF_CONTENT'),'title'=>Yii::t('app','BUTTON_CLOSE'), 'data-toggle'=>'tooltip',]) ?>
                <hr>
                <div class="col-sm-12 col-md-4">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-gears fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><i class="icon-puzzle progress-group-icon"></i><?=Yii::t('app', 'WEBME_NEW_MAILING_AMOUNT')?> <span class="my-1 btn btn-primary"><?=($model->amount).' штук';?></span></div>
                                    <div class="huge"><i class="icon-speedometer progress-group-icon"></i>Перерыв <span class="my-1 btn btn-primary"><?=($model->delay/1000).' сек';?></span></div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><i class="icon-envelope-letter progress-group-icon"></i>Всего Email
                                            <span class="my-1 btn btn-primary email_count">
                                            <?php
											$otherEmail = (!empty($model->email_list)) ? count(explode(',',$model->email_list)) : 0;
                                            $groupEmail = (!empty($model->email_group)) ? count(EmailToGroups::getEmailsByGroup($model->email_group)) : 0;
                                            echo $otherEmail+$groupEmail;
                                            ?></span>
                                    </div>
                                    <div class="huge"><i class="icon-action-redo progress-group-icon"></i>Отправленно <span class="my-1 btn btn-success email_send_count">0</span></div>
                                    <div class="huge"><i class="icon-pie-chart progress-group-icon"></i>Осталось <span class="my-1 btn btn-warning email_left_count">0</span></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-sm-12 col-md-8">
                    <div class="h2">Общий прогресс отправки <div class="d-inline-block"><i class="fa fa-check text-success mailing-success collapse" aria-hidden="true"></i></div></div>
                    <div class="panel panel-info">
                        <div class="progress" style="height: 1px;">
                            <div class="progress-bar progress-bar-thin bg-success" role="progressbar" style="" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar progress-bar-fat bg-success" role="progressbar" style="" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="progress mb-0" style="height: 1px;">
                            <div class="progress-bar progress-bar-thin bg-success" role="progressbar" style="" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="panel panel-info card">
                        <div class="card-body">
                            <div class="h5">Осталось до следующей отправки</div>
                            <div class="text-value time-left">0</div>
                            <div class="progress progress-xs my-2">
                                <div class="progress-bar progress-bar-timer bg-primary" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-info-circle" aria-hidden="true"></i> Статистическая таблица
                        <div class="d-inline-block">
							<div class="d-inline-block">
							<?php
                                $mailingStat = MailingStat::findMailingStat($model->id);
                                if(!empty($mailingStat->date_change)) {
                                    $mailingHistory = array();
                                    foreach (json_decode($mailingStat->date_change) as $key => $value) {
                                        $mailingHistory[$key] = $key;
                                    }
                                    echo Html::dropDownList('mailing-history', 'null', $mailingHistory, ['prompt' => 'Выберите дату:', 'class' => 'form-control mailing-history', 'data-id'=> $model->id]);
                                }
							?>
							 </div>
                            <span class="input-group-text btn d-inline-block fa-1x"><i class="fa fa-save"></i></span>
                            <span class="input-group-text empty-table btn d-inline-block fa-1x"><i class="fa fa-close"></i></span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div data-spy="scroll" style="height: 200px; overflow: auto">
                            <div class="table table-responsive-sm table-sm table-result">
                                <div class="border-bottom col-md-12">
                                    <div class="col-md-1"><strong>#</strong></div>
                                    <div class="col-md-4"><strong>Email</strong></div>
                                    <div class="col-md-4"><strong>Дата отправки</strong></div>
                                    <div class="col-md-3"><strong>Статус</strong></div>
                                </div>
                                <div class="tbody">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">

            </div>
        </div>
    </div>
</div>
