<?php

namespace backend\controllers;
use common\helpers\Tools;
use common\models\Category;
use common\models\Goods;
use Yii;

class CategoryController extends IndexController
{
    public function actionCreate()
    {
        $category = (new Category())->loadDefaultValues();
        if (Yii::$app->request->isPost)
        {
           if ($category->load(Yii::$app->request->post()) && $category->validate())
           {
                if ($category->save())
                {
                    Tools::success('分类添加成功','category/index');
                }
                else
                {
                    Tools::error('分类添加失败');
                }
           }
        }
        //下拉数据
        $dropDownList = $category->dropDownList();

        return $this->render('create',['category'=>$category,'dropDownList'=>$dropDownList]);
    }

    /**
     * 分类删除
     */
    public function actionDelete()
    {
        $id = Yii::$app->request->get('id');

        $childCount = Category::find()->where('parent_id=:id',['id'=>$id])->count();
        if (!empty($childCount))
        {
            Tools::error('该分类下有子类，不可删除！');
        }
        else
        {
            $count = Goods::find()->where('cat_id=:cid',[':cid'=>$id])->count();
            if ($count > 0)
            {
                Tools::error('该分类下有商品，不可删除！');
            }
            else
            {
                if(Category::findOne($id)->delete())
                {
                    Tools::success('删除成功！',['category/index']);
                }
                else
                {
                    Tools::error('删除失败！');
                }
            }

        }
        $this->redirect(['category/index']);
    }

    public function actionIndex()
    {
        $categories = Category::getLevelCategories(Category::find()->asArray()->all());
        return $this->render('index',['categories'=>$categories]);
    }

    /**
     * 分类修改
     */
    public function actionUpdate($id)
    {
        $category = Category::findOne($id);

        if(Yii::$app->request->isPost)
        {
            if($category->load(Yii::$app->request->post()) && $category->validate())
            {
                if($res = $category->save())
                {
                    Tools::success('修改成功.','category/index');
                }
                else
                {
                    Tools::error('修改失败.');
                }
            }
            else
            {
                Tools::error('数据不合法');
            }
        }
        // 下拉菜单
        $categories = Category::getLevelCategories(Category::find()->asArray()->all(),$id);
        $dropDownList = $category->dropDownList($categories);

        return $this->render('update',['category'=>$category,'dropDownList'=>$dropDownList]);
    }

}
