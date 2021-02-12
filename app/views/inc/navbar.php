
<nav class="navbar navbar-expand-sm navbar-dark bg-dark">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link <?php echo ($data['currentPage'] === 'home') ? 'active' : ''?>" href="<?php echo URLROOT?>pixels/index/all">All Pixels</a>
            </div>
            <div class="navbar-nav ml-auto">
                <?php if(!isLoggedIn()) :?>
                    <a class="nav-link <?php echo ($data['currentPage'] === 'register') ? 'active' : ''?>" href="<?php echo URLROOT?>users/register">Register</a>
                    <a class="nav-link <?php echo ($data['currentPage'] === 'login') ? 'active' : ''?>" href="<?php echo URLROOT?>users/login">Login</a>
                <?php else :?>
                    <a class="disabled nav-link active" href="#">Vilkommen <?php echo $_SESSION['user_name'] ?? null?></a>
                    <a class="nav-link <?php echo ($data['currentPage'] === 'myPixels') ? 'active' : ''?>" href="<?php echo URLROOT?>pixels/index/user">My Pixels</a>
                    <a class="nav-link <?php echo ($data['currentPage'] === 'addPixel') ? 'active' : ''?>" href="<?php echo URLROOT?>addpixel/index">Add New Pixel</a>
                    <a class="nav-link <?php echo ($data['currentPage'] === 'activityLog') ? 'active' : ''?>" href="<?php echo URLROOT?>activity/index">Activity Log</a>
                    <a class="nav-link" href="">Profile</a>
                    <a class="nav-link" href="<?php echo URLROOT?>users/logout">Logout</a>
                <?php endif;?>
            </div>
        </div>
    </div>
</nav>
