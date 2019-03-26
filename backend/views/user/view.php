<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title                   = "用户信息:" . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">
    <?= DetailView::widget([
        'model'      => $model,
        'attributes' => [
            'id',
            'username',
            'email:email',
            'status' => [
                'attribute' => 'status',
                'value'     => function ($model) {
                    return $model->status == 10 ? "已激活" : "未激活";
                }
            ],
            'created_at:datetime',
            'updated_at:datetime',
            'avatar' => [
                'attribute' => 'avatar',
                'format'    => 'raw',
                'value'     => function ($model) {
                    return '<img height="80" src="' . Yii::$app->params['wwwUrl'] . $model->avatar . '"/>';
                }
            ],
        ],
    ]) ?>
    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method'  => 'post',
            ],
        ]) ?>
    </p>

</div>
