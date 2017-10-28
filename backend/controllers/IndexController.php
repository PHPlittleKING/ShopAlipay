<?php
/**
 * Created by PhpStorm.
 * User: CrazyT
 * Date: 2017/9/6
 * Time: 21:47
 */

namespace backend\controllers;


use yii;
use yii\web\Controller;
use yii\filters\AccessControl;

//公共控制器
class IndexController extends Controller
{
    /**
     * ACF 认证
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [],
                        'allow' => true,
                        'roles' => ['@'],       //认证用户
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
}