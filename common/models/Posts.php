<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "posts".
 *
 * @property int $id 自增ID
 * @property string $title 标题
 * @property string $summary 摘要
 * @property string $content 内容
 * @property string $label_img 标签图
 * @property int $cat_id 分类id
 * @property int $user_id 用户id
 * @property string $user_name 用户名
 * @property int $is_valid 是否有效：0-未发布 1-已发布
 * @property int $created_at 创建时间
 * @property int $updated_at 更新时间
 */
class Posts extends BaseModel
{
    const IS_VALID = 1;
    const NO_VALID = 0;


    public $tags = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'posts';
    }

    /*
     * 关联
     */
    public function getRelate()
    {
        return $this->hasMany(RelationPostTags::className(), ['post_id' => 'id']); // post_id 外键,  id 主键
    }

    /*
     * 关联
     */
    public function getExtend()
    {
        return $this->hasOne(PostExtends::className(), ['post_id' => 'id']); // post_id 外键,  id 主键
    }

    public function getCat()
    {
        return $this->hasONe(Cats::className(), ['id' => 'cat_id']); // 数组 主键=>外键
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['cat_id', 'user_id', 'created_at', 'updated_at', 'is_valid'], 'integer'],
            [['title', 'summary', 'label_img', 'user_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => Yii::t('app', 'ID'),
            'title'      => '标题',
            'summary'    => '总结',
            'content'    => '内容',
            'label_img'  => '标签图',
            'cat_id'     => '分类',
            'user_id'    => '用户编号',
            'user_name'  => '用户名',
            'is_valid'   => '是否发布',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'tags'       => '标签'
        ];
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        $this->user_id   = Yii::$app->user->identity->id;
        $this->user_name = Yii::$app->user->identity->username;

        return parent::save($runValidation, $attributeNames);
    }

    public function behaviors()
    {
        return [
            [
                'class'              => BlameableBehavior::className(),
                'createdByAttribute' => 'created_at',
                'updatedByAttribute' => 'updated_at',
            ],
            'timestamp' => [
                'class'      => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }
}
