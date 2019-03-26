<?php
/**
 * Created by PhpStorm.
 *
 * describe:  PostController.php
 * User: hongwenwu
 * Date: 2019-03-22
 * Time: 00:49
 */

namespace frontend\controllers;


use common\models\Cats;
use common\models\PostExtends;
use frontend\models\PostForm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

//use yii\web\UploadedFile;

class PostController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['index', 'create', 'view', 'upload'],
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow'   => true
                    ],
                    [
                        'actions' => ['create', 'upload'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ]
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    '*' => ['get', 'post'],
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'upload'  => [
                'class'  => 'common\widgets\file_upload\UploadAction',     //这里扩展地址别写错
                'config' => [
                    'imagePathFormat' => "/uploads/{yyyy}{mm}{dd}/{time}{rand:6}",
                ]
            ],
            'ueditor' => [
                'class'  => 'common\widgets\ueditor\UeditorAction',
                'config' => [
                    //上传图片配置
                    'imageUrlPrefix'  => "", /* 图片访问路径前缀 */
                    'imagePathFormat' => "/uploads/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
                ]
            ],
        ];
    }

    /**
     * 首页
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render("index");
    }

    /**
     * 创建
     *
     * @return string
     */
    public function actionCreate()
    {
        $model = new PostForm();
        $model->setScenario(PostForm::SCENARIO_CREATE);

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
//            $model->label_img = UploadedFile::getInstance($model, 'label_img');
//            if ($model->upload()) {
//                echo "文件上传成功".$model->label_img;
//                die;
//            }
            if (!$model->create()) {
                \Yii::$app->session->setFlash('warning', $model->_lastError);
            } else {
                return $this->redirect(['post/view', 'id' => $model->id]);
            }
        }

        $catsList = Cats::getAllCats();

        return $this->render('create', [
            'model'    => $model,
            'catsList' => $catsList
        ]);
    }

    /**
     * 文章详细页面
     *
     * @param $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView($id)
    {
        // 统计次数
        $model = new PostExtends();
        $model->updateCount(['post_id' => $id], 'browser', 1);

        $model = new PostForm();
        $post  = $model->getPostById($id);

        return $this->render('view', ['post' => $post]);
    }

    /**
     * 更新
     * @param $id
     * @return string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        // 表单方法查询
        $model = new PostForm();
        $model->setScenario(PostForm::SCENARIO_UPDATE);

        $data = $model->getPostById($id);

        // 加载表单模型数据
        $model->loadPost($data);

        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if(!$model->update()){
                \Yii::$app->session->setFlash('warning', $model->_lastError);
            }else{
                return $this->redirect(['post/view', 'id' => $model->id]);
            }
        }

        $catsList = Cats::getAllCats();

        return $this->render('update', [
            'model'    => $model,
            'catsList' => $catsList
        ]);
    }
}