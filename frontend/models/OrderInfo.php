<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%order_info}}".
 *
 * @property integer $order_id
 * @property string $order_sn
 * @property integer $order_status
 * @property integer $shipping_status
 * @property integer $pay_status
 * @property string $message
 * @property string $pay_name
 * @property string $shipping_name
 * @property string $goods_amount
 * @property string $shipping_fee
 * @property string $money_paid
 * @property string $surplus
 * @property string $bonuse
 * @property string $order_amount
 * @property integer $create_time
 * @property integer $confirm_time
 * @property integer $pay_time
 * @property integer $shipping_time
 * @property string $consignee
 * @property integer $country
 * @property integer $province
 * @property integer $city
 * @property integer $district
 * @property string $address
 * @property string $zipcode
 * @property string $mobile
 * @property string $user_id
 * @property integer $pay_id
 * @property integer $shipping_id
 * @property string $invoice_no
 *
 * @property OrderAction[] $orderActions
 * @property OrderGoods[] $orderGoods
 * @property Payment $pay
 * @property Shipping $shipping
 * @property User $user
 */
class OrderInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_info}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_status', 'shipping_status', 'pay_status', 'create_time', 'confirm_time', 'pay_time', 'shipping_time', 'country', 'province', 'city', 'district', 'user_id', 'pay_id', 'shipping_id'], 'integer'],
            [['goods_amount', 'shipping_fee', 'money_paid', 'surplus', 'bonuse', 'order_amount'], 'number'],
            [['user_id', 'pay_id', 'shipping_id'], 'required'],
            [['order_sn', 'mobile'], 'string', 'max' => 20],
            [['message', 'address'], 'string', 'max' => 120],
            [['pay_name', 'shipping_name'], 'string', 'max' => 60],
            [['consignee', 'invoice_no'], 'string', 'max' => 45],
            [['zipcode'], 'string', 'max' => 5],
            [['order_sn'], 'unique'],
            [['pay_id'], 'exist', 'skipOnError' => true, 'targetClass' => Payment::className(), 'targetAttribute' => ['pay_id' => 'pay_id']],
            [['shipping_id'], 'exist', 'skipOnError' => true, 'targetClass' => Shipping::className(), 'targetAttribute' => ['shipping_id' => 'shipping_id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Order ID',
            'order_sn' => '订单编号',
            'order_status' => '订单状态(0未确认,1确认,2已完成,3已取消,4无效,5退货 )',
            'shipping_status' => '商品配送情况;(0未发货,1已发货,2已签收,3配货中，4退货 )',
            'pay_status' => '支付状态;0未付款;1已付款 ',
            'message' => '订单附言,由用户提交订单前填写',
            'pay_name' => '支付方式',
            'shipping_name' => '配送方式',
            'goods_amount' => '商品总金额',
            'shipping_fee' => '配送费用',
            'money_paid' => '已付金额',
            'surplus' => '该订单使用余额,取用户设定余额,用户可用余额',
            'bonuse' => '使用红包金额',
            'order_amount' => '应付款金额 ',
            'create_time' => '创建时间',
            'confirm_time' => '订单确认时间',
            'pay_time' => '支付时间',
            'shipping_time' => '发货时间',
            'consignee' => '收货人的姓名',
            'country' => '收货人的国家,用户页面填写,默认取值于表user_address,其id对应的值在region',
            'province' => '收货人的省份,用户页面填写,默认取值于表user_address, 其id对应的值在region',
            'city' => '收货人的城市,用户页面填写,默认取值于表user_address,其id对应的值在region',
            'district' => '收货人的地区,用户页面填写,默认取值于表user_address,其id对应的值在region',
            'address' => '收货人的详细地址,用户页面填写,默认取值于表user_address ',
            'zipcode' => '收货人的邮编,用户页面填写,默认取值于表user_address',
            'mobile' => '收货人的手机,用户页面填写,默认取值于表user_address',
            'user_id' => 'User ID',
            'pay_id' => '支付方式ID',
            'shipping_id' => '配送方式',
            'invoice_no' => '发货单号',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderActions()
    {
        return $this->hasMany(OrderAction::className(), ['order_id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderGoods()
    {
        return $this->hasMany(OrderGoods::className(), ['order_id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPay()
    {
        return $this->hasOne(Payment::className(), ['pay_id' => 'pay_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShipping()
    {
        return $this->hasOne(Shipping::className(), ['shipping_id' => 'shipping_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    //下订单
    static function  placeAnOrder($indent){
        static  $goodsList;
        $id=$indent['id'];
        $address = UserAddress::find()->where(['address_id'=>$indent['addressId']])->one();
       foreach ($id as $k=> $v){
           $goodsList[]=Cart::find()->select('goods_sn,goods_price,buy_number,goods_name')->where(['cart_id'=>$v])->asArray()->one() ;
       }

        foreach ($goodsList as $k=>$v){
            $goodsList[$k]['time']= time();
            $goodsList[$k]['sum']=$v['goods_price']*$v['buy_number'];
        }

    }
}
