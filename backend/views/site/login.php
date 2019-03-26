<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '登录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sign-overlay"></div>
<div class="signpanel"></div>

<div class="panel signin">
    <div class="panel-heading">
        <h4 class="panel-title">欢迎登陆博客系统</h4>
    </div>
    <div class="panel-body">
        <button class="btn btn-primary btn-quirk btn-fb btn-block">联系我们</button>
        <div class="or">or</div>
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

        <?= $form->field($model, 'username', [
            'options' => ['class' => 'form-group'],
            'inputTemplate'=>"<div class='input-group'><span class='input-group-addon'><i class='glyphicon glyphicon-user'></i></span>{input}</div>"
        ])
            ->label(false)
            ->textInput(['autofocus' => true,
                         'placeholder' => $model->getAttributeLabel(Yii::t('app', 'Username'))]) ?>

        <?= $form->field($model, 'password', [
            'options' => ['class' => 'form-group'],
            'inputTemplate' => "<div class='input-group'><span class='input-group-addon'><i class='glyphicon glyphicon-lock'></i></span>{input}</div>"
        ])
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel(Yii::t('app', 'Password'))]) ?>

        <?= $form->field($model, 'rememberMe')->checkbox() ?>

        <div class="form-group">
            <?= Html::submitButton('登录', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div><!-- panel -->
