<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\components\ButtonCreateUpdatePage;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $dataLatter app\modules\dashboard\models\Letter */
/* @var $dataEmailGroup app\modules\dashboard\models\EmailGroups */
?>


    <?php $form = ActiveForm::begin([
        'id' => 'form-id-'.$id,
        'fieldConfig' => [
            'errorOptions'         => [
                'tag'   => 'p',
                'class' => 'help-block help-block-error',
            ],
        ],
    ]); ?>

<div class="form-group">

    <?php
    if(!empty($id)){
        echo Html::a(Yii::t('app', 'BUTTON_SHOW'), ['view', 'id' => $id],['class' => 'btn btn-success mr-1','title'=>Yii::t('app','WEBME_MAILING_SHOW'), 'data-toggle'=>'tooltip' , 'data' => ['method' => 'post']]);
    }
    ?>
    <?= ButtonCreateUpdatePage::widget(['id' => $id,'closeUrl' => '/dashboard/mailing']) ?>
</div>
<hr>

<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h2>Параметры рассылки</h2>
        </div>
        <div class="card-body">
            <div class="col-md-6">
                <?= $form->field($model, 'name',[
                    'template' => '<div class="form-group row"><div class="col-md-12"><div class="input-group" title="Введите название рассылки, например название сайта для которого делается рассылка" data-toggle="tooltip">
        <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-tag"></i>{label}</span></div>{input}{error}</div></div></div>'])->textInput(['maxlength' => 50,'autocomplete' => 'off']) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'subject',[
                    'template' => '<div class="form-group row"><div class="col-md-12"><div class="input-group"  title="Введите тему рассылки, укажите тему которая будет отображатся в письме" data-toggle="tooltip">
        <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-list"></i>{label}</span></div>{input}{error}</div></div></div>'])->textInput(['maxlength' => 100,'autocomplete' => 'off']) ?>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-6">
                <?= $form->field($model, 'delay',[
                    'template' => '<div class="form-group row"><div class="col-md-12"><div class="input-group" title="Выберите время перерыва между отправками" data-toggle="tooltip">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-clock-o"></i>{label}</span></div>{input}{error}</div></div></div>'])->dropDownList(['1000' => '1 секунда','2000' => '2 секунды','5000' => '5 секунд', '15000' => '15 секунд', '60000' => '1 минута', '600000'=>'10 минут', '1800000'=>'30 минут'],['prompt' => Yii::t('app','WEBME_SELECT')]); ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'amount',[
                    'template' => '<div class="form-group row"><div class="col-md-12"><div class="input-group" title="Выберите сколько сообщений оправять за одину отправку" data-toggle="tooltip">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-sort-numeric-asc"></i>{label}</span></div>{input}{error}</div></div></div>'])->dropDownList(['1' => '1 штука', '2' => '2 штуки','5' => '5 штук', '10'=>'10 штук', '20'=>'20 штук'],['prompt' => Yii::t('app','WEBME_SELECT')]);?>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h2>Настройка smtp</h2>
        </div>
        <div class="card-body">
            <div class="col-md-6">
                <?= $form->field($model, 'email_from',[
                    'template' => '<div class="form-group row"><div class="col-md-12"><div class="input-group" title="Введите email с которого будет делаться рассылка, возможен ввод только одного email" data-toggle="tooltip">
                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-user"></i>{label}</span></div>{input}{error}</div></div></div>'])->textInput(
                    ['autocomplete' => 'off','data-role' => 'tags-email','data-text' => 'Указан не email, убедитесь в правильности ввода!', 'data-text-2'=>'Возможен ввод только одного email','data-count' => 'single']) ?>
             </div>
            <div class="col-md-6">
                <?= $form->field($model, 'email_from_pass',[
                    'template' => '<div class="form-group row"><div class="col-md-12"><div class="input-group"  title="Введите пароль smtp" data-toggle="tooltip">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-unlock"></i>{label}</span></div>{input}{error}</div></div></div>'])->textInput(['maxlength' => 100,'autocomplete' => 'off']) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'email_from_host',[
                    'template' => '<div class="form-group row"><div class="col-md-12"><div class="input-group"  title="Введите хост smtp сервера" data-toggle="tooltip">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-share"></i>{label}</span></div>{input}{error}</div></div></div>'])->textInput(['maxlength' => 100,'autocomplete' => 'off']) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'email_from_port',[
                    'template' => '<div class="form-group row"><div class="col-md-12"><div class="input-group"  title="Введите порт smtp сервера" data-toggle="tooltip">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-plug"></i>{label}</span></div>{input}{error}</div></div></div>'])->textInput(['maxlength' => 100,'autocomplete' => 'off']) ?>
            </div>
            <div class="col-md-12">
                <?= $form->field($model, 'email_from_info',[
                    'template' => '<div class="form-group row"><div class="col-md-12"><div class="input-group" title="Введите информацию о email с которого будет делаться рассылка" data-toggle="tooltip">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-info"></i>{label}</span></div>{input}{error}</div></div></div>'])->textInput(['maxlength' => true, 'autocomplete' => 'off']) ?>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h2><?=Yii::t('app','WEBME_MAILING_MAILS_LETTER_AND_OTHER_SETTINGS')?></h2>
        </div>
        <div class="card-body">
            <?= $form->field($model, 'email_group',[
                'template' => '<div class="form-group row"><div class="col-md-12"><div class="input-group" title="Выберите группу email" data-toggle="tooltip">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-th-list"></i>{label}</span>
                </div><div class="input-group-append" role="button" title="Создать новую" data-toggle="tooltip"><span class="input-group-text"><a href="/dashboard/email-groups/create" target="_blank"><i class="fa fa-plus"></i></a></span></div>{input}{error}</div></div></div>'])->dropDownList($dataEmailGroup,['prompt' => Yii::t('app','WEBME_SELECT')]); ?>

            <?= $form->field($model, 'email_group_after',[
                'template' => '<div class="form-group row"><div class="col-md-12"><div class="input-group" title="Выберите группу email" data-toggle="tooltip">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-th-list"></i>{label}</span>
                </div>{input}{error}</div></div></div>'])->dropDownList($dataEmailGroup,['prompt' => Yii::t('app','WEBME_SELECT')]); ?>


            <?= $form->field($model, 'email_list',[
                'template' => '<div class="form-group row"><div class="col-md-12"><div class="input-group" title="Введите email которым нужно отправить сообщения, при множественном добавлении делайте розделение email через запятую, например вот так \'test@gmail.com, test2@gmail.com\'. Добавленные email в данное поле не будут сохранены в общий список ваших email!" data-toggle="tooltip">
<div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-list-ol"></i>{label}</span></div>
<div class="input-group-append" role="button" title="Сколько в поле email-ов" data-toggle="tooltip"><span class="input-group-text" data-role="tags-email-count-show"></span></div>
<div class="input-group-append" role="button" title="Очистить поле" data-toggle="tooltip" data-role="tags-email-remove" data-remove="#email-list"><span class="input-group-text"><i class="fa fa-close"></i></span></div>{input}{error}</div></div></div>'])->textInput(
                ['autocomplete' => 'off','data-role' => 'tags-email','data-text' => 'Указан не email, убедитесь в правильности ввода!','data-count' => 'many', 'id'=>'email-list']) ?>

            <?= $form->field($model, 'id_letter',[
                'template' => '<div class="form-group row"><div class="col-md-12"><div class="input-group" title="Выберите шаблон письма" data-toggle="tooltip">
                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-photo"></i>{label}</span>
                </div><div class="input-group-append" role="button" title="Создать новый" data-toggle="tooltip"><span class="input-group-text"><a href="/dashboard/letter/create" target="_blank"><i class="fa fa-plus"></i></a></span></div>{input}{error}</div></div></div>'])->dropDownList($dataLatter,['prompt' => Yii::t('app','WEBME_SELECT')]); ?>

            <?= $form->field($model, 'text',[
                'template' => '<div class="card"><div class="card-header"><span class="input-group-text" title="Введите текст письма" data-toggle="tooltip"><i class="fa fa-paragraph"></i>{label}  - в разработке, пока отправляется  только письмо указанное выше</span></div></div>{input}{error}'])->textarea(['rows' => '3', 'id'=>'text_message']) ?>

        </div>
        <div class="clearfix"></div>
    </div>
</div>


<div class="clearfix"></div>
<?php ActiveForm::end(); ?>


