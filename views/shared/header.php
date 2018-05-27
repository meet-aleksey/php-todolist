<?php 
use PhpMvc\Html;
use PhpMvc\View;

$class = '';

View::injectModel($class);

if (empty($class)) {
  $class = 'navbar-default';
}

$session = View::getHttpContext()->getSession();
?>
<header>
  <nav class="<?='navbar ' . $class?>">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/">
          <i class="glyphicon glyphicon-tasks"></i>
          TODO
        </a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
          <?php
            if (!empty($session['userId'])) {
              echo '<li><p class="navbar-btn">' .
              '<a href="' . Html::action('profile', 'account') . '" class="btn btn-link"><i class="glyphicon glyphicon-user"></i> ' . $session['userName'] . '</a>' .
              '<a href="' . Html::action('index', 'groups') . '" class="btn btn-link"><i class="glyphicon glyphicon-th-large"></i> Groups</a>' .
              '<a href="' . Html::action('index', 'tasks') . '" class="btn btn-link"><i class="glyphicon glyphicon-th-list"></i> Tasks</a>' .
              '<a href="' . Html::action('exit', 'account') . '" class="btn btn-link"><i class="glyphicon glyphicon-log-out"></i> Logout</a> ' .
              '</p></li>';
            }
            else {
              echo '<li><p class="navbar-btn">' .
              '<a href="' . Html::action('login', 'account') . '" class="btn btn-danger"><i class="glyphicon glyphicon-log-in"></i> Sign in</a>' .
              '</p></li>';
            }
          ?>
          
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
</header>