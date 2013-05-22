<!DOCTYPE html>
<html>
    <head>
        <title>KFramework</title>
        <meta charset="UTF-8">
        <base href="<?php echo SITE_BASE_URL; ?>"/>
        <?php
        // Automatically load CSS files set within the controller.
        if (!empty($this->css)) {
            // Automatically set the theme to the site default.
            $themePath = PATH_THEMES . SITE_DEFAULT_THEME;
            // Check if the user has changed their theme to a valid one
            if(isset($_COOKIE['KTheme'])){
                $userTheme = $_COOKIE['KTheme'];
                if(is_dir(PATH_THEMES . $userTheme)){
                    $themePath = PATH_THEMES . $userTheme;
                }
            }
            foreach ($this->css as $css) {
                ?>
                <link type="text/css" rel="stylesheet" href="<?php echo "$themePath/" . $css; ?>"/>
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