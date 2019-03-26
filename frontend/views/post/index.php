<?php

use \frontend\widgets\post\PostWidget;
use \yii\helpers\Url;

$this->title = Yii::t('app','Article');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-sm-9">
        <?=PostWidget::widget()?>
    </div>
    <div class="col-sm-3">
        <div class="col-lg-12">
            <?php if(!Yii::$app->user->isGuest):?>
                <a href="<?=Url::to('/post/create')?>" class="btn btn-block btn-primary">创建文章</a>
            <?php endif;?>
        </div>
        <div class="col-lg-12">
            <?=\frontend\widgets\hot\HotWidget::widget()?>
            <?=\frontend\widgets\tag\TagWidget::widget()?>
        </div>
    </div>
</div>


