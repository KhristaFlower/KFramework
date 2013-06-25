<?php
// This file is used to ensure that one template can extend another and overwrite
// content within it. It also tests to ensure a section can have one sub-section
// inside of it.
?>
<?php $this->extend('templates/main.php') ?>
<?php $this->begin('content') ?>
<p>
    <?php $this->begin('test_content') ?>
    
    This is the Secondary template.
    
    <?php $this->end() ?>
</p>
<a href="/testing/template/master/">Master Template</a> | 
<a href="/testing/template/secondary/">Secondary Template</a> | 
<a href="/testing/template/tertiary/">Tertiary Template</a>
<?php $this->end() ?>
