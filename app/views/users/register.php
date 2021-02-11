<?php require APPROOT . '/views/inc/header.php';?>

<div class="row">
    <div class="col-lg-6 mx-auto">
        <div class="card card-body bd-light mt-5">
            <?php flash('register_fail'); ?>
            <h2>Create an account</h2>
            <p>Please fill in the form to register with us</p>
            <form action="" method="post" autocomplete="off">
                <div class="form-group">
                    <label for="name">Name: <sup>*</sup></label>
                    <input type="text" class="form-control form-control-lg <?php echo (!empty($data['errors']['firstnameErr'])) ? 'is-invalid' : '';?>"
                           name="firstname" id="firstname" value="<?php echo $data['firstname']?>">
                    <span class="invalid-feedback"><?php echo $data['errors']['firstnameErr']?></span>
                </div>
                <div class="form-group">
                    <label for="name">Lastname: <sup>*</sup></label>
                    <input type="text" class="form-control form-control-lg <?php echo (!empty($data['errors']['lastnameErr'])) ? 'is-invalid' : '';?>"
                           name="lastname" id="lastname" value="<?php echo $data['lastname']?>">
                    <span class="invalid-feedback"><?php echo $data['errors']['lastnameErr']?></span>
                </div>
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
                <div class="form-group">
                    <label for="confirmPassword">Confirm password: <sup>*</sup></label>
                    <input type="password" class="form-control form-control-lg <?php echo (!empty($data['errors']['confirmPasswordErr'])) ? 'is-invalid' : '';?>"
                           name="confirmPassword" id="confirmPassword" value="<?php echo $data['confirmPassword']?>">
                    <span class="invalid-feedback"><?php echo $data['errors']['confirmPasswordErr']?></span>
                </div>
                <div class="row">
                    <div class="col">
                        <input type="submit" class="btn btn-primary btn-block" value="Register">
                    </div>
                    <div class="col">
                        <a href="<?php echo URLROOT?>/users/login" class="btn btn-light btn-block float-right">Have an account? Login</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php';