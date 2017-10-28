<?php
/**
 * Created by PhpStorm.
 * User: 张志国
 * Date: 2017/10/26 0026
 * Time: 11:04
 */
use \yii\widgets\ActiveForm;
?>


<!-- ========================================= CONTENT ========================================= -->

<section id="checkout-page">
    <div class="container">
        <div class="col-xs-12 no-margin">

            <div class="billing-address">
                <h2 class="border h1">收货人信息</h2>
                <?php $form = ActiveForm::begin(['options'=>['class'=>'login-form cf-style-1','role'=>'form']]); ?>
                <div class="row field-row">
                    <div class="col-xs-12 col-sm-6">
                        <?= $form->field($userAdd,'address_name')->textInput(['class'=>'le-input'])->label('收货地址别名')?>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <?= $form->field($userAdd,'consignee')->textInput(['class'=>'le-input'])->label('收货人姓名')?>
                    </div>
                </div><!-- /.field-row -->

                <div class="row field-row">
                    <div class="col-xs-12">
                        <?= $form->field($userAdd,'address')->textInput(['class'=>'le-input'])->label('收货人详细地址')?>
                    </div>
                </div><!-- /.field-row -->

                <div class="row field-row">
                    <div class="col-xs-12 col-sm-12">
                        <label for="">收货人地区</label>
                    </div>
                    <div class="col-xs-12 col-sm-2">
                        <?= $form->field($userAdd,'country')->dropDownList($region,['class'=>'le-input form-control region','prompt'=>'请选择...'])->label('');?>
                    </div>
                    <div class="col-xs-12 col-sm-2">
                        <?= $form->field($userAdd,'province')->dropDownList([],['class'=>'le-input form-control region','prompt'=>'请选择...'])->label('');?>
                    </div>
                    <div class="col-xs-12 col-sm-2">
                        <?= $form->field($userAdd,'city')->dropDownList([],['class'=>'le-input form-control region','prompt'=>'请选择...'])->label('');?>
                    </div>
                    <div class="col-xs-12 col-sm-2">
                        <?= $form->field($userAdd,'district')->dropDownList([],['class'=>'le-input form-control region','prompt'=>'请选择...'])->label('');?>
                    </div>
                    <div class>
                        <?= $form->field($userAdd,'province')->hiddenInput(['','class'=>'province' ])->label('') ?>
                        <?= $form->field($userAdd,'city')->hiddenInput(['','class'=>'city'])->label('') ?>
                        <?= $form->field($userAdd,'district')->hiddenInput(['','class'=>'district'])->label('') ?>
                    </div>

                </div><!-- /.field-row -->

                <div class="row field-row">
                    <div class="col-xs-12 col-sm-4">
                        <?= $form->field($userAdd,'zipcode')->textInput(['class'=>'le-input'])->label('收货人邮编')?>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <?= $form->field($userAdd,'email')->textInput(['class'=>'le-input'])->label('收货人email')?>
                    </div>

                    <div class="col-xs-12 col-sm-4">
                        <?= $form->field($userAdd,'mobile')->textInput(['class'=>'le-input'])->label('收件人手机号')?>
                    </div>
                </div><!-- /.field-row -->

                <div class="row field-row">
                    <div id="create-account" class="col-xs-12">
                        <input  class="le-checkbox big" type="checkbox"  />
                        <a class="simple-link bold" href="#">是否默认?</a>
                    </div>
                </div><!-- /.field-row -->

            </div><!-- /.billing-address -->

            <div class="place-order-button">
                <?= \yii\helpers\Html::submitButton('确认添加',['class'=>'le-button big'])?>

            </div><!-- /.place-order-button -->
            <?php ActiveForm::end(); ?>

        </div><!-- /.col -->
    </div><!-- /.container -->
</section><!-- /#checkout-page -->
