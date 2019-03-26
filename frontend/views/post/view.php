<?php
/**
 * Created by PhpStorm.
 *
 * describe:  view.php
 * User: hongwenwu
 * Date: 2019-03-22
 * Time: 13:25
 */
use \yii\helpers\Url;

$this->title                   = $post->title;
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', 'Article'),
    'url'   => ['/post/index']
];

$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
    <div class="col-lg-9">
        <div class="page-title">
            <h1><?= $post->title ?></h1>

            <span>作者:<?= $post->user_name ?></span>
            <span>创建时间:<?= date('Y-m-d H:i:s', $post->created_at) ?></span>
            <span>点击数: <?=!empty($post->extend)? ($post->extend->browser ?? 0) :0?></span>
        </div>
        <div class="page-content">
            <?= $post->content ?>
        </div>
        <div class="page-tag">
            标签:
            <?php foreach ($post->tags as $tag): ?>
                <span class="label label-primary"><?= $tag ?></span>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="col-lg-12">
            <?php if(!Yii::$app->user->isGuest):?>
                <a href="<?=Url::to('/post/create')?>" class="btn btn-block btn-primary">创建文章</a>
                <?php if(Yii::$app->user->identity->id == $post->user_id):?>
                <a href="<?=Url::to( ['/post/update','id'=>$post->id])?>" class="btn btn-block btn-primary">编辑文章</a>
                <?php endif;?>
            <?php endif;?>
        </div>
    </div>
</div>


