<?php
/**
 * Created by PhpStorm.
 * User: CrazyT
 * Date: 2017/9/8
 * Time: 17:24
 */

?>
<!DOCTYPE html>
<html class="login-bg">
<head>
    <title>必应商城 - 后台管理</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- bootstrap -->
    <link href="/static/css/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="/static/css/bootstrap/bootstrap-responsive.css" rel="stylesheet" />
    <link href="/static/css/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet" />

    <!-- global styles -->
    <link rel="stylesheet" type="text/css" href="/static/css/layout.css" />
    <link rel="stylesheet" type="text/css" href="/static/css/elements.css" />
    <link rel="stylesheet" type="text/css" href="/static/css/icons.css" />

    <!-- libraries -->
    <link rel="stylesheet" type="text/css" href="/static/css/lib/font-awesome.css" />

    <!-- this page specific styles -->
    <link rel="stylesheet" href="/static/css/compiled/signin.css" type="text/css" media="screen" />

    <!-- open sans font -->
<!--    <link href='http://fonts.useso.com/css?family=Open+Sans:300italic,400italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css' />-->

    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
<body>

<?= $content; ?>

<!-- scripts -->
<script src="/static/js/jquery-latest.js"></script>
<script src="/static/js/bootstrap.min.js"></script>
<script src="/static/js/theme.js"></script>

<!-- pre load bg imgs -->
<script type="text/javascript">
    $(function () {
        // bg switcher
        var $btns = $(".bg-switch .bg");
        $btns.click(function (e) {
            e.preventDefault();
            $btns.removeClass("active");
            $(this).addClass("active");
            var bg = $(this).data("img");

            $("html").css("background-image", "url('img/bgs/" + bg + "')");
        });

    });
</script>

</body>
</html>
