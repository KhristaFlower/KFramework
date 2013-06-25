<?php $this->extend('templates/main.php') ?>
<?php $this->begin('page_css') ?>
<style type="text/css">
    body{
        background-color:#f5f5f5;
    }
    .message{
        max-width:300px;
        padding:19px 29px 29px;
        margin:0 auto 20px;
        margin-top:20px;
        background-color:#fff;
        border:1px solid #e5e5e5;
        -webkit-border-radius:5px;
        -mox-border-radius:5px;
        border-radius:5px;
        -webkit-box-shadow:0 1px 2px rgba(0,0,0,.05);
        -moz-box-shadow:0 1px 2px rgba(0,0,0,.05);
        box-shadow:0 1px 2px rgba(0,0,0,.05);
    }
</style>
<?php $this->end() ?>
<?php $this->begin('content') ?>
<div class="container">
    <div class="message">
        <h2>Logged Out</h2>
        You have logged out successfully.<br/><br/>
        Return <a href="/">Home</a>.
    </div>
</div>
<?php $this->end() ?>
