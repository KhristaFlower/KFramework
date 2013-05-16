<!DOCTYPE html>
<html>
    <head>
        <title>KFramework</title>
        <meta charset="UTF-8">
        <base href="<?php echo SITE_BASE_URL; ?>"/>
        <?php
        // Automatically load CSS files set within the controller.
        if (!empty($this->css)) {
            foreach ($this->css as $css) {
                ?>
                <link type="text/css" rel="stylesheet" href="<?php echo $css; ?>"/>
                <?php
            }
        }
        // Automatically load JS files set within the controller.
        if (!empty($this->js)) {
            foreach ($this->js as $js) {
                ?>
                <script type="text/javascript" src="<?php echo $js; ?>"></script>
                <?php
            }
        }
        ?>

    </head>
    <body>
        <div class="header">
            <div class="mainnav">

            </div>
        </div>
        <div class="content">