<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Posts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="posts-form">

    <?php $form = ActiveForm::begin(['options' => ['class'=>'form']]); ?>

    <?= $form->field($model, 'title')->textInput(['autofocus' => true]) ?>
    <?= $form->field($model, 'summary')->textarea() ?>
    <?= $form->field($model, 'content')->widget('common\widgets\ueditor\Ueditor', [
        'options' => [
            'initialFrameWidth' => '100%',
            'toolbars'          => [
                ['source','customstyle', 'paragraph', 'fontfamily', 'fontsize','|','undo', 'redo', '|',
                    'imagenone', 'imageleft', 'imageright', 'imagecenter','|',
                    'simpleupload', 'insertimage', 'emotion', 'scrawl', 'help']],
        ]
    ]) ?>

    <?= $form->field($model, 'label_img')->widget('common\widgets\file_upload\FileUpload', [
        'config' => [
            //图片上传的一些配置，不写调用默认配置
            'domain_url' => Yii::$app->params['wwwUrl']
        ]
    ]) ?>

    <?= $form->field($model, 'cat_id')->dropDownList($catsList) ?>

    <?= $form->field($model, 'is_valid')->dropDownList([
            '0'=>"不发布",
            '1'=>"发布"
    ]) ?>

    <?= $form->field($model, 'tags')->widget('common\widgets\tags\TagWidget') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
