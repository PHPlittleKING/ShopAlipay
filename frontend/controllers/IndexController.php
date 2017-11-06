<?php
namespace frontend\controllers;
use common\models\GoodsGallery;
use Yii;
use common\models\Category;
use common\models\Goods;
use frontend\models\Slider;
use yii\elasticsearch;
use app\models\Es;
use yii\helpers\ArrayHelper;


class IndexController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $arr = new Goods();
        $arr = Goods::find()->all();
//        var_dump($arr);die;
//        $arr = explode('-',"伯-伶-佣-低-你-住-位-伴-身-佛-近-彻-役-返-余-希-坐-谷-妥-含-邻-岔-肝-肚-肠");//将文字库整成数组
//        $min = 4;//最小字数
//        $max = 6;//最大字数
//        $len = mt_rand($min,$max);//随机长度
        $str = '';
//        $a_len = count($arr);
//        for($i=0;$i<$len;$i++)
//        {
//            $str .= $arr[mt_rand(0,$a_len-1)];//随机取文字
//        }

        $Es = new Es();
        $Es->primaryKey = 210;//primaryKey 定义 _id
        $name = $str;
        $sex = '男';
        $age = '21';
        $Es->name = $name;
        $Es->sex = $sex;
        $Es->age = $age;
        $Es->create_time = time();
        $Es->save();

        
        die;
        // 查询全部商品分类
        $navigation = Category::getNavigation();
        // 查询轮播图
        $slider = Slider::getSlider();

        // 查询促销商品
        $promotes = Goods::getPromoteGoods();

        $mainPromote = array_pop($promotes);
        $mainPromote['galleries'] = (new GoodsGallery)->getGalleries($mainPromote['goods_id']);

        $this->view->params['footerBestGoods']=Goods::getRecommendGoods('is_best',0,3);
        $this->view->params['footerNewGoods']=Goods::getRecommendGoods('is_new',0,3);
        $this->view->params['footerHostGoods']=Goods::getRecommendGoods('is_hot',0,3);

        $data = [
            'navigation'=>$navigation,
            'slider'    =>$slider,
            'bestGoods' =>Goods::getRecommendGoods(),   // 查询推荐商品
            'newGoods'  =>Goods::getRecommendGoods('is_new'),
            'hotGoods'  =>Goods::getRecommendGoods('is_hot'),
            'promotes'  =>$promotes,
            'mainPromote'=>$mainPromote
        ];


        return $this->render('index',$data);
    }

    public function actiondel(){
        $Es = new Es();
        $customer = $Es::findOne(2801);
//        print_r($customer);die;
        if(empty($customer)){
            die('暂无数据');
        }
        $customer->delete();
    }


    public function actionAbc(){

        $Es = new Es();
        $goods = new Goods();
        $where['match']['name'] = '你';
//        $res = $goods::find()->all();
        $res = $Es::find()->query($where)->all();
//        var_dump($res);die;
        $data = ArrayHelper::toArray($res);
        echo "<pre>";
        print_r($data);

    }
    /**
     * 加载更多
     *
     * @return string
     */
    public function actionLoadMore()
    {
        $type = Yii::$app->request->get('type');
        $page = intval(Yii::$app->request->get('page'));
        $goodsList = Goods::getRecommendGoods($type,$page*4);
        return !empty($goodsList) ? $this->renderPartial('loadmore',['goodsList'=>$goodsList]) : '';
    }

}