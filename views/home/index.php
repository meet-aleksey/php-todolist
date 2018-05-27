<?php 
use PhpMvc\View;
use PhpMvc\Html;
$model = array(new \TodoList\Models\Task());
// View::setTitle('Test title');
View::injectModel($model);
?>
<html>
    <head>
        <title><?=Html::getTitle('TODO')?></title>
    </head>
    <body class="home">
        <?php Html::render('header', 'navbar-inverse'); ?>

        <section class="jumbotron">
            <div class="container">
                <h1>Hello, world!</h1>
                <p>A best task is the completed task!</p>
                <p><?=Html::actionLink('Get started', 'new', 'tasks', null, array('class' => 'btn btn-success btn-lg'))?></p>
            </div>
        </section>

        <section>
            <div class="container">
                <div class="row">
                    <h2 class="text-center">Achieving goals is impossible without tasks</h2>
                    <br />
                    <div class="col-sm-4 col-md-4">
                        <div class="thumbnail" style="border: none">
                            <img src="/content/images/planning.svg" class="thumbnail" alt="..." title="" style="border: none; width: 128px;" />
                            <div class="caption text-center">
                                <p>To work effectively requires planning.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-4">
                        <div class="thumbnail" style="border: none">
                            <img src="/content/images/list.svg" class="thumbnail" alt="..." title="" style="border: none; width: 128px;" />
                            <div class="caption text-center">
                                <p>Any plan consists of tasks.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-4">
                        <div class="thumbnail" style="border: none">
                            <img src="/content/images/solution.svg" class="thumbnail" alt="..." title="" style="border: none; width: 128px;" />
                            <div class="caption text-center">
                                <p>The fulfillment of tasks is all that people do every day.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div id="parallax1" class="parallax-parent" style="background-image:url(/content/images/checklist.jpg);background-size:cover;background-position:center center;background-repeat:no-repeat;"></div>

        <section>
            <div class="container">
                <div class="row">
                    <h2 class="text-center">Discipline helps to save time</h2>
                    <br />
                    <div class="col-sm-4 col-md-4">
                        <div class="thumbnail" style="border: none">
                            <img src="/content/images/whip.svg" class="thumbnail" alt="..." title="" style="border: none; width: 128px;" />
                            <div class="caption text-center">
                                <p>Discipline is a key element in achieving goals.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-4">
                        <div class="thumbnail" style="border: none">
                            <img src="/content/images/time.svg" class="thumbnail" alt="..." title="" style="border: none; width: 128px;" />
                            <div class="caption text-center">
                                <p>Efficient use of every second of working time.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-4">
                        <div class="thumbnail" style="border: none">
                            <img src="/content/images/goal.svg" class="thumbnail" alt="..." title="" style="border: none; width: 128px;" />
                            <div class="caption text-center">
                                <p>Discipline is the way to success!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div id="parallax2" class="parallax-parent">
            <div style="background-image:url(/content/images/time.jpg);background-size:cover;background-position:center center;background-repeat:no-repeat;"></div>
        </div>

        <section>
            <div class="container">
                <div class="row">
                    <h2 class="text-center">Each task has a solution</h2>
                    <div class="col-sm-4 col-md-4">
                        <div class="thumbnail" style="border: none">
                            <img src="/content/images/network.svg" class="thumbnail" alt="..." title="" style="border: none; width: 128px;" />
                            <div class="caption text-center">
                                <p>Shredding complex tasks simplifies the search for solutions.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-4">
                        <div class="thumbnail" style="border: none">
                            <img src="/content/images/artificial-intelligence.svg" class="thumbnail" alt="..." title="" style="border: none; width: 128px;" />
                            <div class="caption text-center">
                                <p>Even the most difficult task always has a solution.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-4">
                        <div class="thumbnail" style="border: none">
                            <img src="/content/images/superheroe.svg" class="thumbnail" alt="..." title="" style="border: none; width: 128px;" />
                            <div class="caption text-center">
                                <p>Never give up!<br />You will succeed!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div id="parallax3" class="parallax-parent">
            <div style="background-image:url(/content/images/never-give-up.jpg);background-size:cover;background-position:center center;background-repeat:no-repeat;"></div>
        </div>

        <section>
            <div class="container">
                <div class="row">
                    <h2 class="text-center">Start right now!</h2>
                    <div class="col-sm-4 col-md-4">
                        <div class="thumbnail" style="border: none">
                            <img src="/content/images/checked.svg" class="thumbnail" alt="..." title="" style="border: none; width: 128px;" />
                            <div class="caption text-center">
                                <p>It's simple!</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-4">
                        <div class="thumbnail" style="border: none">
                            <img src="/content/images/checked.svg" class="thumbnail" alt="..." title="" style="border: none; width: 128px;" />
                            <div class="caption text-center">
                                <p>It's fast!</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-4">
                        <div class="thumbnail" style="border: none">
                            <img src="/content/images/checked.svg" class="thumbnail" alt="..." title="" style="border: none; width: 128px;" />
                            <div class="caption text-center">
                                <p>It's free!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div id="parallax4" class="parallax-parent">
            <div style="background-image:url(/content/images/road.jpg);background-size:cover;background-position:center center;background-repeat:no-repeat;"></div>
        </div>

        <div class="text-center" style="padding-top: 32px; padding-bottom: 32px;">
            <div class="container">
                <p><?=Html::actionLink('Start solving tasks right now!', 'new', 'tasks', null, array('class' => 'btn btn-success btn-lg', 'style' => 'font-size: 32px'))?></p>
            </div>
        </div>

        <?php Html::render('footer'); ?>

        <?php Html::render('scripts', array(
            '/vendor/greensock/GreenSock-JS/src/minified/TweenMax.min.js',
            '/vendor/janpaepke/ScrollMagic/scrollmagic/minified/ScrollMagic.min.js',
            '/vendor/janpaepke/ScrollMagic/scrollmagic/minified/plugins/animation.gsap.min.js',
        )); ?>
        <script type="text/javascript">
        /*
            // init
            var controller = new ScrollMagic.Controller({
                globalSceneOptions: {
                    triggerHook: 'onLeave'
                }
            });

            // get all slides
            var slides = document.querySelectorAll("section");

            // create scene for every slide
            for (var i=0; i<slides.length; i++) {
                new ScrollMagic.Scene({
                        triggerElement: slides[i]
                    })
                    .setPin(slides[i])
                    .addTo(controller);
            }
            */
            // init controller
            var controller = new ScrollMagic.Controller({globalSceneOptions: {triggerHook: "onEnter", duration: "200%"}});
/*
            // get all slides
            var slides = document.querySelectorAll("section");

            // create scene for every slide
            for (var i=0; i<slides.length; i++) {
                new ScrollMagic.Scene({triggerElement: slides[i]})
                            .setTween(slides[i], {y: "80%", ease: Linear.easeNone})
                            .addTo(controller);
            }*/

            var tween = TweenMax.to(".rotate-me", 1, {rotation: 360, y: 100, ease: Linear.easeNone});

            new ScrollMagic.Scene({triggerElement: ".rotate-me"}).setTween(tween).addTo(controller);
            new ScrollMagic.Scene({triggerElement: "#parallax1"}).setTween("#parallax1 > div", {y: "80%", ease: Linear.easeNone}).addTo(controller);
            new ScrollMagic.Scene({triggerElement: "#parallax2"}).setTween("#parallax2 > div", {y: "80%", ease: Linear.easeNone}).addTo(controller);
            new ScrollMagic.Scene({triggerElement: "#parallax3"}).setTween("#parallax3 > div", {y: "50%", ease: Linear.easeNone}).addTo(controller);
            new ScrollMagic.Scene({triggerElement: "#parallax4"}).setTween("#parallax4 > div", {y: "20%", ease: Linear.easeNone}).addTo(controller);
        </script>
    </body>
</html>