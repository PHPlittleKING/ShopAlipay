<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/30 0030
 * Time: 8:31
 */
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<?php $form=ActiveForm::begin(); ?>
    <?= $form->field($model,'name')?>
    <?= $form->field($model,'email')?>
    <?=Html::submitButton('Submit',['class'=>'btn btn-primary'])?>
<?php ActiveForm::end();?>