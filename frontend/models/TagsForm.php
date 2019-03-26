<?php

namespace frontend\models;

use common\models\Posts;
use common\models\Tags;
use Yii;
use yii\base\Model;
use yii\bootstrap\Tabs;
use yii\db\Exception;

//use yii\web\UploadedFile;


/**
 * ContactForm is the model behind the contact form.
 */
class TagsForm extends Model
{
    public $id;
    public $tags;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['tags', 'each', 'rule' => ['string']]
        ];
    }

    public function saveTags()
    {
        $ids = [];
        if (!empty($this->tags)) {
            foreach ($this->tags as $tag) {
                $ids[] = $this->_saveTag($tag);
            }
        }


        return $ids;
    }

    private function _saveTag($tag)
    {
        $model           = new Tags();
        $res = $model->find()->where(['tag_name' => $tag])->one();
        if (empty($res)) {
            $model->tag_name = $tag;
            $model->post_num = 1;

            if (!$model->save()) {
                throw new Exception('标签保存失败');
            }

            return $model->id;

        } else {

            $res->updateCounters(['post_num' => 1]);
            return $res->id;
        }

    }
}
