<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/29 0029
 * Time: 16:00
 */
namespace app\models;
use Yii;
use yii\base\Model;
/*
 * EntryForm
 * 继承model验证表单
 * **/


class EntryForm extends Model
{
    public $name;
    public $email;
    public function rules()
    {
        return [
            [['name','email'],'required'],
            ['email','email']
        ];
    }

}
