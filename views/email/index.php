<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;
use app\components\SwitchPerPage;

/* @var $this yii\web\View */
/* @var $model app\modules\dashboard\models\Email */
/* @var $importModel app\modules\dashboard\models\import\ImportCsv */
/* @var $searchModel app\modules\dashboard\models\search\EmailSearch */
/* @var $dataProvider app\modules\dashboard\models\search\EmailSearch */
/* @var $emailGroups app\modules\dashboard\models\EmailGroups */
/* @var $emailGroupsList app\modules\dashboard\models\EmailGroups */
/* @var $emailToGroups app\modules\dashboard\models\EmailToGroups */

$this->title = Yii::t('app', 'WEBME_EMAIL_LIST');
$this->params['breadcrumbs'][] = ['label' =>Yii::t('app', 'NAV_DASHBOARD'), 'url' => ['/dashboard']];
$this->params['breadcrumbs'][] = Yii::t('app', 'WEBME_EMAIL');

$openFilter=(isset($_GET['EmailSearch']))? 'show':'';
?>
<div class="row email-list">
    <div class="col-sm-12 container">
        <div class="card">
            <div class="card-header">
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="card-body">

                <?= Html::a(Yii::t('app', 'BUTTON_CREATE').'<i class="fa fa-plus fa-lg ml-3"></i>', ['create'], ['class' => 'btn btn-success my-1']) ?>
                <?= Html::button(Yii::t('app', 'BUTTON_IMPORT').'<i class="fa fa-download fa-lg ml-3 mr-5"></i>'.Yii::t('app', 'BUTTON_EXPORT').'<i class="fa fa-upload fa-lg ml-3" aria-hidden="true"></i>', ['class' => 'btn btn-success open-block my-1', 'data-class'=>'import-export-block']) ?>
                <?= Html::button(Yii::t('app', 'WEBME_EMAIL_GROUPS').'<i class="fa fa-check-square-o fa-lg ml-3" aria-hidden="true"></i>', ['class' => 'btn btn-success my-1', 'data-toggle'=>'collapse','data-target'=>'.email-groups-change',  'data-class'=>'filter-block']) ?>
                <?= Html::button(Yii::t('app', 'BUTTON_SEARCH').'<i class="fa fa-search fa-lg ml-3" aria-hidden="true"></i>', ['class' => 'btn btn-primary open-block my-1', 'data-class'=>'filter-block']) ?>
                <?= SwitchPerPage::widget(['count' => '25,50,100,150,200,250']) ?>

                <div class="collapse email-groups-change">
                    <div class="row py-1">
                        <div class="col-md-12">
                            <div class="card card-accent-success">
                                <div class="card-header"><strong>
                                        <?=Yii::t('app', 'WEBME_EMAIL_GROUPS')?></strong>
                                    <?php // echo Html::button(Yii::t('app', 'BUTTON_CLOSE') . '', ['class' => 'btn btn-danger tooltips', 'data-toggle' => 'collapse', 'data-target' => '.email-groups-change', 'data-class' => 'filter-block', 'title' => 'Закрыть настройку групп']) ?>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="card">
                                            <div class="card-header"><?=Yii::t('app', 'WEBME_EMAIL_GROUPS_CHOOSE')?></div>
                                            <div class="card-body">
    <?php echo Html::checkboxList('email-group-selected', 'null', $emailGroupsList, ['class'=>'' , 'itemOptions' =>['class' => 'email-group-selected']]);?>
                                             </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="card">
                                            <div class="card-header"><?=Yii::t('app', 'WEBME_EMAIL_GROUPS_ON_PAGE')?></div>
                                            <div class="card-body">
                                                <button type="button" class="btn btn-primary tooltips" title="Выбрать все email на данной странице" onclick="checkElements('check-email')">Выбрать все на странице</button>
                                                <button type="button" class="btn btn-primary tooltips" title="Снять выбранные email на данной странице" onclick="uncheckElements('check-email')">Снять все на странице</button>
                                                <button type="button" class="btn btn-success tooltips set-group-email" title="Добавить в выбранную группу">Добавить</button>
                                                <button type="button" class="btn btn-danger tooltips del-group-email" title="Удалить из выбранной группы">Удалить</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="card">
                                            <div class="card-header"><?= Yii::t('app', 'WEBME_EMAIL_GROUPS_ALL') ?></div>
                                            <div class="card-body">
                                                <button type="button" class="btn btn-success tooltips set-all-group-email" title="Добавить все email в выбранные группы"><?= Yii::t('app', 'WEBME_EMAIL_GROUPS_ADD_ALL') ?></button>
                                                <button type="button" class="btn btn-danger tooltips del-all-group-email" title="Удалить все email из выбранные группы"><?= Yii::t('app', 'WEBME_EMAIL_GROUPS_DEL_ALL') ?> </button>
                                            </div>
                                        </div>
                                    </div>
                               </div>
                                <div class="card-footer">
                                    <ul>
                                        <li>Для множественного добавления email-ов в группу, выберите необходимые email, потом выберите группы и нажмите добавить</li>
                                        <li>Для множественного удаления email-ов из группы, выберите необходимые email, потом выберите необходимую группу и нажмите удалить</li>
                                        <li>Если нужно добавить/удалить все существующие email в группу/группы, выберите группу/группы и нажмите "Добавить все"/"Удалить все"</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="close-block filter-block <?=$openFilter?>">
                    <div class="row py-1">
                        <div class="col-md-12">
                            <div class="card card-accent-primary">
                                <div class="card-header"><?=Yii::t('app', 'BUTTON_SEARCH')?></div>
                                <div class="card-body">
                                    <?= $this->render('_search', ['model' => $searchModel, 'emailGroupsList' => $emailGroupsList]) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="close-block import-export-block">
                    <div class="row py-1">
                        <div class="col-md-6">
                            <div class="card card-accent-success">
                                <div class="card-header">Импорт</div>
                                <div class="card-body">
                                    <?php $form = ActiveForm::begin(['id' => 'form-id-csvfile', 'options' => ['enctype' => 'multipart/form-data']]) ?>
                                    <?= $form->field($importModel, 'csvFile')->fileInput(['class'=>'csvFile']) ?>
                                    <button type="submit" class="btn btn-success">Загрузить</button>
                                    <?php ActiveForm::end(); ?>
                                </div>
                                <div class="card-footer"><ul><li>Разделитель ";"</li><li>Формат строки "Email ; Описание ; id группы"</li></ul></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-accent-success">
                                <div class="card-header">Экспорт</div>
                                <div class="card-body">
                                    <a href="<?=Url::current(['EmailSearch' => null], true)?>/export" class="btn btn-success export-csvfile">Выгрузить</a>
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
                    'viewParams' => [
                        'emailGroups' => $emailGroups,
                        'emailToGroups' => $emailToGroups,
                    ],
                    'pager' => [
                        'firstPageLabel' => '««',
                        'lastPageLabel' => '»»',
                    ],
                ]); ?>

            </div>
            <div class="card-footer">

            </div>
        </div>
    </div>
</div>