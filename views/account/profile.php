<?php 
use PhpMvc\View;
use PhpMvc\Html;

$model = new \TodoList\Models\JoinForm();

View::setLayout('layout.php');
View::setTitle('Profile');
View::injectModel($model);
?>

<div class="modal show" tabindex="-1" role="dialog" style="position: static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Profile</h4>
      </div>
      <div class="modal-body">
        <?=Html::beginForm('profile', null, null, 'post', true, array('id' => 'profileForm', 'enctype' => 'application/x-www-form-urlencoded'))?>
            <div class="form-group">
                <label for="username"><?=Html::displayName('username')?>:</label>
                <?=Html::textBox(
                  'username',
                  null, 
                  array(
                    'required' => 'required', 
                    'class' => 'form-control',
                    'maxlength' => 50
                  )
                )?>
                <p><?=Html::validationMessage('username')?></p>
                <p class="help-block"><?=Html::displayText('username')?></p>
            </div>
            <div class="form-group">
                <label for="email"><?=Html::displayName('email')?>:</label>
                <?=Html::email(
                  'email',
                  null, 
                  array(
                    'required' => 'required', 
                    'class' => 'form-control',
                    'maxlength' => 50
                  )
                )?>
                <p><?=Html::validationMessage('email')?></p>
                <p class="help-block"><?=Html::displayText('email')?></p>
            </div>
            <div class="form-group">
                <label for="password"><?=Html::displayName('newPassword')?>:</label>
                <?=Html::password(
                  'newPassword',
                  null, 
                  array(
                    'class' => 'form-control',
                    'maxlength' => 24
                  )
                )?>
                <p><?=Html::validationMessage('newPassword')?></p>
                <p class="help-block"><?=Html::displayText('newPassword')?></p>
            </div>
            <div class="form-group">
                <label for="confirmPassword"><?=Html::displayName('confirmPassword')?>:</label>
                <?=Html::password(
                  'confirmPassword',
                  null, 
                  array(
                    'class' => 'form-control',
                    'maxlength' => 24
                  )
                )?>
                <p><?=Html::validationMessage('confirmPassword')?></p>
                <p class="help-block"><?=Html::displayText('confirmPassword')?></p>
            </div>
        <?=Html::endForm()?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-lg pull-left" onclick="$('#profileForm').submit()">Save</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->