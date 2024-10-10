<?php
session_start();
if (!isset($_SESSION['login'])) {
    header('Location: index.php');
    exit();
}

if (isset($_SESSION['welcome_message'])) {
    echo '<h2>' . $_SESSION['welcome_message'] . '</h2>';
    unset($_SESSION['welcome_message']);
} else {
    echo '<h2>Bem-vindo(a), ' . $_SESSION['login'] . '!</h2>';
}

echo '<a href="?logout">Fazer logout!</a>';


if (isset($_GET['logout'])) {
    unset($_SESSION['login']);
    session_destroy();
    header('Location: index.php');
    exit();
}
?>