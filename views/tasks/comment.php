<?php 
use PhpMvc\View;
use PhpMvc\Html;

$model = new \TodoList\Models\Comment();

View::injectModel($model);
?>

<div id="<?=$model->id?>" class="comment">
    <div class="comment-author">
        <strong><a href="#<?=$model->id?>">#<?=$model->id?></a></strong>
        &middot;
        <?=$model->user->username?>
        &middot;
        <?=$model->created->format('Y-m-d \a\t H:i:s')?>
    </div>
    <div class="comment-text"><?=str_replace(chr(10), '<br />', $model->text)?></div>
</div>