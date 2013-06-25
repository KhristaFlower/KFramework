<?php

// For some reason I cannot get the KFramework to automatically load the index
// page for the setup controller. I find this is just the easiest solution to
// implement without messing around with the main application too much.
header('Location: /setup/index/');
