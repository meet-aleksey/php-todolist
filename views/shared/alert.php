<?php 
$model = array();

PhpMvc\View::injectModel($model);

if (empty($model['type'])) {
    $model['type'] = 'info';
}
?>
<div class="<?='alert alert-' . $model['type']?>" role="alert"><?=$model['text']?></div>