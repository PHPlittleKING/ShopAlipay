<?php
/**
 * Created by PhpStorm.
 * User: CrazyT
 * Date: 2017/9/12
 * Time: 17:21
 */

namespace backend\controllers;

use Yii;
use common\models\UploadForm;
use yii\web\UploadedFile;

class AdminController extends IndexController
{
    public function actionInfo()
    {
        $model = new UploadForm();
        $admin = Yii::$app->user->getIdentity();
        $admin->scenario = 'update';

        if (Yii::$app->request->isPost)
        {

            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->upload())
            {
                @unlink($admin->avatar);
                $admin->avatar = $model->file;
            }

            if (!$admin->updateAdminInfo())
            {
                echo '修改失败';
            }

        }

        return $this->render('info',['model'=>$model,'admin'=>$admin]);
    }
}