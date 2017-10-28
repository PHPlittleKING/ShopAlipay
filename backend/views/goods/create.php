<?php
/* @var $this yii\web\View */
use yii\widgets\ActiveForm;
?>
<!-- libraries -->
<link href="/static/css/lib/bootstrap-wysihtml5.css" type="text/css" rel="stylesheet" />
<link href="/static/css/lib/uniform.default.css" type="text/css" rel="stylesheet" />
<link href="/static/css/lib/select2.css" type="text/css" rel="stylesheet" />
<link href="/static/css/lib/bootstrap.datepicker.css" type="text/css" rel="stylesheet" />

<!-- this page specific styles -->
<link rel="stylesheet" href="/static/css/compiled/form-showcase.css" type="text/css" media="screen" />

<!-- main container -->
<div class="content">
    <div class="container-fluid">
        <div id="pad-wrapper" class="form-page">
            <?= $this->render('/common/message')?>
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
            <div class="row-fluid form-wrapper">
                <!-- left column -->
                <div class="span8 column">

                    <div class="field-box">
                        <?= $form->field($model, 'goods_name')->textInput(['class' => 'span8 inline-input','placeholder'=>'描述下商品'])->label('商品名称:');?>
                    </div>
                    <div class="field-box">
                        <?= $form->field($model, 'goods_brief')->textInput(['class' => 'span8 inline-input','placeholder'=>'推广词'])->label('推广热词:');?>
                    </div>
                    <div class="field-box">
                        <?= $form->field($model, 'shop_price')->textInput(['class' => 'span8 inline-input','placeholder'=>'本店售价'])->label('本店价:');?>
                    </div>
                    <div class="field-box">
                        <?= $form->field($model, 'promote_price')->textInput(['class' => 'span8 inline-input','placeholder'=>'促销价'])->label('促销价:');?>
                    </div>

                    <div class="field-box">
                        <?= $form->field($model, 'promote_start_date')->textInput(['class' => 'input-large datepicker'])->label('促销开始时间:');?>
                    </div>
                    <div class="field-box">
                        <?= $form->field($model, 'promote_end_date')->textInput(['class' => 'input-large datepicker'])->label('促销结束时间:');?>
                    </div>
                    <div class="field-box">
                        <?= $form->field($model, 'goods_number')->textInput(['class' => 'span8 inline-input','placeholder'=>'库存'])->label('商品库存:');?>
                    </div>
                    <div class="field-box">
                        <?= $form->field($model, 'goods_img')->fileInput(['class' => 'span8 inline-input','placeholder'=>'主图'])->label('商品主图:');?>
                    </div>
                    <div class="field-box">
                        <div class="wysi-column">
                            <?= $form->field($model, 'goods_desc')->textarea(['class' => 'span10 wysihtml5','rows'=>'5'])->label('详情描述:');?>
                        </div>
                    </div>
                </div>

                <!-- right column -->
                <div class="span4 column pull-right">
                    <div class="field-box">
                        <?= $form->field($model, 'cat_id')->dropDownList($catList, ['prompt' => '请选择分类...', 'style' => 'height:30px','class'=>'ui-select'])->label('选择分类:');?>
                    </div>
                    <div class="field-box">
                        <?= $form->field($model,'brand_id')->dropDownList($brandList,['prompt'=>'','class'=>'select2','style'=>'width:250px']);?>
                    </div>
                    <div class="field-box">
                        <label>加入推荐:</label>
                        <label class="checkbox">
                            <?= $form->field($model, 'is_hot')->checkbox();?>
                            <?= $form->field($model, 'is_new')->checkbox();?>
                            <?= $form->field($model, 'is_best')->checkbox();?>
                        </label>
                    </div>
                    <?= $form->field($model,'is_on_sale')->radioList([1=>'立即上架',0=>'稍后上架']);?>
                    <div class="span11 field-box actions">
                        <?= \yii\helpers\Html::submitButton('提交',['class'=>'btn-glow primary'])?>
                        <span>OR</span>
                        <?= \yii\helpers\Html::resetInput('重置',['class'=>'reset']);?>
                    </div>


                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
<!-- end main container -->

<!-- scripts for this page -->
<script src="/static/js/wysihtml5-0.3.0.js"></script>
<script src="/static/js/bootstrap-wysihtml5-0.0.2.js"></script>
<script src="/static/js/bootstrap.datepicker.js"></script>
<script src="/static/js/jquery.uniform.min.js"></script>
<script src="/static/js/select2.min.js"></script>

<!-- call this page plugins -->
<script type="text/javascript">
    $(function () {

        // add uniform plugin styles to html elements
        $("input:checkbox, input:radio").uniform();

        // select2 plugin for select elements
        $(".select2").select2({
            placeholder: "请选择品牌..."
        });

        // datepicker plugin
        $('.datepicker').datepicker().on('changeDate', function (ev) {
            $(this).datepicker('hide');
        });

        // wysihtml5 plugin on textarea
        $(".wysihtml5").wysihtml5({
            "font-styles": false
        });
    });
</script>
