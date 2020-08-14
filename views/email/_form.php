<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\components\ButtonCreateUpdatePage;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
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
    <?= ButtonCreateUpdatePage::widget(['id' => $id,'closeUrl' => '/dashboard/email']) ?>
</div>
<hr>

        <div class="col-md-12">
            <?= $form->field($model, 'email',[
                    'template' => '<div class="form-group row"><div class="col-md-12"><div class="input-group" title="Введите email" data-toggle="tooltip">
        <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-tag"></i>{label}</span></div>{input}{error}</div></div></div>'])->textInput(['maxlength' => 50,'autocomplete' => 'off']) ?>
        </div>

        <div class="col-md-12">
            <?= $form->field($model, 'description',[
                    'template' => '<div class="form-group row"><div class="col-md-12"><div class="input-group" title="Введите описание" data-toggle="tooltip">
        <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-tag"></i>{label}</span></div>{input}{error}</div></div></div>'])->textInput(['maxlength' => 200,'autocomplete' => 'off']) ?>
        </div>


        <div class="col-md-12">
            <?php /* $form->field($model, 'id_groups',[
                'template' => '<div class="form-group row"><div class="col-md-12"><div class="input-group form-control">
                <div class="input-group-prepend"><span class="input-group-text">{label}</span></div>{input}{error}</div></div></div>'])->checkboxList($emailGroups,array('prompt' => Yii::t('app', 'SELECT_NOT_SET')))

            //Html::checkboxList('email-group-selected', 'null', $emailGroupsList, ['class'=>'form-control' ,   'itemOptions' =>['class' => 'email-group-selected']]);
           //$form->field($model, 'id_groups')->checkboxList( $emailGroupsList )->label('тест?')           */?>
        </div>

<div class="clearfix"></div>
    <?php ActiveForm::end(); ?>


