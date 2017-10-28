<?php
namespace frontend\models;
use common\helpers\Tools;
use common\models\Goods;
use common\models\GoodsAttr;
use common\models\Product;
use common\models\UploadForm;
use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "{{%cart}}".
 *
 * @property string $cart_id
 * @property string $goods_sn
 * @property string $product_id
 * @property string $goods_name
 * @property string $goods_price
 * @property integer $buy_number
 * @property string $attr_list
 * @property string $goods_id
 * @property string $user_id
 *
 * @property Goods $goods
 * @property User $user
 */
class Cart extends \yii\db\ActiveRecord
{
    public $product_sn;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cart}}';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_price'], 'number'],
            [['buy_number', 'goods_id', 'user_id'], 'integer'],
            [['goods_id'], 'required'],
            [['goods_sn', 'product_id'], 'string', 'max' => 25],
            [['goods_name'], 'string', 'max' => 120],
            [['attr_list'], 'string', 'max' => 45],
            [['goods_id'], 'exist', 'skipOnError' => true, 'targetClass' => Goods::className(), 'targetAttribute' => ['goods_id' => 'goods_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cart_id' => 'Cart ID',
            'goods_sn' => 'Goods Sn',
            'product_id' => 'Product ID',
            'goods_name' => 'Goods Name',
            'goods_price' => 'Goods Price',
            'buy_number' => 'Buy Number',
            'attr_list' => '规格',
            'goods_id' => 'Goods ID',
            'user_id' => 'User ID',
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGoods()
    {
        return $this->hasOne(Goods::className(), ['goods_id' => 'goods_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
//    public function getUser()
//    {
//        return $this->hasOne(User::className(), ['user_id' => 'user_id']);
//    }
    public static function addToCart($gid,$num,$spec)
    {
        // code 1:成功;0:失败;
        // $result = ['msg'=>'','code'=>1];
        // 假设用户已登录 UID = 1;
        if(Yii::$app->user->isGuest)
        {
            return ['msg'=>'请先登录后再操作.','code'=>0];
        }
        else
        {
            $userId = Yii::$app->user->getId();
        }
        // 1.验证库存
        $info = self::getInfo($gid,$spec);
        if(!empty($info) && $info['product_num'] > $num)
        {
            // 判断购物车中是否有此商品
            $cart = self::find()->where('user_id=:uid AND goods_id=:gid AND attr_list=:spec',[':gid'=>$gid,':uid'=>$userId,':spec'=>$spec])
                ->one();
            if(is_null($cart))
            {
                // 没有记录
                $info['buy_number'] = $num;
                $info['user_id'] = $userId;
                $newCart = (new self());
                if($newCart->load(['Cart'=>$info]) && $newCart->validate())
                {
                    if($newCart->save())
                    {
                        return ['msg'=>'添加购物车成功.','code'=>1];
                    }
                    else
                    {
                        return ['msg'=>'添加购物车失败.','code'=>0];
                    }
                }
                else
                {
                    return ['msg'=>$newCart->getFirstErrors(),'code'=>0];
                }
            }
            else
            {
                // 购物车中已存在
                $cart->buy_number += $num;
                if($cart->save())
                {
                    return ['msg'=>'添加购物车成功.','code'=>1];
                }
                else
                {
                    return ['msg'=>'添加购物车失败.','code'=>0];
                }
            }
        }
        else
        {
            return ['msg'=>'库存不足','code'=>0];
        }
    }
    /**
     * 获取购物车商品信息（含库存）
     *
     * @param $gid
     * @param $spec
     * @return array|null|\yii\db\ActiveRecord
     */
    static function getInfo($gid,$spec)
    {
        if(empty($spec))
        {
            // 查商品库存
            $goods = Goods::find()->select('goods_name,goods_id,goods_sn,shop_price as goods_price,goods_number as product_num')
                ->where('goods_id=:gid',[':gid'=>$gid])
                ->andWhere(['is_on_sale'=>Goods::IS_ON_SALE,'is_delete'=>Goods::IS_NOT_DELETE])
                ->asArray()
                ->one();
            // 该商品是否促销中
            return $goods;
        }
        else
        {
            // 查货品库存
            $product = Product::find()->select('product_id,product_price AS goods_price,product_sn as goods_sn,attr_list,goods_id,product_num')
                ->where('goods_id=:gid AND attr_list=:attrs',[':gid'=>$gid,':attrs'=>$spec])
                ->asArray()->one();
//            echo $query->createCommand()->getRawSql();
            if(!is_null($product))
            {
                $goods = Goods::find()->select('goods_name')->where(['goods_id'=>$product['goods_id']])->asArray()->one();
                $product['goods_name'] = $goods['goods_name'];
            }
            return $product;
        }
    }
    /**
     * 获取当前登录用户的购物车信息
     *
     * @return array
     */
    static function getCartList()
    {
        $goodsAmount = 0;       // 商品总金额
        $orderAmount = 0;       // 订单总金额
        $shipFee = 0;           // 配送费用
        $data = ['goodsList'=>[],'format_ship_fee'=>0,'format_order_amount'=>0,'format_goods_amount'=>0];     // 返回的购物车数据
        $uid = Yii::$app->user->getId();
        $carts = self::findAll(['user_id'=>$uid]);
        if(!is_null($carts))
        {
            $upload = new UploadForm();
            $goodsList = [];
            foreach ($carts as $key=>$goods)
            {
                $tempGoods = ArrayHelper::toArray($goods);
                $tempGoods['brand_name'] = $goods->goods->brand->brand_name;
                $tempGoods['thumb'] = $upload->getDownloadUrl($goods->goods->goods_img,'catbest');
                $tempGoods['format_goods_total'] = Tools::formatMoney($tempGoods['goods_price']*$tempGoods['buy_number']);
                if(!empty($tempGoods['attr_list']))
                {
                    $tempGoods['spec'] = GoodsAttr::getFormatSpec($tempGoods['attr_list']);
                }
                $tempGoods['format_goods_price'] = Tools::formatMoney($tempGoods['goods_price']);
                $tempGoods['url'] = Tools::buildUrl(['product/index','gid'=>$goods['goods_id']]);
                $goodsAmount += $tempGoods['goods_price']*$tempGoods['buy_number'];
                $goodsList[] = $tempGoods;
            }
            // 配送费用
            $shipFee = ($goodsAmount >= 88) ? 0 : 10;
            // 订单费用
            $orderAmount = $shipFee + $goodsAmount;
            return ['goodsList'             =>$goodsList,
                    'format_ship_fee'       =>Tools::formatMoney($shipFee),
                    'format_order_amount'   =>Tools::formatMoney($orderAmount),
                    'format_goods_amount'   =>Tools::formatMoney($goodsAmount),
                    'shipping_fee'          =>$shipFee,
                    'order_amount'          =>$orderAmount,
                    'goods_amount'          =>$goodsAmount
            ];
        }
        else
        {
            return $data;
        }
    }
    /**
     * 清空购物车
     *
     * @return int
     */
    static function clearAll()
    {
        $uid = Yii::$app->user->getId();
        return self::deleteAll(['user_id'=>$uid]);
    }
}