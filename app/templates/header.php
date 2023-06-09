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
                <a href="/logout.php" class="btn btn-danger">Deconnexion</a>
            <?php else : ?>
                <a href="/login.php" class="btn btn-light">Connexion</a>
            <? endif; ?>
        </div>
    </nav>
</header>