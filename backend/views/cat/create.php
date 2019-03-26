<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Cats */

$this->title = Yii::t('app', 'Create Cats');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cats'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cats-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
