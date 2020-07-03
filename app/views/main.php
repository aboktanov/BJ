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

<div class="row" style="margin-top:20px">
    <div class="col-sm" >
        <a href="/?sort=user_name">Имя пользователя</a>
        <?php if ($sort == 'user_name' && $sortDirection == 'ASC') { ?>
            <i class="material-icons">arrow_upward</i>
        <?php } ?>
        <?php if ($sort == 'user_name' && $sortDirection == 'DESC') { ?>
            <i class="material-icons">arrow_downward</i>
        <?php } ?>
    </div>
    <div class="col-sm">
        <a href="/?sort=email">Email пользователя</a>
        <?php if ($sort == 'email' && $sortDirection == 'ASC') { ?>
            <i class="material-icons">arrow_upward</i>
        <?php } ?>
        <?php if ($sort == 'email' && $sortDirection == 'DESC') { ?>
            <i class="material-icons">arrow_downward</i>
        <?php } ?>
    </div>
    <div class="col-sm">
        <a href="/?sort=state">Статус задачи</a>
        <?php if ($sort == 'state' && $sortDirection == 'ASC') { ?>
            <i class="material-icons">arrow_upward</i>
        <?php } ?>
        <?php if ($sort == 'state' && $sortDirection == 'DESC') { ?>
            <i class="material-icons">arrow_downward</i>
        <?php } ?>
    </div>
</div>

<?php if ($tasks)
    foreach ($tasks as $task) { ?>
        <div class="card" style="margin-top:20px">
            <div class="card-header">
                <ul class="list-group list-group-horizontal">
                    <li class="list-group-item"><?php echo $task['user_name']; ?></li>
                    <li class="list-group-item"><?php echo $task['email']; ?></li>
                    <li class="list-group-item">
                        <?php
                        if ($task['state'] == '1')
                            echo '<span class="badge badge-pill badge-secondary">Новая</span>';
                        elseif ($task['state'] == '2')
                            echo '<span class="badge badge-pill badge-success">Выполнено</span>';
                        ?>
                    </li>
                    <?php if ($task['original_task']!=$task['task']) { ?>
                        <li class="list-group-item"><span class="badge badge-pill badge-info">отредактировано администратором</span></li>
                    <?php } ?>
                </ul>
            </div>
            <div class="card-body">
                <p class="card-text"><?php echo $task['task']; ?></p>
                <?php if ($admin) { ?>
                    <a href="/edit/?i_id=<?php echo $task['id']; ?>" class="btn btn-primary">Редактировать</a>
                <?php } ?>
                <?php if ( $admin && ($task['state'] == '1')){ ?>
                    <a href="/exec/?i_id=<?php echo $task['id']; ?>" class="btn btn-primary">Выполнено</a>
                <?php } ?>
            </div>
        </div>
        <?php } ?>

<nav aria-label="Page navigation example" style="margin-top:20px">
    <ul class="pagination justify-content-center">
        <?php
        if ($pages) {
            for ($i = 1; $i <= $pages; $i++) {
                if ($currentPage == $i)
                    $status = 'active';
                else
                    $status = '';
                echo '<li class="page-item ' . $status . '"><a href="/?page=' . $i . '" class="page-link" href="#">' . $i . '</a></li>';
            }
        } ?>
    </ul>
</nav>

<form style="margin-top:20px" method="POST" action="/taskAdd">
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
    <button type="submit" class="btn btn-primary">Добавить</button>
</form>
