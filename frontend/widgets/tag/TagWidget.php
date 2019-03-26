<?php
/**
 * Created by PhpStorm.
 *
 * describe:  TagWidget.php
 * User: hongwenwu
 * Date: 2019-03-23
 * Time: 18:13
 */

namespace frontend\widgets\tag;

use common\models\Tags;
use yii\base\Widget;

class TagWidget extends Widget
{
    public $title = null;
    public $limit = 6;

    public function run()
    {
        $tags = Tags::find()
            ->limit($this->limit)
            ->orderBy(['post_num' => SORT_DESC])
            ->all();

        $data['title'] = $this->title ?? "标签云";
        $data['body']  = $tags;
        return $this->render('index', ['data' => $data]);
    }
}