<?php
/**
 * Created by PhpStorm.
 *
 * describe:  create.php
 * User: hongwenwu
 * Date: 2019-03-22
 * Time: 01:11
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title                   = Yii::t('app', 'createArticle');
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Article'),
    'url'   => ['/post/index']
];

$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <?php $form = ActiveForm::begin(['id' => 'post-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
        <div class="col-lg-5">
            <?= $form->field($model, 'title')->textInput(['autofocus' => true]) ?>
            <?= $form->field($model, 'summary')->textarea() ?>
            <?= $form->field($model, 'content')->widget('common\widgets\ueditor\Ueditor', [
                'options' => [
                    'initialFrameWidth' => '100%',
                    'toolbars'          => [
                        ['customstyle', 'paragraph', 'fontfamily', 'fontsize','|','undo', 'redo', '|',
                        'imagenone', 'imageleft', 'imageright', 'imagecenter','|',
                            'simpleupload', 'insertimage', 'emotion', 'scrawl', 'help']],
                ]
            ]) ?>

        </div>
        <div class="col-lg-5">
            <?= $form->field($model, 'label_img')->widget('common\widgets\file_upload\FileUpload', [
                'config' => [
                    //图片上传的一些配置，不写调用默认配置
                    'domain_url' => 'http://www.yii2blog.cn',
                ]
            ]) ?>
            <?= $form->field($model, 'cat_id')->dropDownList($catsList) ?>
            <?= $form->field($model, 'tags')->widget('common\widgets\tags\TagWidget') ?>
            <div class="form-group">
                <?= Html::submitButton('发布', ['class' => 'btn btn-primary', 'name' => 'post-button']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

</div>

