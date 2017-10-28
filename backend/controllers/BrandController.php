<?php
/**
 * Created by PhpStorm.
 * User: CrazyT
 * Date: 2017/9/6
 * Time: 22:04
 */

namespace backend\controllers;

use common\helpers\Tools;
use yii;
use common\models\Brand;
use yii\web\Controller;
use yii\data\Pagination;
use yii\filters\AccessControl;


class BrandController extends IndexController
{
    public $layout= 'main';

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

    /**
     * 品牌展示
     * @return string
     */
    public function actionList()
    {
        $brandName = Yii::$app->request->get('brand_name','');
        $map = empty($brandName) ? [] : ['like','brand_name',$brandName];

        $query = Brand::find()->where($map);

        $page = new Pagination(['defaultPageSize'=>Yii::$app->params['pageSize'],'totalCount'=>$query->count()]);
        $brands = $query->offset($page->offset)->limit($page->limit)->all();
        return $this->render('list',['brands'=>$brands,'page'=>$page,'brandName'=>$brandName]);
    }

    /**
     * 品牌添加
     * @return string
     */
    public function actionCreate()
    {
        //默认值
        $brand = (new Brand())->loadDefaultValues();

        if(Yii::$app->request->isPost)
        {
            $post = yii::$app->request->post();
            if($brand->load($post) && $brand->validate())
            {
                $res = $brand->save();
                if($res)
                {
                    Tools::success('品牌添加成功',['brand/list']);
                }
                else
                {
                    Tools::error('品牌添加失败');
                }
            }
        }
        return $this->render('add',['brand'=>$brand]);
    }

    /**
     * 品牌删除
     */
    public function actionDel()
    {
        $id = Yii::$app->request->get('id',0);
        $brand = Brand::findOne($id);
        if($brand->delete())
        {
            $this->redirect(['brand/list']);
        }
        else
        {
            die('del Fail');
        }
    }

    /**
     * 品牌修改
     */
    public function actionUpdate($id)
    {
        $brand = Brand::findOne($id);

        if(Yii::$app->request->isPost)
        {
            if($brand->load(Yii::$app->request->post()) && $brand->validate())
            {
                $res = $brand->save();
                if($res)
                {
                    Tools::success('修改成功.',['brand/list']);
                }
                else
                {
                    Tools::error('没有修改或修改失败');
                }
            }
            else
            {
                Tools::error('数据不合法.');
            }
        }
        return $this->render('update',['brand'=>$brand]);
    }

}