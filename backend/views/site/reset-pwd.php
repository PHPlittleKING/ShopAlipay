<div class="row-fluid login-wrapper">
    <a class="brand" href="index.html"></a>
    <?php $form = \yii\widgets\ActiveForm::begin(); ?>
    <div class="span4 box">
        <div class="content-wrap">
            <h6>必应商城 - 找回管理密码</h6>

            <?= $this->render('/common/message');?>

            <?= $form->field($admin,'email')->textInput(['class'=>'span12','placeholder'=>'管理员Email'])->label(''); ?>
            <a href="<?= \yii\helpers\Url::to(['site/login'])?>" class="forgot">去登录?</a>
            <?= \yii\bootstrap\Html::submitButton('发送Email',['class'=>'btn-glow primary login'])?>
        </div>
    </div>
    <?php \yii\widgets\ActiveForm::end(); ?>
</div>