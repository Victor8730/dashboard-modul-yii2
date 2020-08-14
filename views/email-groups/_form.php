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
    <?= ButtonCreateUpdatePage::widget(['id' => $id,'closeUrl' => '/dashboard/email-groups']) ?>
</div>
<hr>


        <div class="col-md-12">
            <?= $form->field($model, 'title',[
                    'template' => '<div class="form-group row"><div class="col-md-12"><div class="input-group" title="Введите описание" data-toggle="tooltip">
        <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-tag"></i>{label}</span></div>{input}{error}</div></div></div>'])->textInput(['maxlength' => 200,'autocomplete' => 'off']) ?>
        </div>

        <div class="col-md-12">
            <?= $form->field($model, 'description',[
                    'template' => '<div class="form-group row"><div class="col-md-12"><div class="input-group" title="Введите описание" data-toggle="tooltip">
        <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-tag"></i>{label}</span></div>{input}{error}</div></div></div>'])->textInput(['maxlength' => 200,'autocomplete' => 'off']) ?>
        </div>

        <div class="col-md-12">
            <?= $form->field($model, 'color',[
                    'template' => '<div class="form-group row"><div class="col-md-12"><div class="input-group" title="Выберите цвет" data-toggle="tooltip">
        <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-tag"></i>{label}</span></div>{input}{error}</div></div></div>'])->dropDownList(['secondary'=>Yii::t('app', 'COLOR_SECONDARY'),'primary'=>Yii::t('app', 'COLOR_PRIMARY'),'success'=>Yii::t('app', 'COLOR_SUCCESS'),'warning'=>Yii::t('app', 'COLOR_WARNING'),'danger'=>Yii::t('app', 'COLOR_DANGER')],
                [ 'prompt' => Yii::t('app', 'SELECT_NOT_SET'), 'options' => [
                        'secondary'=>['class'=> 'btn-secondary'],'primary'=>['class'=> 'btn-primary'], 'success'=>['class'=> 'btn-success'] , 'warning'=>['class'=> 'btn-warning'], 'danger'=>['class'=> 'btn-danger']
                ]
                ]) ?>
        </div>


<div class="clearfix"></div>
    <?php ActiveForm::end(); ?>


