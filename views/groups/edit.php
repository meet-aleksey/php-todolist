<?php 
use PhpMvc\View;
use PhpMvc\Html;

View::setLayout('layout.php');

$model = new \TodoList\Models\Group();

View::injectModel($model);

if ($model == null) {
    return;
}

View::setTitle($model->id > 0 ? 'Edit group "' . $model->name . '"' : 'New group');
?>

<h2><?=($model->id > 0 ? 'Edit group' : 'New group')?></h2>

<?=Html::beginForm('edit', null, array('id' => $model->id), 'post', true)?>
    <div class="form-group">
        <label for="name"><?=Html::displayName('name')?>:</label>
        <?=Html::textBox(
            'name',
            null, 
            array(
                'required' => 'required', 
                'class' => 'form-control',
                'maxlength' => 50
            )
        )?>
        <p><?=Html::validationMessage('name')?></p>
        <p class="help-block"><?=Html::displayText('name')?></p>
    </div>
    <div class="form-group">
        <label for="comment"><?=Html::displayName('comment')?>:</label>
        <?=Html::textBox(
            'comment',
            null, 
            array(
                'class' => 'form-control',
                'maxlength' => 500
            )
        )?>
        <p><?=Html::validationMessage('comment')?></p>
        <p class="help-block"><?=Html::displayText('comment')?></p>
    </div>
    <div class="form-group">
        <button type="submin" class="btn btn-primary">Save</button>
        <?=Html::actionLink('Cancel', 'index', null, null, array('class' => 'btn btn-default'))?>
    <div>
<?=Html::endForm()?>