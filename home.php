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

function carregarUsuarios() {
    $arquivo = 'usuarios.json';
    if (file_exists($arquivo)) {
        $dadosJson = file_get_contents($arquivo);
        return json_decode($dadosJson, true);
    }
    return [];
}


$usuarios = carregarUsuarios();

if ($usuarios) {
    echo '<h3>Usuários Cadastrados:</h3>';
    echo '<table border="1">';
    echo '<tr><th>Nome</th><th>Email</th></tr>';
    foreach ($usuarios as $usuario) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($usuario['nome']) . '</td>';
        echo '<td>' . htmlspecialchars($usuario['email']) . '</td>';
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo '<p>Nenhum usuário cadastrado.</p>';
}


if (isset($_GET['logout'])) {
    unset($_SESSION['login']);
    session_destroy();
    header('Location: index.php');
    exit();
}
?>
