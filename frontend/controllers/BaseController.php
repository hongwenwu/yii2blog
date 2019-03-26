<?php
/**
 * Created by PhpStorm.
 *
 * describe:  基础控制器
 * User: hongwenwu
 * Date: 2019-03-22
 * Time: 00:37
 */

namespace frontend\controllers;


use yii\web\Controller;

class BaseController extends Controller
{
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action))
            return false;
        return true;
    }

}