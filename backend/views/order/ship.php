<?php
use yii\helpers\Html;

?>

<div class="content">

    <div class="container-fluid">
        <div id="pad-wrapper" class="new-user">
            <div class="row-fluid header">
                <h3>添加发货单号</h3>
            </div>

            <div class="row-fluid form-wrapper">
                <!-- left column -->
                <div class="span9 with-sidebar">
                    <div class="container">
                        <?= Html::beginForm(['order/ship'], 'post');?>
                        <form class="new_user_form inline-input" />
                        <div class="span12 field-box">
                            <label>快递公司:</label>
                            <?= Html::dropDownList('shipping_id',0,$shipList);?>

                        </div>
                        <div class="span12 field-box">
                            <label>发货单:</label>
                            <?= Html::textInput('invoice_no','',['class'=>'span9']);?>
                        </div>
                        <div class="span12 field-box textarea">
                            <label>管理员备注:</label>
                            <?= Html::textarea('remark','',['class'=>'span9'])?>
                            <span class="charactersleft">剩余90个字符。字段限制在254个字符</span>
                        </div>
                        <div class="span11 field-box actions">
                            <?= Html::submitButton('确认发货',['class'=>'btn-glow primary'])?>
                            <span>OR</span>
                            <input type="reset" value="Cancel" class="reset" />
                        </div>
                        </form>
                    </div>
                </div>
                <?= Html::endForm();?>
                <!-- side right column -->
                <div class="span3 form-sidebar pull-right">
                    <div class="btn-group toggle-inputs hidden-tablet">
                        <button class="glow left active" data-input="inline">INLINE INPUTS</button>
                        <button class="glow right" data-input="normal">NORMAL INPUTS</button>
                    </div>
                    <div class="alert alert-info hidden-tablet">
                        <i class="icon-lightbulb pull-left"></i>
                        点击上面看到内联和正常输入表单上的区别
                    </div>
                    <h6>温馨提示：</h6>
                    <p>请正确填写发货单号，否则无法正确获取物流信息。</p>
                    <p>选择下列快速通道:</p>
                    <ul>
                        <li><a href="#">订单列表</a></li>
                        <li><a href="#">控制台</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end main container -->


<!-- scripts -->
<script src="js/jquery-latest.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/theme.js"></script>

<script type="text/javascript">
    $(function () {

        // toggle form between inline and normal inputs
        var $buttons = $(".toggle-inputs button");
        var $form = $("form.new_user_form");

        $buttons.click(function () {
            var mode = $(this).data("input");
            $buttons.removeClass("active");
            $(this).addClass("active");

            if (mode === "inline") {
                $form.addClass("inline-input");
            } else {
                $form.removeClass("inline-input");
            }
        });
    });
</script>

</body>
</html>