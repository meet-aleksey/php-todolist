<?php 
use PhpMvc\View;
use PhpMvc\Html;

View::setLayout('layout.php');
View::setTitle('Tasks');

$model = new \TodoList\Models\TaskList();

View::injectModel($model);
?>

<div class="task-info small">
  <span id="status" class="btn btn-default"></span>
  <strong><?=Html::actionLink('Task #' . $model->task->id, 'show', null, array('id' => $model->task->id))?></strong>
  &middot; created <?=$model->task->created->format('Y-m-d \a\t H:i:s')?>
  by <strong><?=$model->task->user->username?></strong>
</div>

<hr style="margin-top: 4px; margin-bottom: 4px;" />

<h2 style="margin-top: 4px;"><?=$model->task->title?></h2>

<div class="task">
  <?=str_replace(chr(10), '<br />', $model->task->text)?>
</div>

<?php
  if (!empty($model->tags)) {
    $tags = explode(',', $model->tags);

    echo '<br />';

    foreach ($tags as $tag) {
      echo '<span class="badge">' . $tag . '</span> ';
    }
  }
?>

<?php
  if (!empty($model->files)) {
    echo '<br />';
    echo '<h4>Attachments</h4>';

    foreach ($model->files as $file) {
      echo '<a href="/upload/' . $file->name . '" target="_blank">' . $file->name . '</a> (' . round($file->size / 1000, 2) . ' KiB)<br />';
    }
  }
?>
<hr />
<div id="comments">
<?php
  foreach ($model->comments as $comment) {
    Html::render('comment', $comment);
  }
?>
</div>
<hr />
<?=Html::beginForm('add', 'comments', array('id' => $model->task->id), 'post', true, array('id' => 'commentForm', 'class' => 'colon-labels'))?>
    <div class="form-group">
        <?=Html::label(array('text'))?>
        <?=Html::textArea(
            array('text'),
            null, 
            10,
            null,
            array(
                'class' => 'form-control',
            )
        )?>
        <p><?=Html::validationMessage(array('text'))?></p>
        <p class="help-block"><?=Html::displayText(array('text'))?></p>
    </div>
    <div class="form-group">
        <button id="btnSendComment" class="btn btn-primary" disabled>Comment</button>
        <button id="btnClose" class="btn btn-default">Close</button>
    </div>
<?=Html::endForm()?>

<?=Html::hidden('closed', $model->task->closed ? 'true' : 'false')?>

<script type="text/javascript">
$(document).ready(function() {
  update();

  $('#text').keypress(function() {
    update();
  }).change(function() {
    update();
  });

  $('#commentForm').submit(function(e) {
    e.preventDefault();

    var $form = $(this);

    $.ajax({
      type: $form.attr('method'),
      url: $form.attr('action') + ($(e.target).data('close') ? '?close=' + $(e.target).data('close') : ''),
      data: $form.serialize(),
      beforeSend: function() {
        $('#text,#btnSendComment,#btnClose').prop('disabled', true);
        if (!$(e.target).data('close')) {
          $('#btnSendComment').text('Sending...');
        }
        else {
          $('#btnClose').text($('#text').val() == '' ? ($(e.target).data('close') == 'true' ? 'Closing...' : 'Reopening...') : 'Sending...');
        }
      }
    }).done(function(result) {
      $('#comments').append(result);
      $('#text').val('');
      $('#text,#btnClose').prop('disabled', false);
      $('#btnSendComment').text('Comment');

      if ($(e.target).data('close')) {
        $('#closed').val($(e.target).data('close'));
      }

      update();
    }).fail(function(result) {
      alert(result.message ? result.message : 'error');
      $('#text,#btnClose').prop('disabled', false);
      update();
    });
  });

  $('#btnSendComment,#btnClose').click(function(e) {
    e.preventDefault();

    if ($(e.target).attr('id') == 'btnClose') {
      $('#commentForm').data('close', $('#closed').val() === 'true' ? 'false' : 'true');
    }
    else {
      $('#commentForm').data('close', null);
    }

    $('#commentForm').submit();
  });

});

function update() {
  $('#btnSendComment').prop('disabled', $('#text').val() == '');
  $('#btnSendComment').text('Comment');

  var actionTitle =  $('#closed').val() === 'true' ? 'Reopen' : 'Close';
  var commentTitle =  $('#closed').val() === 'true' ? 'Comment and reopen' : 'Comment and close';

  $('#btnClose').text($('#text').val() == '' ? actionTitle : commentTitle);

  $('#status').attr('class', 'btn btn-sm ' + ($('#closed').val() === 'true' ? 'btn-danger' : 'btn-success'));
  $('#status').text($('#closed').val() === 'true' ? 'Closed' : 'Open');
}
</script>