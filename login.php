<?php
require_once "functions_db.php";
require_once "authenticate.php";
require_once "lib/sanitize.php";

if ($login) {
    header("Location: index.php");
    exit;
}

$msg_sucesso = "";

if (isset($_SESSION["msg_sucesso"])) {
    $msg_sucesso = $_SESSION["msg_sucesso"];
    unset($_SESSION["msg_sucesso"]);
}

$email = $senha = "";

$erro_email_senha = $erro_email = $erro_senha =  $erro_geral  = "";
$erro = false;


if ($_SERVER["REQUEST_METHOD"] === "POST") {

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

    if (empty($_POST["senha"])) {
        $erro_senha = "Senha é obrigatória.";
        $erro = true;
    } else {
        $senha = $_POST["senha"];
    }

    if ($erro === false) {
        $conn = connect_db();

        $email_esc = mysqli_real_escape_string($conn, $email);

        $sql = "SELECT id, nome, email, senha_hash
                FROM usuarios
                WHERE email = '$email_esc'
                LIMIT 1";

        $result = mysqli_query($conn, $sql);

        if ($result === false) {
            $erro_geral = "Erro ao consultar o banco de dados. Tente novamente mais tarde.";
            $erro = true;
        } else if ($result && mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);

            if (password_verify($senha, $row["senha_hash"])) {
                $_SESSION["user_id"]    = $row["id"];
                $_SESSION["user_name"]  = $row["nome"];
                $_SESSION["user_email"] = $row["email"];

                mysqli_close($conn);

                header("Location: index.php");
                exit;
            } else {
                $erro_email_senha = "E-mail ou senha inválidos.";
                $erro = true;
            }
        } else {
            $erro_email_senha = "E-mail ou senha inválidos.";
            $erro = true;
        }

        mysqli_close($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Login - Jogo de Digitação</title>
</head>

<body>
    <h1>Login</h1>

    <?php if (!empty($msg_sucesso)): ?>
        <div style="color: green; margin-bottom: 10px;">
            <?php echo htmlspecialchars($msg_sucesso); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($erro_geral)): ?>
        <div style="color:red; margin-bottom: 10px;">
            <?php echo htmlspecialchars($erro_geral); ?>
        </div>
    <?php endif; ?>

    <form method="post" action="login.php">
        <div>
            <label for="email">E-mail:</label><br>
            <input type="text" id="email" name="email"
                value="<?php echo htmlspecialchars($email); ?>">
            <?php if (!empty($erro_email_senha)): ?>
                <div style="color:red;"><?php echo htmlspecialchars($erro_email_senha); ?></div>
            <?php endif; ?>
            <?php if (!empty($erro_email)): ?>
                <div style="color:red;"><?php echo htmlspecialchars($erro_email); ?></div>
            <?php endif; ?>
        </div>

        <br>

        <div>
            <label for="senha">Senha:</label><br>
            <input type="password" id="senha" name="senha">
            <?php if (!empty($erro_email_senha)): ?>
                <div style="color:red;"><?php echo htmlspecialchars($erro_email_senha); ?></div>
            <?php endif; ?>
            <?php if (!empty($erro_senha)): ?>
                <div style="color:red;"><?php echo htmlspecialchars($erro_senha); ?></div>
            <?php endif; ?>
        </div>

        <br>

        <input type="submit" value="Entrar">
    </form>

    <p>
        Não tem conta?
        <a href="register.php">Cadastre-se</a>
    </p>
</body>

</html>