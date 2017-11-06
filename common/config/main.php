<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language'=>'zh-CN',
    'components' => [
        'elasticsearch' => [
            'class' => 'yii\elasticsearch\Connection',
            'nodes' => [
                ['http_address' => '127.0.0.1:9200']
            ],
            'autodetectCluster' => false
        ],

        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'itemTable' => 'yii_item',
            'assignmentTable' => 'yii_assignment',
            'itemChildTable' => 'yii_item_child',
        ],
    ],
//    'as access' => [
//        'class' => 'mdm\admin\components\AccessControl',
//        'allowActions' => [
//            'site/*',
//            'admin/*',
//            'some-controller/some-action',
//            //此处的action列表，允许任何人（包括游客）访问
//            //所以如果是正式环境（线上环境），不应该在这里配置任何东西，为空即可
//            //但是为了在开发环境更简单的使用，可以在此处配置你所需要的任何权限
//            //在开发完成之后，需要清空这里的配置，转而在系统里面通过RBAC配置权限
//        ]
//    ],

];
