<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cats".
 *
 * @property int $id 自增ID
 * @property string $cat_name 分类名称
 */
class Cats extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cats';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'       => Yii::t('app', 'ID'),
            'cat_name' => Yii::t('app', 'Cat Name'),
        ];
    }

    /**
     * 获取所有分类
     *
     * @return array
     */
    public static function getAllCats()
    {
        $cats = ['0' => Yii::t('app', 'noData')];
        $res  = self::find()->all();
        if (!empty($res)) {
            foreach ($res as $cat) {
                $cats[$cat->id] = $cat->cat_name;
            }
        }

        return $cats;
    }
}
