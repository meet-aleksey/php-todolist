<?php 
use PhpMvc\View;
$model = array();
View::injectModel($model);
?>
<script src="/content/scripts/app.js" type="text/javascript"></script>
<?php
    if (!empty($model)) {
        foreach ($model as $src) {
            echo '<script src="' . $src . '" type="text/javascript"></script>';
        }
    }
?>