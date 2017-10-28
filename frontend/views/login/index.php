<main id="authentication" class="inner-bottom-md">
    <div class="container">
        <div class="row">

            <?= \yii\helpers\Html::beginForm(['login/login'],'post',['class'=>'register-form cf-style-1']);?>
            <div class="col-md-6">
                <section class="section sign-in inner-right-xs">
                    <h2 class="bordered">登陆</h2>
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

                            <?= \yii\helpers\Html::submitButton('安全登录',['class'=>'le-button huge']);?>
                        </div><!-- /.buttons-holder -->
                    </form><!-- /.cf-style-1 -->

                </section><!-- /.sign-in -->
            </div><!-- /.col -->

            <?= \yii\helpers\Html::endForm();?>

            <div class="col-md-6">
                <section class="section register inner-left-xs">
                    <h2 class="bordered">创建新账户</h2>
                    <p>Create your own Media Center account</p>


                        <?= \yii\helpers\Html::beginForm(['login/index'],'get',['class'=>'register-form cf-style-1']);?>

                        <div class="field-row">
                            <label>Email</label>
                            <?= \yii\helpers\Html::textInput('email','',['class'=>'le-input']);?>
                        </div><!-- /.field-row -->

                        <div class="buttons-holder">
                            <?= \yii\helpers\Html::submitButton('注册',['class'=>'le-button huge']);?>
                        </div><!-- /.buttons-holder -->
                        <?= \yii\helpers\Html::endForm();?>


                    <h2 class="semi-bold">Sign up today and you'll be able to :</h2>

                    <ul class="list-unstyled list-benefits">
                        <li><i class="fa fa-check primary-color"></i> Speed your way through the checkout</li>
                        <li><i class="fa fa-check primary-color"></i> Track your orders easily</li>
                        <li><i class="fa fa-check primary-color"></i> Keep a record of all your purchases</li>
                    </ul>

                </section><!-- /.register -->

            </div><!-- /.col -->

        </div><!-- /.row -->
    </div><!-- /.container -->
</main>
