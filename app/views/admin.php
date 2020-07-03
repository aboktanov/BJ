@layout('main')
<?php if ($error) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error; ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
<?php } ?>
<?php if ($success) { ?>
    <div class="panel-body">
        <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    </div>
<?php } ?>
<form style="margin-top:20px" method="POST" action="/taskEdit">
    <input type="hidden" name="i_id" value="<?php echo $i_id; ?>">
    <div class="form-group">
        <label for="i_email">Email адрес</label>
        <input type="email" class="form-control" id="i_email" name="i_email" value="<?php echo $i_email; ?>">
        <?php if ($i_email_error) { ?>
            <p class="alert alert-danger"></i> <?php echo $i_email_error; ?></p>
        <?php } ?>
    </div>
    <div class="form-group">
        <label for="i_name">Имя</label>
        <input type="text" class="form-control" id="i_name" name="i_name" value="<?php echo $i_name; ?>">
        <?php if ($i_name_error) { ?>
            <p class="alert alert-danger"></i> <?php echo $i_name_error; ?></p>
        <?php } ?>
    </div>
    <div class="form-group">
        <label for="i_task">Задача</label>
        <textarea class="form-control" id="i_task" name="i_task" rows="3"><?php echo $i_task; ?></textarea>
        <?php if ($i_task_error) { ?>
            <p class="alert alert-danger"></i> <?php echo $i_task_error; ?></p>
        <?php } ?>
    </div>
    <button type="submit" class="btn btn-primary">Сохранить</button>
</form>