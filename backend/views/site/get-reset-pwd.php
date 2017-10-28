<div class="row-fluid login-wrapper">
    <a class="brand" href="index.html"></a>
    <?php $form = \yii\widgets\ActiveForm::begin(); ?>
    <div class="span4 box">
        <div class="content-wrap">
            <h6>必应商城 - 重置管理密码</h6>

            <?= $this->render('/common/message');?>

            <?= $form->field($admin,'password')->textInput(['class'=>'span12','placeholder'=>'新密码'])->label(''); ?>

            <?= $form->field($admin,'repassword')->textInput(['class'=>'span12','placeholder'=>'确认密码'])->label(''); ?>

            <a href="<?= \yii\helpers\Url::to(['site/login'])?>" class="forgot">去登录?</a>
            <?= \yii\bootstrap\Html::submitButton('确认修改',['class'=>'btn-glow primary login'])?>
        </div>
    </div>
    <?php \yii\widgets\ActiveForm::end(); ?>
</div>