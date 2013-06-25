<?php $this->extend('setup/setup_template.php') ?>
<?php $this->begin('setup_head') ?>

<h1>Setup <small>Step 1</small></h1>

<?php $this->end() ?>
<?php $this->begin('setup_lead') ?>

The KFramework requires a connection to a database in order to work.
This connection will be used to keep track of the administrator accounts
as well as extension information.

<?php $this->end() ?>
<?php $this->begin('setup_content') ?>

<?php
$cfg = $this->data()->getContainer("Config");
?>

<?php
if ($cfg->gv("valid")):
    ?>
    <div class="alert alert-info">
        <b>A valid configuration with database details was found.</b><br/>
        The details found can be seen in the form below, the password has not
        been included. You can continue with the setup if you are satisfied
        with the settings shown.<br/>
        If you would like to change the details then you can do so by entering
        the new details and clicking verify.
    </div>
    <?php
endif;
?>

<div class="row-fluid">
    <div class="span6">
        <?php
        $formErrorFree = ($this->data()->gc("Form")->gv("submit")) ?
                $this->data()->gc("Form")->gv("isErrorFree") : null;
        // Alert the user if there were errors with the form.
        if (isset($formErrorFree) && !$formErrorFree):
            ?>
            <div class="alert alert-error">
                <b>Error!</b> Please fill all fields.
            </div>
            <?php
        endif;
        ?>

        <?php
        $databaseConnected = $this->data()->gv("hasConnected");
        // Alert the user that the form submission and database connection was a success.
        if ($formErrorFree && !$databaseConnected):
            ?>
            <div class="alert alert-error">
                <b>Error!</b> A connection to the database could not be established.
            </div>
            <?php
        elseif ($formErrorFree && $databaseConnected):
            ?>
            <div class="alert alert-success">
                <b>Success!</b> A connection to the database was made.
            </div>
            <?php
        endif;
        ?>

        <?php
        $cfg_isWriteable = $cfg->gv("isWriteable");
        $cfg_opened = $cfg->gv("opened");
        $cfg_canWrite = $cfg->gv("canWrite");
        $cfg_written = $cfg->gv("written");
        $cfg_valid = $cfg->gv("valid");
        // Alert the user that the saving of the configuration settings failed somehow.
        if (isset($cfg_isWriteable) && !$cfg_isWriteable):
            ?>
            <div class="alert alert-error">
                <b>Error!</b> Failed to write database settings to file.
            </div>
            <?php
        endif;
        if (isset($cfg_opened) && !$cfg_opened):
            ?>
            <div class="alert alert-error">
                <b>Error!</b> Failed to open a file handle to the export file.
            </div>
            <?php
        endif;
        if (isset($cfg_canWrite) && !$cfg_canWrite):
            ?>
            <div class="alert alert-error">
                <b>Error!</b> Failed to write the data to the export file.
            </div>
            <?php
        endif;
        ?>

        <?php
        $db = $cfg->gv("database");
        $user = $cfg->gv("user");
        ?>
        <form action="/setup/process/1/" method="post">
            <input type="text" name="db_name" class="input-block-level" placeholder="Database Name"<?php
            if (isset($_POST['db_name'])) {
                echo " value='{$_POST['db_name']}'";
            } else if (isset($db)) {
                echo " value='{$db}'";
            }
            ?>/>
            <input type="text" name="user_name" class="input-block-level" placeholder="User Name"<?php
            if (isset($_POST['user_name'])) {
                echo " value='{$_POST['user_name']}'";
            } else if (isset($user)) {
                echo " value='{$user}'";
            }
            ?>/>
            <input type="password" name="user_pass" class="input-block-level" placeholder="User Password"<?php
            if (isset($_POST['user_pass'])) {
                echo " value='{$_POST['user_pass']}'";
            }
            ?>/>
            <button type="submit" class="btn btn-large btn-success">Verify</button>
        </form>
    </div>
    <div class="span6">
        Please enter your database name, user name, and user password.<br/><br/>
        To create these you will need to access your website control panel and
        create the database. Once you have done this you should enter the details
        here and click 'Verify', we will test if the connection can be made.
        <br/><br/>
        If a connection can be made successfully, the details entered will be saved
        allowing future use of the database.
        <br/><br/>
        If the details were saved successfully, you will be able to use the
        button below to advance to the next step.
    </div>
</div>

<hr/>

<?php $this->end() ?>
<?php $this->begin('previous_next') ?>

<a class="btn btn-large pull-left"href="/setup/index/">Previous</a>
<?php
if (($formErrorFree && $databaseConnected && $cfg_written) || $cfg_valid):
    ?>
    <a class="btn btn-large btn-primary pull-right" href="/setup/step/2/">Next</a>
    <?php
else:
    ?>
    <a class="btn btn-large pull-right disabled" href="setup/step/1/#" onclick="return false;">Next</a>
<?php
endif;
?>

<?php $this->end() ?>

