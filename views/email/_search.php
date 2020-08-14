<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\dashboard\models\search\EmailSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="email-search py-1">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

        <?= $form->field($model, 'email',[
            'template' => '<div class="form-group row"><div class="col-md-12"><div class="input-group">{input}
                <span class="input-group-append"><button class="btn btn-primary" type="button"><i class="fa fa-envelope-o"></i></button></span>
{error}</div></div></div>'
        ])->textInput(['maxlength' => 50,'autocomplete' => 'off']) ?>

		
		        <?php  echo $form->field($model, 'id_groups',[
            'template' => '<div class="form-group row"><div class="col-md-12"><div class="input-group">{input}
                <span class="input-group-append"><button class="btn btn-primary" type="button"><i class="fa fa-envelope-o"></i></button></span>
{error}</div></div></div>'
        ])->dropDownList($emailGroupsList,['prompt' => 'Выберите группу:']) ?>

		
    <div class="form-group">
        <?= Html::submitButton('Искать', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Сбросить',Url::current(['EmailSearch' => null]), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>