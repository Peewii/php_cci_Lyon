<?php

session_start();

if (isset($_SESSION['LOGGED_USER'])) {
    unset($_SESSION['LOGGED_USER']);
}

header('Location: /');
