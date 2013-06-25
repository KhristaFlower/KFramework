<?php $this->extend('templates/main.php') ?>
<?php $this->begin('title') ?>Login <?php $this->end() ?>
<?php $this->begin('page_css') ?>

<style type="text/css">
    /* Sign in styling */
    body{
        /*padding-top:80px;
        padding-bottom:40px;*/
        background-color:#f5f5f5;
    }
    .form-signin{
        max-width:300px;
        padding:19px 29px 29px;
        margin:0 auto 20px;
        background-color:#fff;
        border:1px solid #e5e5e5;
        -webkit-border-radius:5px;
        -mox-border-radius:5px;
        border-radius:5px;
        -webkit-box-shadow:0 1px 2px rgba(0,0,0,.05);
        -moz-box-shadow:0 1px 2px rgba(0,0,0,.05);
        box-shadow:0 1px 2px rgba(0,0,0,.05);
    }
    .form-signin .form-signin-heading,
    .form-signin .checkbox{
        margin-bottom:10px;
    }
    .form-signin input[type="text"],
    .form-signin input[type="password"]{
        font-size:16px;
        height:auto;
        margin-bottom:15px;
        padding:7px 9px;

    }
</style>

<?php $this->end() ?>
<?php $this->begin('content') ?>

<?php
$login_success = $this->data()->getContainer("View")->getVariable("login_success");
?>

<div class="container">
    <form action="/acp/login/process/" method="post" class="form-signin">
        <h2>KFramework Login</h2>

        <?php if (isset($login_success) && $login_success): ?>
            <div class="alert alert-success">
                <b>Success!</b>
            </div>
        <?php elseif (isset($login_success) && !$login_success): ?>
            <div class="alert alert-error">
                <b>The login is invalid.</b>
            </div>
        <?php endif; ?>

        <input type="text" name="UorE" class="input-block-level" placeholder="Username or Email"/>
        <input type="password" name="password" class="input-block-level" placeholder="Password"/>
        <button type="submit" class="btn btn-large btn-primary">Log in</button>
    </form>
</div>

<?php $this->end() ?>