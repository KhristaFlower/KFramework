<?php $this->extend('setup/setup_template.php') ?>
<?php $this->begin('setup_head') ?>

<h1>Setup <small>Step 3</small></h1>

<?php $this->end() ?>
<?php $this->begin('setup_lead') ?>

At this stage we create your administrator account, this will be used
to log into the administration section of the website allowing you
to manage extensions from directly on the site.

<?php $this->end() ?>
<?php $this->begin('setup_content') ?>

<?php
$view = $this->data()->getContainer("View");
?>

<?php
if ($view->gv("accounts_exist") && !$view->gv("account_created")):
    ?>
    <div class="alert alert-info">
        <b>Administration accounts found.</b><br/>
        The following administration accounts have been found:<br/>
        <ul>
            <?php
            foreach ($view->gv("accounts_created") as $account) {
                echo "<li>$account</li>";
            }
            ?>
        </ul>
        You may proceed to the next step if you know the credentials
        for any of the above accounts.
    </div>
    <?php
endif;
?>

<?php
if ($view->gv("registration_failed")):
    ?>
    <div class="alert alert-error">
        <b>Registration errors were found.</b><br/>
        The following errors were found and must be fixed:
        <ul>
            <?php
            $regErrors = $view->gv("registration_errors");
            foreach ($regErrors as $field => $error):
                echo "<li>$field - $error</li>";
            endforeach;
            ?>
        </ul>
    </div>
    <?php
elseif ($view->gv("account_created")):
    ?>
    <div class="alert alert-success">
        <b>Registration was successful!</b><br/>
        You may now move onto the next step. Alternatively you can create
        additional administration accounts.
    </div>
    <?php
endif;
?>

<form method="post" action="setup/process/3/" class="form-horizontal">
    <div class="control-group">
        <label class="control-label" for="inputUsername">Username</label>
        <div class="controls">
            <input type="text" id="inputUsername" name="Username" autocomplete="off"
            <?php
            if (isset($_GET['Username']) && !$this->account_created) {
                echo " value='{$_GET['Username']}'";
            }
            ?>
                   />
            <span class="help-inline">2-30 Characters, alphanumeric upper and lower case, underscores, and hyphens.</span>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="inputEmail">Email</label>
        <div class="controls">
            <input type="text" id="inputEmail" name="Email" autocomplete="off"
            <?php
            if (isset($_GET['Email']) && !$this->account_created) {
                echo " value='{$_GET['Email']}'";
            }
            ?>
                   />
            <span class="help-inline">Used as an alternative way of logging in.</span>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="inputPassword">Password</label>
        <div class="controls">
            <input type="password" id="inputPassword" name="Password"/>
            <span class="help-inline">Must not be empty.</span>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="inputPasswordC">Password Confirmation</label>
        <div class="controls">
            <input type="password" id="inputPasswordC" name="Password_Confirmation"/>
            <span class="help-inline">Must match Password field.</span>
        </div>
    </div>

    <div class="control-group">
        <div class="controls">
            <button type="submit" class="btn btn-success">Create Account</button>
        </div>
    </div>
</form>

<hr/>

<?php $this->end() ?>
<?php $this->begin('previous_next') ?>

<a class="btn btn-large pull-left" href="/setup/step/2/">Previous</a>
<?php
if ($view->gv("account_created") || $view->gv("accounts_exist")):
    ?>
    <a class="btn btn-large btn-primary pull-right" href="setup/step/4/">Next</a>
    <?php
else:
    ?>
    <a class="btn btn-large pull-right disabled" href="setup/step/3/#" onclick="return false;">Next</a>
<?php
endif;
?>

<?php $this->end() ?>