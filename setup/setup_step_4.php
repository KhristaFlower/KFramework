<?php $this->extend('setup/setup_template.php') ?>
<?php $this->begin('setup_head') ?>

<h1>Setup <small>Step 4</small></h1>

<?php $this->end() ?>
<?php $this->begin('setup_lead') ?>

The final part of the installation is to be sure you have your account
details correct. Just enter them into the form below to complete the
setup process.

<?php $this->end() ?>
<?php $this->begin('setup_content') ?>

<?php
$view = $this->data()->getContainer("View");
$login_success = $view->getVariable("login_success");
?>

<?php if (isset($login_success) && $login_success): ?>
    <div class="alert alert-success">
        <b>Account successfully verified.</b><br/>
        You can move onto the next step.
    </div>
<?php elseif (isset($login_success) && !$view->gv("login_success")): ?>
    <div class="alert alert-error">
        <b>Verification Failed.</b><br/>
        Please try again.
    </div>
<?php endif; ?>

<form method="post" action="setup/process/4/" class="form-horizontal">
    <div class="control-group">
        <label class="control-label" for="UorE">Username or Email</label>
        <div class="controls">
            <input type="text" id="UorE" name="UorE" autocomplete="off"/>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label" for="Password">Password</label>
        <div class="controls">
            <input type="password" id="Password" name="Password" autocomplete="off"/>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <button class="btn btn-success" type="submit">Verify Account</button>
        </div>
    </div>
</form>

<hr/>

<?php $this->end() ?>
<?php $this->begin('previous_next') ?>

<a class="btn btn-large pull-left" href="/setup/step/3/">Previous</a>

<?php
if (isset($login_success) && $login_success):
    ?>
    <a class="btn btn-large btn-primary pull-right" href="/setup/complete/">Next</a>
    <?php
else:
    ?>
    <a class="btn btn-large pull-right disabled" href="/setup/step/4/#" onclick="return false;">Next</a>
<?php
endif;
?>

<?php $this->end() ?>
