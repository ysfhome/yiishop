<?php
/**
 * User: 张世路
 * Date: 2016/9/25
 * Time: 21:46
 */

namespace app\admin\controllers;

use yii\web\Controller;

class BaseController extends Controller{

    public function beforeAction($action)
    {
        if(!\Yii::$app->session->has('admin')){
            $this->redirect(['public/login']);
            return false;
        }
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

}