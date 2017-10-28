<?php
/**
 * Created by PhpStorm.
 * User: CrazyT
 * Date: 2017/9/12
 * Time: 17:22
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<!-- this page specific styles -->
<link rel="stylesheet" href="/static/css/compiled/personal-info.css" type="text/css" media="screen" />

<!-- main container .wide-content is used for this layout without sidebar :)  -->
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
<div class="content wide-content">
    <div class="container-fluid">
        <div class="settings-wrapper" id="pad-wrapper">
            <!-- avatar column -->
            <div class="span3 avatar-box">
                <div class="personal-image">
                    <p>上传您的头像...</p>
                    <?php if (isset($admin->avatar) && !empty($admin->avatar)): ?>
                        <img src="<?= $admin->avatar;?>" class="avatar img-circle" />
                    <?php else: ?>
                        <img src="/static/img/personal-info.png" class="avatar img-circle" />
                    <?php endif;?>

                    <?= $form->field($model, 'imageFile')->fileInput()->label('') ?>
                </div>
            </div>

            <!-- edit form column -->
            <div class="span7 personal-info">
                <div class="alert alert-info">
                    <i class="icon-lightbulb"></i>您可以在这里编辑您的个人信息
                </div>
                <h5 class="personal-title">个人信息</h5>

                <div class="field-box">
                    <?= $form->field($admin,'username')->input('text',['class'=>'span5 inline-input'])->label('用户名')?>
                </div>
                <div class="field-box">
                    <?= $form->field($admin,'email')->input('text',['class'=>'span5 inline-input'])->label('电子邮箱')?>
                </div>
                <div class="field-box">
                    <?= $form->field($admin,'password_hash')->passwordInput(['class'=>'span5 inline-input','value'=>''])->label('密码')?>
                </div>
                <!--
                <div class="field-box">
                    <?= $form->field($admin,'repassword')->passwordInput(['class'=>'span5 inline-input','value'=>''])->label('确认密码')?>
                </div>
                -->
                <div class="span6 field-box actions">
                    <?= Html::submitButton('保存修改',['class'=>'btn-glow primary'])?>
                    <span>OR</span>
                    <?= Html::resetInput('取消',['class'=>'reset'])?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end() ?>
<!-- end main container -->
