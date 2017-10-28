<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,

    'qiniu' =>[
        'accessKey' =>'jmP335GJFyI9370rAWX1ew8d9Ynh6L6w9CaLdglX',
        'secretKey' =>'sg10CS4wyqH2wmjzsS31zI3NJUBDnZ3qqFVmdt2Y',
        'bucket'    =>'qiniu',
        'basePath'  =>'/uploads/',
        'domain'    =>'http://owip91vsf.bkt.clouddn.com/',
        'imageView' =>[
            'recommend'      =>'imageView2/1/w/246/h/186/q/75|imageslim',
            'mini'           =>'imageView2/1/w/67/h/60/q/75|imageslim',
            'thumb'         =>'imageView2/2/w/192/h/143/q/75|imageslim',
            'middle'        =>'imageView2/1/w/433/h/325/q/75|imageslim',
            'catbest'       =>'imageView2/1/w/73/h/73/q/75|imageslim',
        ]
    ],
    'alipay'=>[
        'partner'=>'2088121321528708',              //合作身份者id，以2088开头的16位纯数字
        'seller_email'=> 'itbing@sina.cn',        //收款支付宝账号
        'key'=>'1cvr0ix35iyy7qbkgs3gwymeiqlgromm',//安全检验码，以数字和字母组成的32位字符
        'sign_type'=>'MD5',                       //签名方式 不需修改
        'input_charset'=>'utf-8',                 //字符编码格式 目前支持 gbk 或 utf-8
        'cacert'=>getcwd().'\\cacert.pem',        //请保证cacert.pem文件在当前文件夹目录中
        'transport'=>'http',                      //访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
    ],

];
