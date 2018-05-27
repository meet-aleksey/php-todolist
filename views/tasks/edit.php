<?php 
use \PhpMvc\View;
use \PhpMvc\Html;
use \PhpMvc\SelectListItem;

View::setLayout('layout.php');

$model = new \TodoList\Models\TaskEdit();

View::injectModel($model);

if ($model == null) {
    return;
}

View::setTitle($model->task->id > 0 ? 'Edit task "' . $model->task->title . '"' : 'New task');
?>

<h2><?=($model->task->id > 0 ? 'Edit task' : 'New task')?></h2>

<?=Html::beginForm('edit', null, array('id' => $model->task->id), 'post', true, array('class' => 'colon-labels'))?>
    <div class="form-group">
        <?=Html::label(array('task', 'title'))?>
        <?=Html::textBox(
            array('task', 'title'),
            null,
            array(
                'required' => 'required', 
                'class' => 'form-control',
                'maxlength' => 100
            )
        )?>
        <p><?=Html::validationMessage(array('task', 'title'))?></p>
        <p class="help-block"><?=Html::displayText(array('task', 'title'))?></p>
    </div>
    <div class="form-group">
        <?=Html::label(array('groupId'))?>
        <?=Html::dropDownList(
            array('groupId'),
            $model->groups,
            null,
            array(
                'class' => 'form-control',
            )
        )?>
        <p><?=Html::validationMessage(array('groupId'))?></p>
        <p class="help-block"><?=Html::displayText(array('groupId'))?></p>
    </div>
    <div class="form-group">
        <?=Html::label(array('task', 'text'))?>
        <?=Html::textArea(
            array('task', 'text'),
            null, 
            10,
            null,
            array(
                'required' => 'required', 
                'class' => 'form-control',
            )
        )?>
        <p><?=Html::validationMessage(array('task', 'text'))?></p>
        <p class="help-block"><?=Html::displayText(array('task', 'text'))?></p>
    </div>
    <div class="form-group">
        <?=Html::label(array('tags'))?>
        <?=Html::textBox(
            array('tags'),
            null,
            array('class' => 'form-control')
        )?>
        <p><?=Html::validationMessage(array('tags'))?></p>
        <p class="help-block"><?=Html::displayText(array('tags'))?></p>
    </div>
    <div class="form-group" id="fileuploadContainer">
        <a style="cursor:pointer" onclick="$('#fileupload').click(); return false;"><i class="glyphicon glyphicon-paperclip"></i> Attach a file</a>
    </div>
    <div class="form-group">
        <button type="submin" class="btn btn-primary">Save</button>
        <?=Html::actionLink('Cancel', 'index', null, null, array('class' => 'btn btn-default'))?>
    </div>
    <?=Html::hidden('uploadedFiles')?>
    <?=Html::hidden('removedFiles')?>
<?=Html::endForm()?>

<input id="fileupload" type="file" name="files[]" data-url="/files/upload" multiple class="hidden" />

<script type="text/javascript">
$(document).ready(function() {
    var tagsSource = new Bloodhound({
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        datumTokenizer:Bloodhound.tokenizers.obj.whitespace('value'),
        limit: 10,
        remote: {
            url: '/tasks/tags?search=%SEARCH',
            wildcard: '%SEARCH'
        }
    });

    tagsSource.initialize();

    $('#tags').tokenfield({
        typeahead: [null, { 
            source: tagsSource.ttAdapter(),
            displayKey: 'value'
        }],
        // showAutocompleteOnFocus: true
    });

    $('#fileupload').fileupload({
        dataType: 'json',
        add: function (e, data) {
            data.context = $('<p/>').text('Uploading...').appendTo('#fileuploadContainer');
            data.submit();
        },
        done: function (e, data) {
            data.context.text('');

            var list = data.context;

            $.each(data.result, function (index, file) {
                var link = $('<a />').attr('href', '/upload/' + file.name).attr('target', '_blank').text(file.name);
                var btn = $('<button />').attr('class', 'btn btn-danger btn-sm').text('delete');
                var p = $('<p/>');

                btn.click(function() {
                    if (confirm('Are you sure you want to delete file "' + file.name + '"?')) {
                        $.post('/files/delete/' + file.id, function() {
                            var removed = $('#removedFiles').val();

                            removed += removed.length > 0 ? ',' : '';
                            removed += file.id;

                            $('#removedFiles').val(removed);

                            p.remove();
                        }).fail(function() {
                            alert('error');
                        });
                    }
                });

                var uploaded = $('#uploadedFiles').val();

                uploaded += uploaded.length > 0 ? ',' : '';
                uploaded += file.id;

                $('#uploadedFiles').val(uploaded);

                p.append(link).append('&nbsp;').append(btn).appendTo(list);
            });
        }
    }).on('fileuploadfail', function(e, data) {
        data.context.text('Upload Fail');

        if (data.jqXHR) {
            if (data.jqXHR.responseJSON && data.jqXHR.responseJSON.message) {
                data.context.text(data.jqXHR.responseJSON.message);
            }
            else {
                alert('Server-error:\n\n' + data.jqXHR.responseText);
            }
        }
    });
});
</script>