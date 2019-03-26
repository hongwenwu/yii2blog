<?php

/* @var $this yii\web\View */

use \frontend\widgets\post\PostWidget;
use \frontend\widgets\carousel\CarouselWidget;
use \frontend\widgets\feed\FeedWidget;
use \frontend\widgets\hot\HotWidget;

$this->title = '博客-首页';
?>
<div class="site-index">

    <div class="row">
        <div class="col-lg-9">
            <div class="col-lg-12">
                <!--                轮播-->
                <?= CarouselWidget::widget() ?>
            </div>
            <div class="col-lg-12">
                <!--                文章列表-->
                <?= PostWidget::widget(['page' => false]) ?>
            </div>
        </div>
        <div class="col-lg-3">
            <!-- 留言板 -->
            <?= FeedWidget::widget() ?>

            <!-- 热门 -->
            <?= HotWidget::widget() ?>

            <!-- 标签云 -->
            <?= \frontend\widgets\tag\TagWidget::widget() ?>

        </div>
    </div>

</div>

</div>
