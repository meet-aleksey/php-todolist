<?php 
use PhpMvc\View;
use PhpMvc\Html;

$title = 'Internal Server Error';
$description = '<p>An unexpected error occurred.</p>';
$url = '';

switch (View::getData('code')) {
    case 404:
        $title = 'Page not found';
        $description = '<p>The requested page was not found.</p>';
        break;
}

if (!empty(View::getData('message'))) {
    $description = '<p>' . str_replace(chr(10), '<br />', View::getData('message')) . '</p>';
}

if (!empty(View::getData('url'))) {
    $url = '<p>Try to <a href="' . View::getData('url') . '">retry the request</a>. If the error persists, put up with it.</p>';
}
?>
<html>
    <head>
        <title><?=$title?></title>
    </head>
    <body class="error">
        <?php Html::render('header'); ?>
        <section class="jumbotron">
            <div class="container">
                <h1><?=$title?></h1>
                <?=$description?>
                <?=$url?>
                <p><?=Html::actionLink('Go home', 'index', 'home', null, array('class' => 'btn btn-success btn-lg'))?></p>
            </div>
        </section>

        <section>
            <div class="container">
                <div class="row">
                    <h2 class="text-center">We are very ashamed that this happened</h2>
                </div>
            </div>
        </section>

        <div id="parallax1" class="parallax-parent" style="background-image:url(/content/images/not-hear.jpg);background-size:cover;background-position:center center;background-repeat:no-repeat;"></div>

        <section>
            <div class="container">
                <div class="row">
                    <h2 class="text-center">We will do our best to prevent this from happening again</h2>
                </div>
            </div>
        </section>

        <div id="parallax2" class="parallax-parent">
            <div style="background-image:url(/content/images/mechanical-engineering.jpg);background-size:cover;background-position:center center;background-repeat:no-repeat;"></div>
        </div>

        <section>
            <div class="container">
                <div class="row">
                    <h2 class="text-center">May be...</h2>
                </div>
            </div>
        </section>

        <div id="parallax3" class="parallax-parent">
            <div style="background-image:url(/content/images/dog.jpg);background-size:cover;background-position:center center;background-repeat:no-repeat;"></div>
        </div>

        <section>
            <div class="container">
                <div class="row">
                    <h2 class="text-center">Tomorrow :P</h2>
                </div>
            </div>
        </section>

        <div id="parallax4" class="parallax-parent">
            <div style="background-image:url(/content/images/milky-way.jpg);background-size:cover;background-position:center center;background-repeat:no-repeat;"></div>
        </div>

        <div class="text-center" style="padding-top: 32px; padding-bottom: 32px;">
            <div class="container">
                <p><?=Html::actionLink('Go home!', 'index', 'home', null, array('class' => 'btn btn-success btn-lg', 'style' => 'font-size: 32px'))?></p>
            </div>
        </div>

        <?php Html::render('footer'); ?>

        <?php Html::render('scripts', array(
            '/vendor/greensock/GreenSock-JS/src/minified/TweenMax.min.js',
            '/vendor/janpaepke/ScrollMagic/scrollmagic/minified/ScrollMagic.min.js',
            '/vendor/janpaepke/ScrollMagic/scrollmagic/minified/plugins/animation.gsap.min.js',
        )); ?>
        <script type="text/javascript">
            var controller = new ScrollMagic.Controller({globalSceneOptions: {triggerHook: "onEnter", duration: "200%"}});

            new ScrollMagic.Scene({triggerElement: "#parallax1"}).setTween("#parallax1 > div", {y: "80%", ease: Linear.easeNone}).addTo(controller);
            new ScrollMagic.Scene({triggerElement: "#parallax2"}).setTween("#parallax2 > div", {y: "80%", ease: Linear.easeNone}).addTo(controller);
            new ScrollMagic.Scene({triggerElement: "#parallax3"}).setTween("#parallax3 > div", {y: "80%", ease: Linear.easeNone}).addTo(controller);
            new ScrollMagic.Scene({triggerElement: "#parallax4"}).setTween("#parallax4 > div", {y: "80%", ease: Linear.easeNone}).addTo(controller);
        </script>
    </body>
</html>