<?php

namespace common\helpers;
use yii;
use common\models\Goods;
class Tools
{
    static function success($msg='',$url=[],$skip=true,$wait=3)
    {
        $url = !empty($url) ? yii\helpers\Url::toRoute($url) : '';
        Yii::$app->session->setFlash('alerts',['msg'=>$msg,'url'=>$url,'state'=>1,'wait'=>$wait,'skip'=>$skip]);
    }
    static function error($msg,$url=[],$skip=true,$wait=3)
    {
        $url = !empty($url) ? yii\helpers\Url::toRoute($url) : '';
        Yii::$app->session->setFlash('alerts',['msg'=>$msg,'url'=>$url,'state'=>0,'wait'=>$wait,'skip'=>$skip]);
    }
    static  function getSn(){
        $snPrefix=  yii::$app->params['snPrefix'];
        $goods_sn=$snPrefix.strtoupper(uniqid()).rand(1000,9999);
        if(Goods::find()->select('goods_sn')->where('goods_sn=:sn',[':sn'=>$goods_sn])->count() > 0){
            return self::getSn();
        }
        return $goods_sn;
    }
    /**
     * 格式化金额
     *
     * @param $value
     * @return string
     */
    static function formatMoney($value)
    {
        return '￥'.$value;
    }
    /**
     * 构建Url
     *
     * @param $params
     * @return string
     */
    static function buildUrl($params)
    {
        return yii\helpers\Url::to($params);
    }

    static function history($gid='')
    {
        $requestCookies = Yii::$app->request->cookies;
        if(!empty($gid))
        {
            // 存储历史记录
            if($requestCookies->has('gid'))
            {
                // 有记录
                $gids = $requestCookies->getValue('gid');
                array_unshift($gids,$gid);
                $gids = array_unique($gids);
                while(count($gids) > 12)
                {
                    array_pop($gids);
                }
                $responseCookies = Yii::$app->response->cookies;
                $responseCookies->add(new yii\web\Cookie(['name'=>'gid','value'=>$gids]));
            }
            else
            {
                // 第一次存入
                $responseCookies = Yii::$app->response->cookies;
                $responseCookies->add(new yii\web\Cookie(['name'=>'gid','value'=>[$gid]]));
            }
        }
        else
        {
            // 读取历史记录
            return $requestCookies->getValue('gid');
        }
    }
}