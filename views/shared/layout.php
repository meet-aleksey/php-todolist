<?php
use PhpMvc\Html;
use PhpMvc\View;
?>
<html>
    <head>
        <title><?=Html::getTitle('TODO')?></title>
        <script src="/vendor/components/jquery/jquery.min.js" type="text/javascript"></script>
        <script src="/vendor/twbs/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="/vendor/twitter/typeahead.js/dist/bloodhound.min.js" type="text/javascript"></script>
        <script src="/vendor/twitter/typeahead.js/dist/typeahead.jquery.min.js" type="text/javascript"></script>
        <script src="/vendor/sliptree/bootstrap-tokenfield/dist/bootstrap-tokenfield.min.js" type="text/javascript"></script>
        <script src="/vendor/blueimp/jQuery-File-Upload/js/vendor/jquery.ui.widget.js" type="text/javascript"></script>
        <script src="/vendor/blueimp/jQuery-File-Upload/js/jquery.iframe-transport.js" type="text/javascript"></script>
        <script src="/vendor/blueimp/jQuery-File-Upload/js/jquery.fileupload.js" type="text/javascript"></script>
    </head>
    <body>
        <?php Html::render('header'); ?>

        <div class="container">
            <?php
                $errors = View::getModelState()->getErrors();
                if (isset($errors) && !empty($errors['.'])) {
                    Html::render('alert', array('type' => 'danger', 'text' => $errors['.'][0]->getMessage()));
                }
            ?>
            <?php Html::renderBody(); ?>
        </div>

        <?php Html::render('footer'); ?>
        <?php Html::render('scripts'); ?>
    </body>
</html>