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
                <link type="text/css" rel="stylesheet" href="<?php echo PATH_THEMES . SITE_DEFAULT_THEME . "/" . $css; ?>"/>
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
        </div>
        <?php
        // Check to see if a menu bar was set; if it wasn't we won't render any HTML for it.
        if (!empty($this->_navMenu)):
            ?>
            <div class="navigation_wrapper">
                <ul class="navigation">
                    <?php
                    // Loop through the categories.
                    foreach ($this->_navMenu->_categories as $category):
                        echo "<li><a href='{$category->_link}'>{$category->_name}</a>";
                        // Check to see if this category has any sub-objects.
                        if (count($category->_menuItems) > 0) {
                            // Create a sub-menu.
                            echo "<ul class='sub-navigation'>";
                            // Loop through the sub-menu items.
                            foreach ($category->_menuItems as $subMenu):
                                echo "<li><a href='{$subMenu->_link}'>{$subMenu->_name}</a></li>";
                            endforeach;
                            echo "</ul>";
                        }
                        echo "</li>";
                    endforeach;
                    ?>
                </ul>
            </div>
            <?php
        endif;
        ?>
        <div class="content">