<?php require APPROOT . '/views/inc/header.php';?>

<div class="row">
    <div class="col-lg-6 mx-auto">
        <div class="card card-body bd-light mt-5">
            <?php flash('register_success');?>
            <h2>Login</h2>
            <form action="" method="post" autocomplete="off">
                <div class="form-group">
                    <label for="email">Email: <sup>*</sup></label>
                    <input type="text" class="form-control form-control-lg <?php echo (!empty($data['errors']['emailErr'])) ? 'is-invalid' : '';?>"
                           name="email" id="email" value="<?php echo $data['email']?>">
                    <span class="invalid-feedback"><?php echo $data['errors']['emailErr']?></span>
                </div>
                <div class="form-group">
                    <label for="password">Password: <sup>*</sup></label>
                    <input type="password" class="form-control form-control-lg <?php echo (!empty($data['errors']['passwordErr'])) ? 'is-invalid' : '';?>"
                           name="password" id="password" value="<?php echo $data['password']?>">
                    <span class="invalid-feedback"><?php echo $data['errors']['passwordErr']?></span>
                </div>
                <div class="row">
                    <div class="col">
                        <input type="submit" value="Login" class="btn btn-primary btn-block">
                    </div>
                    <div class="col">
                        <a href="<?php echo URLROOT?>/users/register" class="btn btn-light btn-block float-right">No account? Register</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php';