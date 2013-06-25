<!DOCTYPE html>
<html>
    <head>
        <title><?php $this->begin('title') ?>Home<?php $this->end() ?> | KFramework</title>
        <meta charset="UTF-8">
        <base href="<?php echo SITE_BASE_URL ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link type="image/x-icon" rel="icon" href="favicon.ico"/>
        <link type="text/css" rel="stylesheet" href="<?php echo PATH_THEMES . SITE_DEFAULT_THEME; ?>/bootstrap.min.css"/>
        <link type="text/css" rel="stylesheet" href="<?php echo PATH_CSS; ?>bootstrap-responsive.min.css"/>
        <link type="text/css" rel="stylesheet" href="<?php echo PATH_THEMES . SITE_DEFAULT_THEME; ?>/header-footer.css"/>

        <script type="text/javascript" src="http://code.jquery.com/jquery.js"></script>
        <script type="text/javascript" src="public/js/bootstrap.min.js"></script>
    </head>
    <body>
        <?php $this->begin('page_css') ?><?php $this->end() ?>
        <?php $this->begin('navigation') ?>
        <?php
        $view = $this->data()->getContainer("View");
        if ($view != null && $view->getVariable("MainNav") != null):
            ?>
            <div class="navbar navbar-inverse navbar-fixed-top">
                <div class="navbar-inner">
                    <div class="container">
                        <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="brand" href="/">KFramework</a>
                        <div class="nav-collapse collapse">
                            <!-- Navigation Rendering Begins -->
                            <?php
                            if ($view->getVariable("MainNav") != null) {
                                echo $view->getVariable("MainNav")->render();
                            }
                            ?>
                            <!-- Navigation Rendering Ends -->
                            <!-- Navigation Admin Rendering Begins -->
                            <?php
                            if ($view->getVariable("AdminNav") != null) {
                                echo $view->getVariable("AdminNav")->render("pull-right");
                            }
                            ?>
                            <!-- Navigation Admin Rendering Ends -->
                        </div>
                    </div>
                </div>
            </div>
            <?php
        endif;
        ?>
        <?php $this->end() ?>
        <?php $this->begin('content') ?>
        <!-- This here is test code used when changing the way templates work
        to ensure that code can be nested and extends the way it should do.
        This is replaced by any page that extends this template so it can stay. -->
        <p>
            This is the Master Template.
        </p>
        <a href="/testing/template/master/">Master Template</a> | 
        <a href="/testing/template/secondary/">Secondary Template</a> | 
        <a href="/testing/template/tertiary/">Tertiary Template</a>
        <?php $this->end() ?>
        <footer class="footer">
            <div class="container">
                <p class="muted credit">
                    Copyright &copy; <?php echo Date("Y"); ?> Christopher Sharman (csharman.co.uk)
                </p>
            </div>
        </footer>
    </body>
</html>
