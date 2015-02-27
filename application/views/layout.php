<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title?$title." - ":""; ?> PMWA</title>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/assets/css/common.css">
    <?php if ( isset($css) && ($total = count($css)) > 0 ): ?>
        <?php
            for($i=0;$i<$total;$i++) {
                echo sprintf("<link rel='stylesheet' href='%s'>",site_url($css[$i]));
            }
        ?>
    <?php endif; ?>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script src="/assets/libraries/blockui.js"></script>
    <script>
//        $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
        var publicKey = "<?php echo APIKEY ?>";

    </script>
    <?php if ( isset($js) && ($total = count($js)) > 0 ): ?>
        <?php
        for($i=0;$i<$total;$i++) {
            echo sprintf("<script src='%s'></script>",site_url($js[$i]));
        }
        ?>
    <?php endif; ?>
</head>
<body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">

            <div class="navbar-header">
                <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="/" class="navbar-brand"><?php echo PROJECT ?></a>
            </div>
            <?php if ( $this->session->userdata('isLogin') ): ?>
            <div class="navbar-collapse collapse" id="navbar">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="<?php echo site_url($this->router->class.'/logout') ?>">Logout</a></li>
                </ul>
            </div>
            <?php endif; ?>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12"><div role="alert" class="" id="global-msg"></div></div>

            <?php if ( isset($leftPanel) ): ?>
                <?php echo $leftPanel; ?>
            <?php endif; ?>
            <?php if ( isset($body) ): ?>
                <?php echo $body; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>