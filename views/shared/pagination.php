<?php 
use PhpMvc\View;
use PhpMvc\Html;

$model = new \TodoList\Models\PageList();
View::injectModel($model);

if ($model == null) {
    return;
}

$outputLimit = 5;
$parts = ceil($model->total / $model->limit);

if ($parts <= 1) {
    return;
}

if ($model->page >= $outputLimit)
{
    $start = ceil(($model->page / $outputLimit) + ($outputLimit / 2));
}
else
{
    $start = 1;
}

$start = ($start <= 0 ? 1 : $start);

$end = $start + $outputLimit;

if ($end > $parts) {
    $end = $parts;
}

$actionName = View::getViewContext()->getActionName();
$routeValues = View::getHttpContext()->getRequest()->get();

if (!isset($routeValues)) {
    $routeValues = array();
}

if (isset($routeValues['page'])) {
    unset($routeValues['page']);
}
?>

<nav aria-label="page navigation" class="text-center">
    <ul class="pagination">
      <li class="<?=($model->page <= 1 ? 'disabled' : '')?>">
        <a href="<?=($model->page > 1 ? Html::action($actionName, null, array_merge($routeValues, array('page' => $model->page - 1))) : '')?>" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>
      <?php
        for ($i = $start; $i <= $end; ++$i) {
            echo '<li' . ($i == $model->page ? ' class="active"' : '') . '>' . Html::actionLink($i, $actionName, null, array_merge($routeValues, array('page' => $i))) . '</a></li>';
        }
      ?>
      <li class="<?=($model->page + 1 > $parts ? 'disabled' : '')?>">
        <a href="<?=($model->page + 1 <= $parts ? Html::action($actionName, null, array_merge($routeValues, array('page' => $model->page + 1))) : '')?>" aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
        </a>
      </li>
    </ul>
  </nav>