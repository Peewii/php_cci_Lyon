<header class="navbar">
    <nav class="container navbar-content">
        <div class="navbar-left">
            <a href="/" class="navbar-brand">My First App Php</a>
            <ul class="navbar-nav">
                <li class="navbar-item">
                    <a href="/" class="navbar-link">Home</a>
                </li>
            </ul>
        </div>
        <div class="navbar-btn">
            <?php if (isset($_SESSION['LOGGED_USER'])) : ?>
                <div class="dropdown btn btn-light">
                    <span>Admin</span>
                    <div class="dropdown-content">
                        <a href="/admin/users" class="dropdown-link">Users</a>
                        <a href="/admin/features" class="dropdown-link">Features</a>
                        <a href="/admin/articles" class="dropdown-link">articles</a>
                    </div>
                </div>
                <a href="/logout.php" class="btn btn-danger">Deconnexion</a>
            <?php else : ?>
                <a href="/login.php" class="btn btn-light">Connexion</a>
                <a href="/register.php" class="btn btn-dark">Inscription</a>
            <? endif; ?>
        </div>
    </nav>
</header>