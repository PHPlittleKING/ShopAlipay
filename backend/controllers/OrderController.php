<?php
namespace backend\controllers;

use backend\models\Shipping;
use common\models\OrderInfo;
use Yii;

class OrderController extends IndexController
{
    public function actionIndex()
    {
        $data = OrderInfo::getOrderList();
//        var_dump($data);die;
        return $this->render('index',['data'=>$data]);
    }

    public function actionDetail()
    {
        $this->layout = 'main';
        return $this->render('detail');
    }

    public function actionShip()
    {
        $this->layout = 'main';
        $order = OrderInfo::getOrderList();
//        var_dump($order);die;
        $shipList = Shipping::getShipList();
//       var_dump($shipList);die;
        if(Yii::$app->request->isPost)
        {
            $data = Yii::$app->request->post();
            var_dump($data);
        }
        return $this->render('ship',['order'=>$order,'shipList'=>$shipList]);
    }
}