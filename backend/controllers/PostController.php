<?php

namespace backend\controllers;

use common\models\Cats;
use common\models\RelationPostTags;
use common\models\Tags;
use Yii;
use common\models\Posts;
use backend\models\PostSearch;
use backend\controllers\BaseController;
use yii\db\Query;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PostController implements the CRUD actions for Posts model.
 */
class PostController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
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
                    'imagePathFormat' => "/../../frontend/web/uploads/{yyyy}{mm}{dd}/{time}{rand:6}",
                ]
            ],
            'ueditor' => [
                'class'  => 'common\widgets\ueditor\UeditorAction',
                'config' => [
                    //上传图片配置
                    'imageUrlPrefix'  => Yii::$app->params['wwwUrl'], /* 图片访问路径前缀 */
                    'imagePathFormat' => "/../../frontend/web/uploads/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
                ]
            ],
        ];
    }


    /**
     * Lists all Posts models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Posts model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Posts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model         = new Posts();

        if ($model->load(Yii::$app->request->post()) && $model->save() ) {
            if (!empty(Yii::$app->request->post('Posts')['tags'])){
                $tags = Yii::$app->request->post('Posts')['tags'];
                $this->_addTag($model, $tags);
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        $catsList = Cats::getAllCats();

        return $this->render('create', [
            'model'    => $model,
            'catsList' => $catsList,
        ]);
    }

    /**
     * Updates an existing Posts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (!empty(Yii::$app->request->post('Posts')['tags'])){
                $tags = Yii::$app->request->post('Posts')['tags'];
                $this->_addTag($model, $tags);
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }


        $catsList = Cats::getAllCats();
        return $this->render('update', [
            'model'    => $model,
            'catsList' => $catsList
        ]);
    }

    public function _addTag($model, $tags = [])
    {
        $tagsIds = [];

        if(empty($tags)){
            return false;
        }

        foreach ($tags as $t) {
            if ($tag = Tags::findOne(['tag_name' => $t])) {
                $tag->updateCounters(['post_num' => 1]);
                $tagsIds[] = $tag->id;
            } else {
                $tag           = new Tags();
                $tag->tag_name = $t;
                $tag->post_num = 1;
                $tag->save(false);
                $tagsIds[] = $tag->id;
            }
        }

        // 重建关联
        RelationPostTags::deleteAll(['post_id' => $model->id]);

        if (!empty($tagsIds)) {
            foreach ($tagsIds as $k => $tagId) {
                $row[$k]['post_id'] = $model->id;
                $row[$k]['tag_id']  = $tagId;
            }

            $query = new Query();
            $res   = $query->createCommand()
                ->batchInsert(RelationPostTags::tableName(), ['post_id', 'tag_id'], $row)
                ->execute();
            if (!$res) {
                throw new Exception('文章标签关系映射失败');
            }
        }

    }

    /**
     * Deletes an existing Posts model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Posts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Posts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function findModel($id)
    {
        $res = Posts::find()
            ->with('relate.tag', 'extend')
            ->where(['id' => $id])
            ->one();

        if (empty($res)) {
            throw  new NotFoundHttpException("文章不存在");
        }

        $res->tags = [];
        if (isset($res->relate) && !empty($res->relate)) {
            foreach ($res->relate as $relate) {
                $res->tags[] = $relate->tag->tag_name;
            }
        }

        return $res;
    }

}
