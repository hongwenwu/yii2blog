<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = Yii::t('app', 'Posts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-index">

    <p>
        <?= Html::a(Yii::t('app', 'Create Posts'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],
//            'id',
            'title'    => [
                'attribute' => 'title',
                'format'    => 'raw',
                "value"     => function ($model) {
                    return '<a target="_blank" href="' . Yii::$app->params['wwwUrl'] . \yii\helpers\Url::to(['post/view', 'id' => $model->id]) . '">' . $model->title . '</a>';
                }
            ],
            'summary'  => [
                'attribute'=>'summary',
                'value' => function ($model) {
                    return strip_tags(str_replace("&nbsp;", '',$model->summary));
                }
            ],
//            'content:ntext',
//            'label_img',
            'cat.cat_name',
            //'user_id',
            'user_name',
            'is_valid' => [
                'attribute' => 'is_valid',
                'value' => function ($model) {
                    return $model->is_valid ? "是" : "否";
                }
            ],
            'created_at:datetime',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
