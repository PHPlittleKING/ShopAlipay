<?php
/**
 * Created by PhpStorm.
 * User: 张志国
 * Date: 2017/9/12 0012
 * Time: 19:30
 */

namespace common\models;

use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\base\Model;

class UploadForm extends Model
{
    public $imageFile;
    public $qiniuConfig;                // 七牛配置
    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->qiniuConfig = \Yii::$app->params['qiniu'];
    }
   public function rules()
 {
     return [
         [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
       ];
   }
    private $rootPath = 'imageFile';

    public function upload()
   {
        if(is_null($this->imageFile)){
            return null;
        }

        if ($this->validate()){

            $path=  $this->createPath();
            $baseName=$this->checkFileName();
            $fileName= $path  . $baseName . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs($fileName);

            return $fileName;
       } else {
         return false;
     }
   }

    //生成一个图片目录
    public function createPath(){

        $path = $this->rootPath.'/'.date('Y').'/'.date('m').'/'.date('d').'/';
        // 创建
        if(!file_exists($path))
        {
            if(!mkdir($path,0777,true))
            {
                $this->error = '创建目录失败';
                return false;
            }
        }
        return $path;

    }
    //生成图片名字
    public function checkFileName(){

        $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randLetter = substr(str_shuffle($str), -5);
        $file= time().rand(10000,99999).$randLetter.$extension;

        return $file;


    }
    public function uploadToQiNiu(){
        // code 0:上传成功；100:验证失败；200:入库失败；
        $result = ['code'=>0,'msg'=>'上传成功.','data'=>['src'=>'','url'=>'']];
        if($this->validate())
        {
            $fileName = $this->createFileName() . '.' . $this->imageFile->extension;

            $auth = new Auth($this->qiniuConfig['accessKey'],$this->qiniuConfig['secretKey']);

            $token = $auth->uploadToken($this->qiniuConfig['bucket']);
            list($ret,$err) = (new UploadManager())->putFile($token,$fileName,$this->imageFile->tempName);
            if($err == null)
            {
                // 成功
                $result['data']['src'] = $ret['key'];
                $result['data']['url'] = $this->getDownloadUrl($ret['key']);
            }
            else
            {
                $result['msg'] = $err->message();
                $result['code'] = $err->code();
            }
        }
        else
        {
            // 验证失败
            $result['code'] = 100;
            $result['msg'] = implode("\n",$this->getErrors('imageFile'));
        }

        return $result;
    }
    //创建文件名
    protected function createFileName()
    {
        return $fileName = uniqid() . rand(10000,99999);
    }
    //生成下载路径
    public function getDownloadUrl($fileName,$thumb='')
    {
        $auth = new Auth($this->qiniuConfig['accessKey'],$this->qiniuConfig['secretKey']);
        $baseUrl = empty($thumb) ? $this->qiniuConfig['domain'].$fileName : $this->qiniuConfig['domain'].$fileName . '?'. $this->qiniuConfig['imageView'][$thumb];
        return $auth->privateDownloadUrl($baseUrl);
    }

    public function  del($value){

        $auth = new Auth($this->qiniuConfig['accessKey'],$this->qiniuConfig['secretKey']);
        $config = new \Qiniu\Config();
        $bucketManager = new \Qiniu\Storage\BucketManager($auth, $config);
        $err = $bucketManager->delete($this->qiniuConfig['bucket'],$value);

    }

}