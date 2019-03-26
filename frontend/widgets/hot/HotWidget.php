<?php

namespace frontend\widgets\hot;

use common\models\PostExtends;
use common\models\Posts;
use yii\bootstrap\Widget;
use yii\db\Query;

class HotWidget extends Widget
{
    public $title = null;
    public $limit = 6;

    public function run()
    {
        $res = (new Query())
            ->select(['b.id','b.title','a.browser'])
            ->from(['a' => PostExtends::tableName()])
            ->leftJoin(['b' => Posts::tableName()], 'a.post_id=b.id')
            ->where(['b.is_valid' => Posts::IS_VALID])
            ->orderBy(['a.browser' => SORT_DESC, 'b.id'=>SORT_DESC])
            ->limit($this->limit)
            ->all();

        $result['title'] = $this->title ?? "热门文章";
        $result['body']  = $res ?? [];


        return $this->render('index', ['data'=>$result]);
     }
}