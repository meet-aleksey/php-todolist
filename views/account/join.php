<?php 
use PhpMvc\View;
use PhpMvc\Html;

$model = new \TodoList\Models\JoinForm();

View::setLayout('layout.php');
View::setTitle('Sign up');
View::injectModel($model);
?>

<div class="modal show" tabindex="-1" role="dialog" style="position: static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Sign up</h4>
      </div>
      <div class="modal-body">
        <p>To become a user of our wonderful site, please fill out this form:</p>
        <?=Html::beginForm('Join', 'Account', null, 'post', true, array('id' => 'joinForm', 'enctype' => 'application/x-www-form-urlencoded'))?>
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
                <label for="password"><?=Html::displayName('password')?>:</label>
                <?=Html::password(
                  'password',
                  null, 
                  array(
                    'required' => 'required', 
                    'class' => 'form-control',
                    'maxlength' => 24
                  )
                )?>
                <p><?=Html::validationMessage('password')?></p>
                <p class="help-block"><?=Html::displayText('password')?></p>
            </div>
            <div class="form-group">
                <label for="confirmPassword"><?=Html::displayName('confirmPassword')?>:</label>
                <?=Html::password(
                  'confirmPassword',
                  null, 
                  array(
                    'required' => 'required', 
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
        <a href="<?=Html::action('Login', 'Account')?>" class="btn btn-link btn-lg">Sign in</a>
        <button type="button" class="btn btn-primary btn-lg pull-left" onclick="$('#joinForm').submit()">Submit</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->