<?php 
use PhpMvc\View;
use PhpMvc\Html;

View::setLayout('layout.php');
View::setTitle('Tasks');

$model = new \TodoList\Models\TaskList();

View::injectModel($model);
?>

<ul id="stateFilter" class="tabs">
  <li data-state="opened"><?=Html::actionLink('Open', 'index')?></a></li>
  <li data-state="closed"><?=Html::actionLink('Closed', 'index', null, array('state' => 'closed'))?></li>
  <li data-state="all"><?=Html::actionLink('All', 'index', null, array('state' => 'all'))?></li>
</ul>

<?=Html::actionLink('New task', 'new', null, null, array('class' => 'btn btn-success pull-right'))?>

<div class="filter row">
  <?=Html::beginForm('index', null, null, 'get', false, array('class' => 'form-inline'))?>
    <div class="input-group" style="width:100%;">
      <span class="input-group-addon" style="width:100%">
        <input name="search" value="<?=Html::encode(View::getRequest()->get('search'))?>" type="text" class="form-control" placeholder="Search of filter tasks"  style="width:100%" />
      </span>
      <span class="input-group-addon"> 
      <button type="submit" class="btn btn-default">Search</button>
      </span>
    </div>
    <input type="hidden" name="state" value="<?=Html::encode(View::getRequest()->get('state', 'opened', true))?>" />
  <?=Html::endForm()?>
</div>

<div class="clearfix"></div>

<div class="tab-content">
  <?php
    if (!empty($model->items)) {
  ?>
      <table class="table table-hover tasks">
          <tbody>
              <?php 
                  foreach($model->items as $task) {
                      echo '<tr>';
                      echo '<td>';
                      echo Html::actionLink($task->title, 'show', null, array('id' => $task->id));
                      echo '<br />';
                      echo '<small>#' . $task->id . ' &middot; created ' . $task->created->format('Y-m-d \a\t H:i:s') . ' by ' . $task->user->username . '</small>';
                      echo '</td>';
                      echo '<td class="text-right">';
                      echo ($task->closed === true ? '<strong>CLOSED</strong>' : '');
                      echo '&nbsp;&nbsp;';
                      echo '<small><i class="glyphicon glyphicon-comment"></i> x' . $task->comments . '</small>';
                      echo '</td>';
                      echo '</tr>';
                  }
              ?>
          </tbody>
      </table>

      <?php Html::render('pagination', $model); ?>
  <?php
    }
    else {
  ?>
    <p class="text-center">There are no tasks to show.</p>
  <?php
    }
  ?>
</div>

<script type="text/javascript">
$(document).ready(function() {
  var state = '<?=View::getRequest()->get('state', 'opened', true)?>';
  $('li[data-state="' + state + '"]', '#stateFilter').addClass('active');
});
</script>