<?php

$alerts = yii::$app->session->getFlash('alerts');
$url = isset($alerts['url']) ? $alerts['url'] : null;
$skip = $alerts['skip'];
?>

<?php if(isset($alerts) && ($alerts['state'] == 0)){ ?>
    <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Warning!&nbsp;&nbsp;</strong> <?= $alerts['msg'];?> &nbsp;&nbsp; <span id="wait"><?= $alerts['wait'];?></span>s 后自动跳转.
    </div>

<?php }elseif(isset($alerts) && ($alerts['state'] == 1)){ ?>

    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong>Success!&nbsp;&nbsp;</strong> <?= $alerts['msg'];?>&nbsp;&nbsp; <span id="wait"><?= $alerts['wait'];?></span>s 后自动跳转.
    </div>

<?php } ?>

<?php if(isset($url) && $skip){ ?>
    <script>
        setInterval(function(){
            var wait = document.getElementById('wait').innerHTML;
            wait -= 1;
            document.getElementById('wait').innerHTML = wait;
            if(wait == 0)
            {
                <?php if(empty($url)){ ?>
                window.history.go(-1);
                <?php }else{ ?>
                window.location.href = '<?= $url ?>';
                <?php } ?>
            }
        },1000)
    </script>
<?php } ?>