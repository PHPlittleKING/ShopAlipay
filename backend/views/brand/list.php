<?php

use yii\helpers\Url;
?>
<!-- this page specific styles -->
    <link rel="stylesheet" href="/static/css/compiled/user-list.css" type="text/css" media="screen" />
<!-- main container -->
<div class="content">

    <div class="container-fluid">
        <div id="pad-wrapper" class="users-list">
            <div class="row-fluid header">
                <h3>品牌列表</h3>
                <div class="span10 pull-right">
                    <?= \yii\helpers\Html::beginForm(['brand/list'],'get') ?>
                    <input type="text" name="brand_name" value="<?= $brandName;?>" class="span5 search" placeholder="Search a brand name..." />
                    <div class="ui-dropdown">
                        <input type="submit" value="Search" class="btn">
                    </div>
                    <?= \yii\helpers\Html::endForm();?>
                    <a href="<?= Url::to(['brand/create']);?>" class="btn-flat success pull-right">
                        <span>&#43;</span>
                        添加新品牌
                    </a>
                </div>
            </div>

            <!-- Users table -->
            <div class="row-fluid table">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th class="span4 sortable">
                                品牌名/简短描述
                            </th>

                            <th class="span2 sortable">
                                <span class="line"></span>排序
                            </th>
                            <th class="span2 sortable">
                                <span class="line"></span>是否展示
                            </th>
                            <th class="span3 sortable align-right">
                                <span class="line"></span>操作
                            </th>
                        </tr>
                    </thead>
                    <tbody>

                    <!-- row -->
                    <?php foreach($brands as $brand): ?>
                    <tr class="first">
                        <td>
                            <img src="/static/img/contact-img.png" class="img-circle avatar thumbnail hidden-phone" />
                            <a href="<?= $brand->site_url;?>" class="name" target="_blank"><?= $brand->brand_name;?></a>
                            <span class="subtext"><?= $brand->brand_desc;?></span>
                        </td>
                        <td><?= $brand->sort;?></td>
                        <td>
                            <?= ($brand->is_show)?'<button type="button" class="btn btn-success">是</button>':'<button type="button" class="btn btn-danger">否</button>'; ?>
                        </td>
                        <td class="align-right">
                            <a href="<?= Url::to(['brand/update','id'=>$brand->brand_id])?>">修改</a> |
                            <a href="<?= Url::to(['brand/del','id'=>$brand->brand_id])?>">回收站</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <!-- row -->

                    </tbody>
                </table>
            </div>
            <div class="pagination pull-right">
                <?= \yii\widgets\LinkPager::widget(['pagination'=>$page])?>
            </div>
            <!-- end users table -->
        </div>
    </div>
</div>
<!-- end main container -->