<?php
/**
 * Created by PhpStorm.
 *
 * describe:  留言板
 * User: hongwenwu
 * Date: 2019-03-22
 * Time: 22:23
 */

namespace frontend\widgets\feed;

use frontend\models\FeedForm;
use yii\base\Widget;

class FeedWidget extends Widget
{
    public function run()
    {
        $model = new FeedForm();

        $data['feed'] = $model->getList();

        return $this->render("index", ['data'=>$data]);
    }
}