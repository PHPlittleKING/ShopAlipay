<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\helpers\Tools;
/**
 * This is the model class for table "{{%category}}".
 *
 * @property integer $cat_id
 * @property string $cat_name
 * @property string $cat_desc
 * @property integer $parent_id
 * @property integer $sort
 * @property integer $is_nav
 * @property integer $is_show
 * @property integer $filter_attr
 */
class Category extends \yii\db\ActiveRecord
{
    const IS_SHOW = 1;      // 展示
    const BASE_CATE = 0;    // 根分类
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'sort', 'is_show'], 'integer'],
            [['cat_name'], 'string', 'max' => 255],
            [['parent_id'],'default','value'=>0],
            [['cat_name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cat_id' => '自增ID',
            'cat_name' => '分类名称',
            'parent_id' => '该分类的子id',
            'sort' => '该分类在页面显示的顺序,数字越大顺序越靠后,同数字,id在前的先显示',
            'is_show' => '是否在前台页面显示 1显示; 0不显示',
        ];
    }
    //递归
    static function actionGetData($data,$parent_id=0,$level=1,$exception=''){
       // var_dump($exception);die;
        static  $catList=[];
        foreach ($data as $key => $value) {
            if($value['parent_id']==$parent_id &&$value['cat_id']!=$exception){
                $value['level']=$level;
                $catList[]=$value;
                self::actionGetData($data,$value['cat_id'],$level+1,$exception);
            }
        }
        return $catList;

    }

//进行查询
    public function  getPrefixCateList($id){

        //查询所有数据
        $cat= Category::find()->asArray()->all();
        //var_dump($cat);die;
        //将数据进行分层
        $catList= $this->actionGetData($cat,0,1,$id);

        $array=[];
        foreach ($catList as $k=>$v){
            $cat_name=str_repeat('*',(($v['level'])-1)*3).$v['cat_name'];

            $array[$v['cat_id']]=$cat_name;

        }

        return $array;
    }
    static public function getLevelCategories($categories=[],$except='',$parentId=0,$level=0)
    {
        static $result = [];
        if(is_array($categories))
        {
            foreach ($categories as $key=>$value)
            {
                if($value['parent_id'] == $parentId && $value['cat_id'] != $except)
                {
                    $value['level'] = $level;
                    $result[] = $value;
                    self::getLevelCategories($categories,$except,$value['cat_id'],$level+1);
                }
            }
        }
        return $result;
    }
    //商品种类查询
    public function dropDownList()
    {
        $result = [];
        $typeList = self::find()->select('cat_id,cat_name')->where(['parent_id'=>0])->asArray()->all();

        foreach ($typeList as $value)
        {
            $result[$value['cat_id']] = $value['cat_name'];
        }
        return $result;
    }

    /**
     * 查询全部商品分类
     *
     * @param int $pid
     * @return array|\yii\db\ActiveRecord[]
     */
    static function getNavigation($pid=self::BASE_CATE)
    {
        $baseCats = self::find()->select('cat_id,cat_name,parent_id')
            ->where(['is_show'=>self::IS_SHOW,'parent_id'=>$pid])
            ->asArray()
            ->all();

        if(is_array($baseCats))
        {
            foreach ($baseCats as $key=>$value)
            {
                $baseCats[$key]['url'] = Url::to(['category/index','cid'=>$value['cat_id']]);
                $baseCats[$key]['son'] = self::getNavigation($value['cat_id']);
            }
        }
        return $baseCats;
    }



    /**
     * 根据ID查询分类信息
     *
     * @param $cid
     */
    static public function getCategoryInfo($cid)
    {
        return self::find()->select('cat_id,cat_name,parent_id')
            ->where('cat_id=:cid',[':cid'=>$cid])
            ->asArray()
            ->one();
    }

    /**
     * 获取分类下面包屑导航
     *
     * @param $cid
     * @return string
     */
    static public function getBreadcrumb($cid,$trail='')
    {
        $parents = self::getParentsCategory($cid);
        $breadUrl = '<a href="'.Tools::buildUrl(['index/index']).'">首页 </a>';
        while($catInfo = array_pop($parents))
        {
            $breadUrl .= '&rsaquo; <a href="'.Tools::buildUrl(['category/index','cid'=>$catInfo['cat_id']]).'">'.$catInfo['cat_name'].' </a>';
        }
        return empty($trail) ? $breadUrl : $breadUrl . '&rsaquo; &nbsp;&nbsp;' . $trail;
    }
    /**
     * 根据分类ID查询父级
     *
     * @param $cid
     * @return array
     */
    static function getParentsCategory($cid)
    {
        static $urHere = [];
        if($cid == self::BASE_CATE)
        {
            return $urHere;
        }
        $catInfo = self::getCategoryInfo($cid);
        $urHere[] = $catInfo;
        return self::getParentsCategory($catInfo['parent_id']);
    }

    /**
     * 查询指定分类下子分类并构造成In条件
     *
     * @param $catId
     * @return array
     */
    static function buildInCondition($catId)
    {

        $allCategories = self::find()->select('cat_id,parent_id,cat_name')->asArray()->all();
        $childs = self::getLevelCategories($allCategories,'',$catId);
        $cids = ArrayHelper::getColumn($childs,'cat_id');
        array_push($cids,$catId);

        return ['in','cat_id',$cids];
    }
    /**
     * 查询指定分类下搜索条件
     *
     * @param $cid
     * @return array
     */
    static function getFilter($cid)
    {
        // 查询品牌筛选条件
        $filterBrand = Goods::find()->select('b.brand_id,brand_name,count(1) AS num')
            ->joinWith('brand AS b',false,'INNER JOIN')
            ->where(self::buildInCondition($cid))
            ->andWhere(['is_delete'=>Goods::IS_NOT_DELETE,'is_on_sale'=>Goods::IS_ON_SALE])
            ->groupBy('b.brand_id')
            ->having('num>=1')
            ->orderBy(['b.sort'=>SORT_ASC])
            ->asArray()
            ->limit(20)
            ->all();
        // 标识选中的品牌
        $bids = Yii::$app->request->get('bid','');
        if(is_array($filterBrand) && !empty($bids))
        {
            foreach ($filterBrand as $key=>$value)
            {
                $filterBrand[$key]['checked'] = in_array($value['brand_id'],$bids);
            }
        }

        // 价格区间
        $filterPrice = Goods::find()
            ->select('floor(MIN(shop_price)) AS min_price,round(MAX(shop_price)) AS max_price ')
            ->where(self::buildInCondition($cid))
            ->andWhere(['is_delete'=>Goods::IS_NOT_DELETE,'is_on_sale'=>Goods::IS_ON_SALE])
            ->asArray()
            ->one();
        // 单个商品时或多个商品价格区间相同时
        if($filterPrice['min_price'] == $filterPrice['max_price'])
        {
            $filterPrice['min_price'] = 1;
            $filterPrice['slider_value'] = '[1'.','.$filterPrice['max_price'].']';
        }
        else
        {
            $filterPrice['slider_value'] = '['.$filterPrice['min_price'].','.intval($filterPrice['max_price']/2).']';
        }
        return ['filterBrand'=>$filterBrand,'filterPrice'=>$filterPrice];
    }

}
