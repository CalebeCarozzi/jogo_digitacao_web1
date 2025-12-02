<?php
require_once "functions_db.php";
require_once "authenticate.php";
require_once "lib/sanitize.php";

//comentando enquanto ainda não tem botão de logout
// if ($login) {
//     header("Location: index.php");
//     exit;
// }

$nome = $email = $senha = $confirmar_senha = "";
$erro_nome = $erro_email = $erro_senha = $erro_confirmar_senha = $erro_geral = "";
$erro = false;


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    //Nome
    if (empty($_POST["nome"])) {
        $erro_nome = "Nome é obrigatório.";
        $erro = true;
    } else {
        $nome = sanitize($_POST["nome"]);

        if (!preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $nome)) {
            $erro_nome = "Nome deve conter apenas letras e espaços.";
            $erro = true;
        }
    }

    //email
    if (empty($_POST["email"])) {
        $erro_email = "E-mail é obrigatório.";
        $erro = true;
    } else {
        $email = sanitize($_POST["email"]);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erro_email = "Formato de e-mail inválido.";
            $erro = true;
        }
    }

    //senha
    if (empty($_POST["senha"])) {
        $erro_senha = "Senha é obrigatória.";
        $erro = true;
    } else {
        $senha = $_POST["senha"];

        if (strlen($senha) < 8) {
            $erro_senha = "Senha deve ter pelo menos 8 caracteres.";
            $erro = true;
        }
    }

    //confimacao de senha
    if (empty($_POST["confirmar_senha"])) {
        $erro_confirmar_senha = "Confirmação de senha é obrigatória.";
        $erro = true;
    } else {
        $confirmar_senha = $_POST["confirmar_senha"];

        if (empty($erro_senha) && !empty($senha)  && $senha !== $confirmar_senha) {
            $erro_confirmar_senha = "Senha e confirmação de senha não conferem.";
            $erro_senha = "Senha e confirmação de senha não conferem.";
            $erro = true;
        }
    }

    
    //insert no banco de dados

    if ($erro === false) {
        $conn = connect_db();

        $nome_esc  = mysqli_real_escape_string($conn, $nome);
        $email_esc = mysqli_real_escape_string($conn, $email);


        $sql = "SELECT id 
                FROM usuarios 
                WHERE email = '$email_esc'
                LIMIT 1";

        $result_email = mysqli_query($conn, $sql);

        if ($result_email && mysqli_num_rows($result_email) > 0) {

            $erro_email = "Já existe um usuário cadastrado com esse e-mail.";
            $erro = true;
        } else {

            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
            $senha_hash_esc = mysqli_real_escape_string($conn, $senha_hash);

            $sql = "INSERT INTO usuarios (nome, email, senha_hash)
                    VALUES ('$nome_esc', '$email_esc', '$senha_hash_esc') ";

            if (mysqli_query($conn, $sql)) {

                $_SESSION["msg_sucesso"] = "Cadastro realizado com sucesso! Agora faça login.";

                header("Location: login.php");
                exit;
            } else {
                $erro = true;
                $erro_geral = "Erro ao salvar usuário no banco de dados.";
            }
        }

        mysqli_close($conn);
    }
}



?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Cadastro - Jogo de Digitação</title>
</head>

<body>
    <h1>Cadastro de Usuário</h1>


    <?php if (!empty($erro_geral)): ?>
        <div style="color:red; margin-bottom: 10px;">
            <?php echo htmlspecialchars($erro_geral); ?>
        </div>
    <?php endif; ?>

    <form method="post" action="register.php">
        <div>
            <label for="nome">Nome:</label><br>
            <input type="text" id="nome" name="nome" value="<?php echo $nome; ?>">
            <?php if (!empty($erro_nome)): ?>
                <div style="color:red;"><?php echo htmlspecialchars($erro_nome); ?></div>
            <?php endif; ?>
        </div>

        <br>

        <div>
            <label for="email">E-mail:</label><br>
            <input type="text" id="email" name="email" value="<?php echo $email; ?>">
            <?php if (!empty($erro_email)): ?>
                <div style="color:red;"><?php echo htmlspecialchars($erro_email); ?></div>
            <?php endif; ?>
        </div>

        <br>

        <div>
            <label for="senha">Senha (mínimo 8 caracteres):</label><br>
            <input type="password" id="senha" name="senha">
            <?php if (!empty($erro_senha)): ?>
                <div style="color:red;"><?php echo htmlspecialchars($erro_senha); ?></div>
            <?php endif; ?>
        </div>

        <br>

        <div>
            <label for="confirmar_senha">Confirme a senha:</label><br>
            <input type="password" id="confirmar_senha" name="confirmar_senha">
            <?php if (!empty($erro_confirmar_senha)): ?>
                <div style="color:red;"><?php echo htmlspecialchars($erro_confirmar_senha); ?></div>
            <?php endif; ?>
        </div>

        <br>

        <input type="submit" value="Criar usuário">
    </form>

    <p><a href="login.php">Voltar para tela de login</a></p>
</body>

</html>