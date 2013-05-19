<h1>Settings</h1>

<h3>View your settings.</h3>

<p>
    This is your settings page; you will be able to customize things here.
</p>

<p>
    Here you can change the theme you use on the KFramework.<br/>
    Since this feature has been built to better enable testing; any theme you switch to will be reverted after two hours.<br/>
    <?php
    // Select the themes directory.
    $directory = PATH_THEMES;
    // Get all files in that folder.
    $files = glob($directory . "*");
    foreach($files as $file){
        // Check to see if it is a folder.
        if(is_dir($file)){
            // Create a new link to set the active theme.
            $pathinfo = pathinfo($file);
            $file = $pathinfo['filename'];
            echo "<a href='/ucp/settings/switchtheme/$file/'>$file</a><br/>";
        }
    }
    echo "<br/>";
    ?>
</p>