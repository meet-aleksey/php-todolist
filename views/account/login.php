<?php 
use PhpMvc\View;
use PhpMvc\Html;
$model = new \TodoList\Models\LoginForm();

View::setLayout('layout.php');
View::setTitle('Sign in');
View::injectModel($model);
?>

<div class="modal show" tabindex="-1" role="dialog" style="position: static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Sign in</h4>
      </div>
      <div class="modal-body">
        <?=Html::beginForm('Login', 'Account', null, 'post', true, array('id' => 'loginForm'))?>
            <div class="form-group">
                <label for="adminLogin"><?=Html::displayName('username')?>:</label>
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
                <label for="adminPassword"><?=Html::displayName('password')?>:</label>
                <?=Html::password(
                  'password',
                  null, 
                  array(
                    'required' => 'required', 
                    'class' => 'form-control'
                  )
                )?>
                <p><?=Html::validationMessage('password')?></p>
                <p class="help-block"><?=Html::displayText('password')?></p>
            </div>
            <div class="checkbox">
                <label>
                <?=Html::checkbox('rememberMe')?> Do not forget me never
                </label>
            </div>
            <div class="form-group">
                <p>Do not have an account on our website yet? How so? <?=Html::actionLink('Create an account immediately', 'join', 'account')?>!</p>
                <p>Forgot your password? No problem! <?=Html::actionLink('Just create another account', 'join', 'account')?>!</p>
            </div>
        <?=Html::endForm()?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-lg pull-left" onclick="$('#loginForm').submit()">Login</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->