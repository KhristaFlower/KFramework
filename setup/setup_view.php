<?php $this->extend('setup/setup_template.php') ?>

<?php $this->begin('setup_head') ?>
<h1>KFramework <small>Setup</small></h1>
<?php $this->end() ?>

<?php $this->begin('setup_lead') ?>
Welcome to the KFramework setup! This guide will take you through the
process of setting up the framework so it can be used via the admin
control panel. You will not be able to gain access to the site until
this process is completed.
<?php $this->end() ?>

<?php $this->begin('previous_next') ?>
<a href="/setup/step/1/" class="btn btn-large btn-primary pull-right">Start Setup</a>
<?php $this->end() ?>