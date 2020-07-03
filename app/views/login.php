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

<form style="margin-top:20px" method="POST" action="login">
    <div class="form-group">
        <label for="i_login">Логин</label>
        <input type="text" class="form-control" id="i_login" name="i_login" value="<?php echo $i_login; ?>">
        <?php if ($i_login_error) { ?>
            <p class="alert alert-danger"></i> <?php echo $i_login_error; ?></p>
        <?php } ?>
    </div>
    <div class="form-group sm-3">
        <label for="i_password">Пароль</label>
        <input type="password" class="form-control" id="i_password" name="i_password">
        <?php if ($i_password_error) { ?>
            <p class="alert alert-danger"></i> <?php echo $i_password_error; ?></p>
        <?php } ?>
    </div>
    <button type="submit" class="btn btn-primary">Войти</button>
</form>