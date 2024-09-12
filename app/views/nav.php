<nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="./dashboard.php?active=dashboard">
            <img src="../../public/src/assets/images/google-ads.png" alt="">
        </a>
    </div>

    <div class="navbar-menu">
        <div class="navbar-start">
            <a href="./dashboard.php?active=dashboard" class="navbar-item <?php echo $_GET['active'] === 'dashboard' ? 'is-active' : '' ?>">
                Dashboard
            </a>

            <a href="./upload.php?active=upload" class="navbar-item <?php echo $_GET['active'] === 'upload' ? 'is-active' : '' ?>">
                Upload
            </a>
        </div>

        <div class="navbar-end">
            <div class="navbar-item">
                <div class="buttons">
                    <a href="../../public/" class="button is-danger">
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>