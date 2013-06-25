<?php $this->extend('setup/setup_template.php') ?>
<?php $this->begin('setup_head') ?>

<h1>Setup <small>Complete</small></h1>

<?php $this->end() ?>
<?php $this->begin('setup_lead') ?>

You have now completed the setup, before you leave this page there is
some important information you need to consider below.

<?php $this->end() ?>
<?php $this->begin('setup_content') ?>

<p>
    The final crucial part of this step is to delete or rename the
    <code>setup</code> folder in your framework installation. We recommend
    that you delete the folder as a renamed folder can still be accessed
    by others.
</p>

<p>
    You can access the administration area of the site by visiting the
    <a href="/acp/">/acp/</a>.
</p>

<hr/>

<a class="btn btn-large pull-left" ahref="setup/step/4/">Previous</a>

<a href="#confimFinished" role="button" data-toggle="modal" class="btn btn-large btn-primary pull-right">Finish</a>

<div id="confimFinished" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="confirmFinishedLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <h3 id="confirmFinishedLabel">One moment!</h3>
    </div>
    <div class="modal-body">
        <p>
            Please remove the setup folder from you framework installation!<br/>
            If you do not remove it, there is a chance someone may use it
            to gain unauthorized access to your site.
        </p>
    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <a href="/" class="btn btn-primary">I Understand</a>
    </div>
</div>

<?php $this->end() ?>
