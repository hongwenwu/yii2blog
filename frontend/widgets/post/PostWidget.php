<?php

/**
 * 文章
 */

namespace frontend\widgets\post;

use common\models\Posts;
use common\models\RelationPostTags;
use common\models\Tags;
use frontend\models\PostForm;
use yii\base\Widget;
use yii\data\Pagination;
use yii\helpers\Url;

class PostWidget extends Widget
{
    public $title = null;
    public $page = true;
    public $limit = 6;
    public $more = true;

    public function run()
    {
        $curPage = \Yii::$app->request->get('page', 1);
        $tagName     = \Yii::$app->request->get('tag');

        $cond    = [];
        if ($tagName) {
            $tags    = new Tags();
            $tag = $tags
                ->find()
                ->with('postid')
                ->where(['tag_name'=>$tagName])
                ->asArray()
                ->one();

            if (isset($tag['postid']) && !empty($tag['postid'])) {
                foreach ($tag['postid'] as $v) {
                    $id[] = $v['post_id'];
                }
                $cond = ['id' => $id, 'is_valid' => Posts::IS_VALID];
            }
        }

        $model = new PostForm();
        $res   = $model->getList($cond, $curPage, $this->limit);

        $data['title'] = $this->title ?? '最新文章';
        $data['more']  = Url::to('/post/index');
        $data['body']  = $res['data'] ?? [];

        if ($this->page) {
            $pages        = new Pagination(['totalCount' => $res['count'], 'pageSize' => $res['pageSize']]);
            $data['page'] = $pages;
        }

        return $this->render("index", ['data' => $data]);
    }
}

?>