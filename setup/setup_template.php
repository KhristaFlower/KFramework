<?php $this->extend('templates/main.php') ?>
<?php $this->begin('title') ?>Setup<?php $this->end() ?>
<?php $this->begin('page_css') ?>
<style>
    body{
        padding-top:0;
    }
</style>
<?php $this->end() ?>
<?php $this->begin('content') ?>
<div class="container">
    <div class="page-header">
        <?php $this->begin('setup_head') ?>
        <?php $this->end() ?>
    </div>
    <p class="lead">
        <?php $this->begin('setup_lead') ?>
        <?php $this->end() ?>
    </p>
    
    <hr/>
    
    <?php $this->begin('setup_content') ?>
    <?php $this->end() ?>

    <?php $this->begin('previous_next') ?>
    <?php $this->end() ?>

</div>
<?php $this->end() ?>