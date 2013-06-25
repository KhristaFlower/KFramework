<?php $this->extend('templates/main.php') ?>
<?php $this->begin('page_css') ?>
<style>
    /* Jumbotron */
    .container > hr{
        margin:60px 0;
    }
    .jumbotron{
        margin:-20px 0 80px 0;
        text-align:center;

        background: #11727c;
        background: -moz-linear-gradient(left, #11727c 0%, #43acb2 100%);
        background: -webkit-gradient(linear, left top, right top, color-stop(0%,#11727c), color-stop(100%,#43acb2));
        background: -webkit-linear-gradient(left, #11727c 0%,#43acb2 100%);
        background: -o-linear-gradient(left, #11727c 0%,#43acb2 100%);
        background: -ms-linear-gradient(left, #11727c 0%,#43acb2 100%);
        background: linear-gradient(to right, #11727c 0%,#43acb2 100%);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#11727c', endColorstr='#43acb2',GradientType=1 );
    }


    .jumbotron h1{
        font-size:100px;
        line-height:1;
    }
    .jumbotron p{
        font-size:40px;
        font-weight:200;
        line-height:1.25;
    }

    .masthead{
        padding:70px 0 80px;
        margin-bottom:0;
        color:#FFF;
    }
    
    .jumbo-divider{
        padding:15px;
        text-align:center;
        background-color:#f5f5f5;
        border-top:1px solid #fff;
        border-bottom:1px solid #ddd;
    }
    .jumbo-divider p{
        margin-bottom:0;
    }
    
    /* Marketing */
    .marketing{
        text-align:center;
        color:#5a5a5a;
    }
    .marketing h1{
        margin:60px 0 10px;
        font-size:60px;
        font-weight:200;
        line-height:1;
        letter-spacing:-1px;
    }
    .marketing h2{
        font-weight:200;
        letter-spacing:-1px;
    }
    .marketing-byline{
        margin-bottom:40px;
        font-size:20px;
        font-weight:300;
        line-height:1.25;
        color:#999;
    }
    hr.soften{
        margin:70px 0;
    }


    /* Large desktop */
    @media (min-width: 1200px) {

    }

    /* Portrait tablet to landscape and desktop */
    @media (min-width: 768px) and (max-width: 979px) {

    }

    /* Landscape phone to portrait tablet */
    @media (max-width: 767px) {
        .jumbotron{
            padding:40px 20px;
            margin-top:-20px;
            margin-right:-20px;
            margin-left:-20px;
        }
        .jumbo-divider{
            margin:0 -20px;
        }
        .masthead h1{
            font-size:70px;
        }
        .masthead p{
            font-size:24px;
        }
        
        
        .jumbo-divider{
            padding:5px;
        }
        .jumbo-divider p{
            font-size:14px;
        }
        
    }

    /* Landscape phones and down */
    @media (max-width: 480px) {
        .masthead h1{
            font-size:45px;
        }
        .masthead p{
            font-size:18px;
        }
        
        .marketing h1{
            font-size:30px;
        }
        .marketing .marketing-byline{
            font-size:20px;
        }
        
    }
</style>
<?php $this->end() ?>
<?php $this->begin('content') ?>
<div class="jumbotron masthead">
    <div class="container">
        <h1>KFramework</h1>
        <p class="lead">
            A framework designed around site extensions that can provide
            all manners of functionality in the easiest way possible.
        </p>
    </div>
</div>

<div class="jumbo-divider">
    <div class="container">
        <p class="lead">
            Look under the hood over at <a href="https://github.com/Kriptonic/KFramework" target="_blank">GitHub</a>
        </p>
    </div>
</div>

<div class="container">
    <div class="marketing">

        <h1>Why use the KFramework?</h1>
        <p class="marketing-byline">Here's a few reasons:</p>

        <div class="row-fluid">
            <div class="span4">
                <h2>Customization</h2>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </p>
            </div>
            <div class="span4">
                <h2>Ease of use</h2>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </p>
            </div>
            <div class="span4">
                <h2>Fast setup</h2>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </p>
            </div>
        </div>

        <hr class="soften"/>

        <h1>Major Technologies Used</h1>
        <p class="marketing-byline">
            The following tools have worked wonders to enhance the
            development process.
        </p>

        <div class="row-fluid">
            <div class="span6">
                <h2>PHP</h2>
                <p>
                    The KFramework is built on top of PHP, a popular
                    general-purpose server-side scripting language that is widely
                    supported. Find out more on <a href="http://php.net">their website</a>.
                </p>
            </div>
            <div class="span6">
                <h2>Bootstrap</h2>
                <p>
                    Bootstrap is used to provide a strong and robust
                    front-end CSS framework enabling rapid and beautiful
                    development. You can find out more over at
                    <a href="http://twitter.github.io/bootstrap/">their website</a>.
                </p>
            </div>
        </div>

    </div>
</div>
<?php $this->end() ?>