<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>

    <?php
    function carregarUsuarios() {
        $arquivo = 'usuarios.json';
        if (file_exists($arquivo)) {
            $dadosJson = file_get_contents($arquivo);
            return json_decode($dadosJson, true);
        }
        return [];
    }

    
    function salvarUsuarios($usuarios) {
        $dadosJson = json_encode($usuarios, JSON_PRETTY_PRINT);
        file_put_contents('usuarios.json', $dadosJson); 
    }

    
    $usuarios = carregarUsuarios();

    
    if (!isset($_SESSION['login'])) {

        
        if (isset($_POST['acao'])) {
            
            $emailForm = isset($_POST['email']) ? $_POST['email'] : '';
            $senhaForm = isset($_POST['senha']) ? $_POST['senha'] : '';

            $usuarioEncontrado = false;

            
            foreach ($usuarios as $usuario) {
                if ($usuario['email'] == $emailForm && $usuario['senha'] == $senhaForm) {
                    
                    $_SESSION['login'] = $usuario['nome']; 
                    header('Location: home.php');
                    $usuarioEncontrado = true;
                    exit(); 
                }
            }

            
            if (!$usuarioEncontrado) {
                echo 'E-mail ou senha inválidos.';
            }
        }

        

        } else {
        
        if (isset($_GET['logout'])) {
            unset($_SESSION['login']);
            session_destroy();
            header('Location: index.php');
            exit(); 
        }

        
        include('home.php');
    }
    ?>

    
    <h2>Cadastrar Novo Usuário</h2>
    <form method="post" action="">
        <input type="text" name="nome" placeholder="Nome completo" required>
        <input type="email" name="email" placeholder="E-mail" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <input type="submit" name="cadastrar" value="Cadastrar">
    </form>

    <?php
    
    if (isset($_POST['cadastrar'])) {
        
        $novoNome = isset($_POST['nome']) ? $_POST['nome'] : '';
        $novoEmail = isset($_POST['email']) ? $_POST['email'] : '';
        $novaSenha = isset($_POST['senha']) ? $_POST['senha'] : '';

        
        $emailExiste = false;
        foreach ($usuarios as $usuario) {
            if (isset($usuario['email']) && $usuario['email'] == $novoEmail) {
                $emailExiste = true;
                break;
            }
        }

        if ($emailExiste) {
            echo 'E-mail já existente. Escolha outro ou entre em sua conta.';
        } else {
           
            $usuarios[] = [
                'nome' => $novoNome,
                'email' => $novoEmail,
                'senha' => $novaSenha
            ];

            
            salvarUsuarios($usuarios);

            
            $_SESSION['login'] = $novoNome; 
            $_SESSION['welcome_message'] = 'Bem-vindo(a), ' . $novoNome . '!';

            
            header('Location: home.php');
            exit();
        }
    }
    ?>

</body>
</html>
