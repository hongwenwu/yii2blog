<?php
/**
 * Created by PhpStorm.
 *
 * describe:  留言板表单
 * User: hongwenwu
 * Date: 2019-03-22
 * Time: 22:25
 */

namespace frontend\models;

use common\models\Feeds;
use yii\base\Model;
use yii\db\Exception;

class FeedForm extends Model
{
    public $id;
    public $content;
    public $_lastError;

    public function rules()
    {
        return [
            ['content', 'required'],
            ['content', 'string', 'max' => 255]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'      => '编号',
            'content' => '内容'
        ];
    }

    public function getList()
    {

        $model = new Feeds();
        $res   = $model->find()
            ->limit(10)
            ->with('user')
            ->orderBy(['id' => SORT_DESC])
            ->asArray()
            ->all();

        return $res;
    }

    public function create()
    {
        try{
            $model = new Feeds();
            $model->content = $this->content;
            $model->created_at = time();
            $model->user_id = \Yii::$app->getUser()->identity->getId();

            if(!$model->save()){
                throw new Exception('保存失败');
            }

            return true;
        }catch (Exception $e){
            $this->_lastError = $e->getMessage();
            return false;
        }
    }
}