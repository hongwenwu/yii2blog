<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Posts */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'summary'  => [
                    'attribute'=>'summary',
                'value' => function ($model) {
                    return strip_tags(str_replace("&nbsp;", '',$model->summary));
                }
            ],
            'content:raw',
            'label_img'=>[
                'attribute' => 'label_img',
                'format'    => 'raw',
                'value'     => function ($model) {
                    return '<img height="180" src="' . Yii::$app->params['wwwUrl'] . $model->label_img . '"/>';
                }
            ],
            'cat.cat_name',
            'user_id',
            'user_name',
            'is_valid' => [
                'attribute' => 'is_valid',
                'value' => function ($model) {
                    return $model->is_valid ? "是" : "否";
                }
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

</div>
