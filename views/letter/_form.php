<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\assets\KeditorAsset;
use app\components\ButtonCreateUpdatePage;
KeditorAsset::register($this);

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

<?php

$script = <<< JS
$('#content-area').keditor();
JS;
$this->registerJs($script, yii\web\View::POS_READY);
?>

<div class="form-group">
    <?= ButtonCreateUpdatePage::widget(['id' => $id,'closeUrl' => '/dashboard/letter']) ?>
</div>
<hr>

        <div class="col-md-12">
            <?= $form->field($model, 'title',[
                    'template' => '<div class="form-group row"><div class="col-md-12"><div class="input-group" title="Введите название письма, например название расылки" data-toggle="tooltip">
        <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-tag"></i>{label}</span></div>{input}{error}</div></div></div>'])->textInput(['maxlength' => 50,'autocomplete' => 'off']) ?>
        </div>

        <div class="col-md-12">
            <?= $form->field($model, 'text')->textInput(['type' => 'hidden', 'id'=>'letter-html']) ?>

            <div data-keditor="html">
                <div id="content-area">
                    <?= $model->text?>
                </div>
            </div>
        </div>

<div class="clearfix"></div>
    <?php ActiveForm::end(); ?>


