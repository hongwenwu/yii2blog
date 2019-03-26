<?php
/**
 * Created by PhpStorm.
 *
 * describe:  基础模型
 * User: hongwenwu
 * Date: 2019-03-22
 * Time: 00:59
 */

namespace common\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

class BaseModel extends ActiveRecord
{

    /**
     * 获取分页数据
     *
     * @param ActiveQuery $query
     * @param int $page
     * @param int $pageSize
     * @param null $search
     * @return mixed
     */
    public function getPage($query, $curPage = 1, $pageSize = 10, $search = null)
    {
        if ($search)
            $query->andFilterWhere($search);

        $data['count'] = $query->count();

        if (!$data['count']) {
            return $data = [
                'count' => 0, 'curPage' => $curPage, 'pageSize' => $pageSize, 'star' => 0, 'end' => 0, 'data' => []
            ];
        }

        $curPage = (ceil($data['count'] / $pageSize) < $curPage) ?
            ceil($data['count'] / $pageSize) :
            $curPage;

        $data['curPage'] = $curPage;
        $data['star']    = ($curPage - 1) * $pageSize + 1; // 起始页
        $data['end']     = (ceil($data['count'] / $pageSize) == $curPage) ?
            $data['count'] :
            ($curPage - 1) * $pageSize + $pageSize;; // 最后一页

        $data['pageSize'] = $pageSize;


        $data['data'] = $query->offset(($curPage-1)*$pageSize)
            ->limit($pageSize)
            ->asArray()
            ->all();

        return $data;
    }
}