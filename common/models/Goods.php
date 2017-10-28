<?php

namespace common\models;

use backend\models\GoodsType;
use common\helpers\Tools;
use Yii;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%goods}}".
 *
 * @property string $goods_id
 * @property string $goods_name
 * @property string $goods_sn
 * @property string $type_id
 * @property string $cat_id
 * @property string $brand_id
 * @property string $click_count
 * @property integer $goods_number
 * @property string $goods_weight
 * @property string $market_price
 * @property string $shop_price
 * @property integer $warn_number
 * @property string $goods_brief
 * @property string $goods_desc
 * @property string $goods_thumb
 * @property string $goods_img
 * @property integer $is_on_sale
 * @property integer $is_shipping
 * @property string $add_time
 * @property integer $sort
 * @property integer $is_delete
 * @property integer $is_best
 * @property integer $is_new
 * @property integer $is_hot
 * @property integer $last_update
 * @property integer $is_promote
 * @property string $promote_price
 * @property string $promote_start_date
 * @property string $promote_end_date
 *
 * @property Cart[] $carts
 * @property Brand $brand
 * @property Category $cat
 * @property GoodsType $type
 * @property GoodsAttr[] $goodsAttrs
 * @property Attribute[] $attrs
 * @property GoodsGallery[] $goodsGalleries
 * @property Product[] $products
 */
class Goods extends \yii\db\ActiveRecord
{
    const IS_PROMOTE = 1;           // 是否促销
    const IS_NOT_PROMOTE = 0;       // 不促销
    const IS_NOT_DELETE = 0;        // 回收站
    const IS_ON_SALE = 1;           // 上架

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_name', 'cat_id', 'brand_id', 'is_promote'], 'required'],
            [['cat_id', 'brand_id', 'click_count', 'goods_number', 'warn_number', 'is_on_sale', 'is_shipping', 'add_time', 'sort', 'is_delete', 'is_best', 'is_new', 'is_hot', 'last_update', 'is_promote', 'promote_start_date', 'promote_end_date'], 'integer'],
            [['goods_weight', 'market_price', 'shop_price', 'promote_price'], 'number'],
            [['goods_desc'], 'string'],
            [['goods_name'], 'string', 'max' => 255],
            [['goods_sn'], 'string', 'max' => 45],
            [['goods_brief'], 'string', 'max' => 255],
            [['goods_thumb', 'goods_img'], 'string', 'max' => 120],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => Brand::className(), 'targetAttribute' => ['brand_id' => 'brand_id']],
            [['cat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['cat_id' => 'cat_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'goods_name' => 'Goods Name',
            'goods_sn' => 'Goods Sn',
            'type_id' => 'Type ID',
            'cat_id' => 'Cat ID',
            'brand_id' => 'Brand ID',
            'click_count' => 'Click Count',
            'goods_number' => 'Goods Number',
            'goods_weight' => 'Goods Weight',
            'market_price' => 'Market Price',
            'shop_price' => 'Shop Price',
            'warn_number' => 'Warn Number',
            'goods_brief' => 'Goods Brief',
            'goods_desc' => 'Goods Desc',
            'goods_thumb' => 'Goods Thumb',
            'goods_img' => 'Goods Img',
            'is_on_sale' => '是否精品',
            'is_shipping' => 'Is Shipping',
            'add_time' => 'Add Time',
            'sort' => 'Sort',
            'is_delete' => 'Is Delete',
            'is_best' => '精品',
            'is_new' => '新品',
            'is_hot' => '热销',
            'last_update' => 'Last Update',
            'is_promote' => 'Is Promote',
            'promote_price' => 'Promote Price',
            'promote_start_date' => 'Promote Start Date',
            'promote_end_date' => 'Promote End Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarts()
    {
        return $this->hasMany(Cart::className(), ['goods_id' => 'goods_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(Brand::className(), ['brand_id' => 'brand_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCat()
    {
        return $this->hasOne(Category::className(), ['cat_id' => 'cat_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(GoodsType::className(), ['type_id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGoodsAttrs()
    {
        return $this->hasMany(GoodsAttr::className(), ['goods_id' => 'goods_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttrs()
    {
        return $this->hasMany(Attribute::className(), ['attr_id' => 'attr_id'])->viaTable('{{%goods_attr}}', ['goods_id' => 'goods_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGoodsGalleries()
    {
        return $this->hasMany(GoodsGallery::className(), ['goods_id' => 'goods_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['goods_id' => 'goods_id']);
    }

    public function beforeValidate()
    {
        if(parent::beforeValidate())
        {
            if(!empty($this->promote_price))
            {
                $this->is_promote = self::IS_PROMOTE;
            }

            // 生成货号
            $this->goods_sn = Tools::createGoodsSn();

            // 处理促销时间
            $this->promote_start_date = strtotime($this->promote_start_date);
            $this->promote_end_date = strtotime($this->promote_end_date);
            $this->add_time = time();
            return true;
        }
        return false;
    }

    /**
     * 商品添加
     */
    public function createGoods()
    {
        if($this->load(Yii::$app->request->post()) && $this->validate())
        {
            return $this->save(false);
        }
        return false;
    }

    /**
     * 搜索
     */
    public function  readWhere($sql){
        $post =yii::$app->request->get();
        if(!empty($post['brand_id'])){
            $sql->andwhere(['brand_id'=>$post['brand_id']]);
        }
        if(!empty($post['cat_id'])){
            $sql->andWhere(['cat_id'=>$post['cat_id']]);
        }
        if(!empty($post['is_on_sale'])){
            $sql->andWhere(['is_on_sale'=>$post['is_on_sale']]);
        }
        if(!empty($post['goods_name'])){
            $sql->andWhere(['like','goods_name',$post['goods_name']]);
        }
        return $sql;
    }

    public function aa($sql,$name)
    {
        $post =yii::$app->request->get();

        if($name=='is_best'){
            $sql->andWhere(['is_best'=>'1']);
        }
        if($post['goodsList_id']=='is_new'){
            $sql->andWhere(['is_new'=>'1']);
        }
        if($post['goodsList_id']=='is_hot'){
            $sql->andWhere(['is_hot'=>'1']);
        }
        if($post['goodsList_id']=='is_promote'){
            $sql->andWhere(['is_promote'=>'1']);
        }
        return $sql;
    }

    /**
     * 处理商品列表数据
     *
     * @param $query
     * @return array
     */
    static function disposeGoodsData($query)
    {
        $result = [];
        if(is_array($query))
        {
            $upload = (new UploadForm());
            foreach ($query as $key=>$value)
            {
                $result[$key] = ArrayHelper::toArray($value);
                $result[$key]['brand_name'] = $value->brand->brand_name;
                $result[$key]['discount'] = ceil(($value['shop_price'] / $value['market_price'])*100).'%';
                $result[$key]['thumb'] = $upload->getDownloadUrl($value['goods_img'],'recommend');
                $result[$key]['prothumb'] = $upload->getDownloadUrl($value['goods_img'],'thumb');
                $result[$key]['catbest'] = $upload->getDownloadUrl($value['goods_img'],'catbest');
                $result[$key]['shop_price'] = Tools::formatMoney($value['shop_price']);
                $result[$key]['market_price'] = Tools::formatMoney($value['market_price']);
                $result[$key]['url'] = Tools::buildUrl(['product/index','gid'=>$value['goods_id']]);
            }
        }
        return $result;
    }

    /**
     * 查询推荐商品
     *
     * @param string $type      // 类型 is_best,is_new,is_hot
     * @param int $offset       // 偏移量
     * @param int $limit        // 限制条数
     * @param int $cid          // 分类ID
     * @return array
     */
    static public function getRecommendGoods($type='is_best',$offset=0,$limit=4,$cid='')
    {
        if(!in_array($type,['is_best','is_new','is_hot']))
        {
            return [];
        }
        $query = self::find()
            ->select('goods_id,goods_name,market_price,shop_price,brand_id,goods_img,is_new,is_hot,is_best')
            ->where(['is_on_sale'=>self::IS_ON_SALE,'is_delete'=>self::IS_NOT_DELETE,$type=>1,'is_promote'=>self::IS_NOT_PROMOTE]);
        // 指定分类
        if(!empty($cid))
        {
            $query->andWhere(Category::buildInCondition($cid));
        }
        $queryObj = $query->offset($offset)
            ->limit($limit)
            ->all();
        return self::disposeGoodsData($queryObj);
    }

    /**
     * 查询促销商品
     *
     * @param string $catId
     * @param int $offset
     * @param int $limit
     * @return array
     */
    static function getPromoteGoods($catId='',$offset=0,$limit=7)
    {
        $query = self::find()
            ->select('goods_id,goods_name,market_price,shop_price,brand_id,goods_img,is_new,is_hot,is_best')
            ->where(['is_on_sale'=>self::IS_ON_SALE,'is_delete'=>self::IS_NOT_DELETE,'is_promote'=>self::IS_PROMOTE])
            ->offset($offset)
            ->limit($limit)
            ->all();
        return self::disposeGoodsData($query);
    }

    /**
     * 查询指定分类下商品列表
     *
     * @param $catId
     * @return array
     */
    static function getGoodsByCatId($catId,$map=[])
    {
        $query = self::find()
            ->select('goods_id,goods_name,goods_brief,market_price,shop_price,brand_id,goods_img,is_new,is_hot,is_best')
            ->where(Category::buildInCondition($catId))
            ->andWhere(['is_on_sale'=>self::IS_ON_SALE,'is_delete'=>self::IS_NOT_DELETE]);
        // 使用搜索条件
        if(!empty($map))
        {
            foreach ($map as $value)
            {
                $query->andWhere($value);
            }
        }
        // 分页
        $pagination = new Pagination(['totalCount'=>$query->count(),'defaultPageSize'=>3]);
        // 根据分页限制查询数据
        $goodsQuery = $query->offset($pagination->offset)->limit($pagination->limit)->all();
        return ['goodsList'=>self::disposeGoodsData($goodsQuery),'pagination'=>$pagination];
    }

    /**
     * 查询商品详情
     */
    static function getGoodsInfo($gid)
    {
        $res = [];

        $query = self::find()
            ->select('goods_id,cat_id,goods_name,goods_brief,market_price,shop_price,brand_id,goods_img,is_new,is_hot,is_best,goods_desc')
            ->where('goods_id=:gid',[':gid'=>$gid])
            ->andWhere(['is_on_sale'=>self::IS_ON_SALE,'is_delete'=>self::IS_NOT_DELETE])
            ->one();

        //关联查询品牌
        if (isset($query) && !empty($query))
        {
            $res = ArrayHelper::toArray($query);

            $res['shop_price'] = Tools::formatMoney($res['shop_price']);
            $res['market_price'] = Tools::formatMoney($res['market_price']);
            $res['url'] = Tools::buildUrl(['product/index','gid'=>$res['goods_id']]);
            $res['brand_name'] = $query->brand->brand_name;

            //关联查询相册
            $res['galleries'] = (new GoodsGallery)->getGalleries($gid);

            //关联查询规格属性
            $arrtibute = (new GoodsAttr)->getAttribute($gid);
            $res['spec'] = isset($arrtibute['spec']) ? $arrtibute['spec'] : '';
            $res['attr'] = isset($arrtibute['attr']) ? $arrtibute['attr'] : '';
        }
        return $res;
    }

    static function historyList($gids)
    {
        if(!empty($gids))
        {
            $query = self::find()
                ->select('goods_id,goods_name,market_price,shop_price,brand_id,goods_img,is_new,is_hot,is_best')
                ->where(['is_on_sale'=>self::IS_ON_SALE,'is_delete'=>self::IS_NOT_DELETE])
                ->andWhere(['in','goods_id',$gids])
                ->all();
            if(!empty($query))
            {
                return self::disposeGoodsData($query);
            }
        }
        return [];
    }
}