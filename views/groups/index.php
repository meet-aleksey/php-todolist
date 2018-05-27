<?php 
use PhpMvc\View;
use PhpMvc\Html;

View::setLayout('layout.php');
View::setTitle('Groups');

$model = array(new \TodoList\Models\GroupList());

View::injectModel($model);
?>

<h2>
Groups
<?=Html::actionLink('New group', 'new', null, null, array('class' => 'btn btn-success pull-right'))?>
</h2>

<div class="clearfix"></div>

<?php
if (isset($model) && $model->total > 0) {
?>
  <table class="table table-hover">
      <thead>
          <tr>
              <th>ID</th>
              <th>Group name</th>
              <th class="text-center">Tasks</th>
              <th>&nbsp;</th>
              <th>&nbsp;</th>
          </tr>
      </thead>
      <tbody>
          <?php
              foreach($model->items as $group) {
                  echo '<tr>';
                  echo '<td>' . $group->id . '</td>';
                  echo '<td>' . Html::actionLink($group->name, 'edit', null, array('id' => $group->id)) . '</td>';
                  echo '<td class="text-center">' . $group->tasks . '</td>';
                  echo '<td class="text-center">' . Html::actionLink('Edit', 'edit', null, array('id' => $group->id)) . '</td>';
                  echo '<td class="text-center">' .
                  Html::actionLink(
                      'Delete', 
                      'delete', 
                      null, 
                      array('id' => $group->id),
                      array('onclick' => 'return confirm("Are you sure you want to delete group #' . $group->id . ' and all related entries?")')
                  ) .
                  '</td>';
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
  <div>
    <p>You can place tasks by groups.</p>
    <p>Unfortunately, you do not have any groups yet.</p>
    <p><?=Html::actionLink('Create a new group now', 'new')?>.</p>
  </div>
<?php
}
?>