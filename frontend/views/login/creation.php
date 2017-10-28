<?php
/**
 * Created by PhpStorm.
 * User: 张志国
 * Date: 2017/10/14 0014
 * Time: 11:36
 */
?>
<!--进行提示-->
<?= $this->render('/common/message')?>

<main id="authentication" class="inner-bottom-md">
    <div class="container">
        <div class="row">
            <?= \yii\helpers\Html::beginForm(['login/url'],'post',['class'=>'register-form cf-style-1']);?>
            <div class="col-md-6">
                <section class="section sign-in inner-right-xs">
                    <h2 class="bordered">注册</h2>
                    <p>Hello, Welcome to your account</p>

                    <div class="social-auth-buttons">
                        <div class="row">
                            <div class="col-md-6">
                                <button class="btn-block btn-lg btn btn-facebook"><i class="fa fa-facebook"></i> Sign In with Facebook</button>
                            </div>
                            <div class="col-md-6">
                                <button class="btn-block btn-lg btn btn-twitter"><i class="fa fa-twitter"></i> Sign In with Twitter</button>
                            </div>
                        </div>
                    </div>

                    <form role="form" class="login-form cf-style-1">
                        <div class="field-center">
                            <label>用户名：</label>
                            <?= \yii\helpers\Html::textInput('user_name','',['class'=>'le-input']);?>
                            <?= \yii\helpers\Html::HiddenInput('email',"$email")?>
                        </div><!-- /.field-row -->

                        <div class="field-row">
                            <label>Password</label>
                            <?= \yii\helpers\Html::textInput('password','',['class'=>'le-input']);?>
                        </div><!-- /.field-row -->

                        <div class="field-row clearfix">
                        	<span class="pull-left">
                        		<label class="content-color"><input class="le-checbox auto-width inline" type="checkbox"> <span class="bold">Remember me</span></label>
                        	</span>
                            <span class="pull-right">
                        		<a href="#" class="content-color bold">Forgotten Password ?</a>
                        	</span>
                        </div>

                        <div class="buttons-holder">

                            <?= \yii\helpers\Html::submitButton('注册',['class'=>'le-button huge']);?>
                        </div><!-- /.buttons-holder -->
                    </form><!-- /.cf-style-1 -->

                </section><!-- /.sign-in -->
            </div><!-- /.col -->

            <?= \yii\helpers\Html::endForm();?>

        </div><!-- /.row -->
    </div><!-- /.container -->
</main>

