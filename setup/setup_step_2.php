<?php $this->extend('setup/setup_template.php') ?>
<?php $this->begin('setup_head') ?>

<h1>Setup <small>Step 2</small></h1>

<?php $this->end() ?>
<?php $this->begin('setup_lead') ?>

This step involves creating the tables that hold the data in the
database.

<?php $this->end() ?>
<?php $this->begin('setup_content') ?>

<?php
$cfg = $this->data()->getContainer("Config");
$tables = $this->data()->getContainer("Tables");
?>

<?php
$cfg_error = $cfg->getVariable("error");
// Display an error if the configuration failed to be loaded.
if ($cfg_error):
    ?>
    <div class="alert alert-error">
        <b>There was a problem loading the configuration.</b>
        The file may not exist or may contain malformed data.
        Please return to the <a href="setup/step/1/">previous step</a>
        and enter your database details again.
    </div>
    <?php
endif;
?>

<?php
// Display information about the tables that need to be installed.
if ($tables->gv("missingTables") && !$tables->gv("foundTables")):
    ?>
    <div class="alert alert-info">
        The KFramework needs to create a few tables in order to work properly;
        press the button below to start the creation of these tables.
    </div>
    <?php
endif;
?>

<?php
// Display some information about the fact all tables have been found.
if (!$tables->gv("missingTables") && $tables->gv("foundTables")):
    ?>
    <div class="alert alert-info">
        <b>The tables we are looking to create have been found.</b><br/>
        Have you already completed this part of the setup? If you have then
        you can continue to the next step.<br/>
        If you would like to delete and recreate all tables, you can click
        the Recreate Tables button below to do this.
    </div>
    <?php
endif;
?>

<?php
// Display some information about some tables existing and others not.
if ($tables->gv("missingTables") && $tables->gv("foundTables")):
    ?>
    <div class="alert alert-warning">
        <b>Some of the tables we need to create have been found, however, not all of them.</b><br/>
        <div class="row-fluid">
            <p class="span6">
            <u>If you wish to create missing tables only</u><br/>
            By selecting Create Tables, the tables that are missing will
            be created. This will leave existing tables as they are, all
            data intact.
            </p>
            <p class="span6">
            <u>If you wish to replace current tables and create missing tables</u><br/>
            By selecting Recreate Tables, the tables that already exist
            (that are needed) will be deleted and recreated. Any data
            contained within them will be lost. Any missing tables will
            be created.
            </p>
        </div>
    </div>
    <?php
endif;
?>

<div class="row-fluid">
    <div class="span6">
        <?php
        if ($tables->gv("missingTables") && !$tables->gv("foundTables")) {
            // Tables do not exist at all, create from scratch.
            $renderActive = true;
            $renderRecreate = false;
        } elseif (!$tables->gv("missingTables") && $tables->gv("foundTables")) {
            // All tables exist, offer to recreate.
            $renderActive = false;
            $renderRecreate = true;
        } elseif ($tables->gv("missingTables") && $tables->gv("foundTables")) {
            // Some tables exist, others do not, offer both options.
            $renderActive = true;
            $renderRecreate = true;
        }
        ?>

        <?php if ($renderActive == true): ?>
            <a href="/setup/process/2/create/" class="btn btn-large btn-success input-block-level">Create Tables</a>
        <?php elseif ($renderActive == false): ?>
            <a href="#" class="btn btn-large btn-success input-block-level disabled" onclick="return false;">Create Tables</a>
        <?php endif; ?>
        <hr/>
        <?php if ($renderRecreate == true): ?>
            <a href="#replaceTables" role="button" class="btn btn-large input-block-level btn-danger" data-toggle="modal">Recreate Tables</a>

            <div id="replaceTables" class="modal hide fade" tabindex="-1" role="dialog"
                 aria-labelledby="replaceTablesLabel" aria-hidden="true">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 id="replaceTablesLabel">Replace Tables</h3>
                </div>
                <div class="modal-body">
                    Are you sure you wish to replace the tables?<br/>
                    <?php
                    $tableList = $tables->gv("tableList");
                    if ((isset($tableList) && $tableList != null)) {
                        $list = "<ul>";
                        foreach ($tableList as $tableName => $tableExists) {
                            if ($tableExists) {
                                $list .= "<li>$tableName</li>";
                            }
                        }
                        $list .= "</ul>";
                        echo "$list";
                    }
                    ?>
                    <b>All data contained within these tables will be lost permanently!</b>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">
                        Cancel
                    </button>
                    <a href="/setup/process/2/recreate/" class="btn btn-danger">
                        Delete and Recreate Tables
                    </a>
                </div>
            </div>
        <?php elseif ($renderRecreate == false): ?>
            <a href="#" class="btn btn-large btn-danger input-block-level disabled" onclick="return false;">Recreate Tables</a>
        <?php endif; ?>

    </div>
    <div class="span6">
        Here you can select to create the tables used by the database for the
        base of the KFramework. Extensions themselves will create their own tables
        when they are installed. If tables are detected already you will be
        presented with an option to recreate them.
        <br/><br/>
        Once the tables have been created, you will be able to move to step 3.
    </div>
</div>

<hr/>

<?php $this->end() ?>
<?php $this->begin('previous_next') ?>

<a class="btn btn-large pull-left" href="/setup/step/1/">Previous</a>
<?php
if (!$tables->gv("missingTables") && $tables->gv("foundTables")):
    ?>
    <a class="btn btn-large btn-primary pull-right" href="setup/step/3/">Next</a>
    <?php
else:
    ?>
    <a class="btn btn-large pull-right disabled" href="setup/step/2/#" onclick="return false;">Next</a>
<?php endif; ?>

<?php $this->end() ?>
