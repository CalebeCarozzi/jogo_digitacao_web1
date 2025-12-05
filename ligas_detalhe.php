<?php
require_once 'force_authenticate.php';
require_once 'functions_db.php';
require_once 'lib/sanitize.php';

$usuario_id = (int) $_SESSION['user_id'];

if (isset($_SESSION['user_name'])) {
    $nome_usuario_logado = $_SESSION['user_name'];
} else {
    $nome_usuario_logado = "Jogador";
}

//id da liga na URL
$liga_id = 0;
if (isset($_GET['liga_id'])) {
    $liga_id = (int) $_GET['liga_id'];
}

$mensagem_erro = "";
$mensagem_sucesso = "";
$erros_entrada = [];

//nensagem de sucesso vinda do redirect
if (isset($_SESSION['mensagem_liga_detalhe'])) {
    $mensagem_sucesso = $_SESSION['mensagem_liga_detalhe'];
    unset($_SESSION['mensagem_liga_detalhe']);
}

if ($liga_id <= 0) {
    $mensagem_erro = "Liga inválida.";
}

$conn = connect_db();
if (!$conn) {
    die("Erro ao conectar ao banco de dados.");
}

$liga = null;
$usuario_ja_membro = false;
$pontos_totais_liga = 0;
$pontos_semana_liga = 0;
$ranking_usuarios = [];

if (empty($mensagem_erro)) {

    $sql = "SELECT 
                l.id,
                l.nome,
                l.data_criacao,
                l.chave_entrada,
                u.nome AS nome_dono
            FROM ligas l
            JOIN usuarios u ON u.id = l.dono_id
            WHERE l.id = $liga_id
            LIMIT 1
        ";

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        $mensagem_erro = "Erro ao buscar dados da liga: " . mysqli_error($conn);
    } else {
        if (mysqli_num_rows($result) === 0) {
            $mensagem_erro = "Liga não encontrada";
        } else {
            $liga = mysqli_fetch_assoc($result);
        }
    }

    //verificar se já é membro da liga
    if (empty($mensagem_erro) && $liga !== null) {

        $sql = "SELECT id
                FROM ligas_membros
                WHERE liga_id = $liga_id
                AND usuario_id = $usuario_id
                LIMIT 1
            ";

        $res_membro = mysqli_query($conn, $sql);

        if ($res_membro && mysqli_num_rows($res_membro) > 0) {
            $usuario_ja_membro = true;
        }

        //form de entrar na liga
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$usuario_ja_membro) {

            $chave_digitada = "";
            if (isset($_POST['chave_entrada'])) {
                $chave_digitada = sanitize($_POST['chave_entrada']);
            }

            if (empty($chave_digitada)) {
                $erros_entrada[] = "A palavra-chave é obrigatória.";
            } else {
              //aqui a chave tem que ser igual 
                if ($chave_digitada !== $liga['chave_entrada']) {
                    $erros_entrada[] = "Palavra-chave incorreta.";
                }
            }

            //   insere como membro
            if (empty($erros_entrada)) {
                $sql = "INSERT INTO ligas_membros (liga_id, usuario_id)
                        VALUES ($liga_id, $usuario_id)
                        ";

                if (!mysqli_query($conn, $sql)) {
                    $erros_entrada[] = "Erro ao entrar na liga: " . mysqli_error($conn);
                } else {
                    $_SESSION['mensagem_liga_detalhe'] = "Você entrou nesta liga com sucesso!";
                    header("Location:" .  $_SERVER['PHP_SELF'] . "?liga_id=" . $liga_id);
                    exit;
                }
            }
        }

        // Pontos totais
        $sql = "SELECT SUM(p.pontuacao) AS total_pontos
                FROM ligas_membros lm
                JOIN partidas p ON p.usuario_id = lm.usuario_id
                WHERE lm.liga_id = $liga_id
                AND p.data_partida >= lm.data_entrada
                ";

        $res_totais = mysqli_query($conn, $sql);

        if ($res_totais) {
            $row_totais = mysqli_fetch_assoc($res_totais);
            if ($row_totais['total_pontos'] !== null) {
                $pontos_totais_liga = (int) $row_totais['total_pontos'];
            }
        }

        // Pontos na última semana
        $sql = "SELECT SUM(p.pontuacao) AS pontos_semana
                FROM ligas_membros lm
                JOIN partidas p ON p.usuario_id = lm.usuario_id
                WHERE lm.liga_id = $liga_id
                AND p.data_partida >= lm.data_entrada
                AND p.data_partida >= (NOW() - INTERVAL 7 DAY)
            ";

        $res_semana = mysqli_query($conn, $sql);

        if ($res_semana) {
            $row_semana = mysqli_fetch_assoc($res_semana);
            if ($row_semana['pontos_semana'] !== null) {
                $pontos_semana_liga = (int) $row_semana['pontos_semana'];
            }
        }

        $sql = "SELECT 
                    u.id AS usuario_id,
                    u.nome AS nome_usuario,
                    COALESCE(SUM(p.pontuacao), 0) AS pontos_liga
                FROM ligas_membros lm
                JOIN usuarios u ON u.id = lm.usuario_id
                LEFT JOIN partidas p
                ON p.usuario_id = lm.usuario_id
                AND p.data_partida >= lm.data_entrada
                WHERE lm.liga_id = $liga_id
                GROUP BY u.id, u.nome
                ORDER BY pontos_liga DESC, u.nome ASC
                ";

        $res_ranking = mysqli_query($conn, $sql);

        if ($res_ranking) {
            while ($linha = mysqli_fetch_assoc($res_ranking)) {
                $ranking_usuarios[] = $linha;
            }
        }
    }
}

close_db($conn);
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Detalhes da liga</title>
</head>

<body>

    <h1>Detalhes da liga</h1>

    <?php if (!empty($mensagem_erro)): ?>

        <p><?php echo htmlspecialchars($mensagem_erro); ?></p>

    <?php else: ?>

        <?php if (!empty($mensagem_sucesso)): ?>
            <p style="color: green;">
                <?php echo htmlspecialchars($mensagem_sucesso); ?>
            </p>
        <?php endif; ?>

        <p>
            <strong>Nome da liga:</strong>
            <?php echo htmlspecialchars($liga['nome']); ?><br>

            <strong>Dono da liga:</strong>
            <?php echo htmlspecialchars($liga['nome_dono']); ?><br>

            <strong>Data de criação:</strong>
            <?php
                $data_criacao = date('d/m/Y', strtotime($liga['data_criacao']));
                echo $data_criacao;
            ?>
            <br>
        </p>

        <p>
            <strong>Pontos totais da liga:</strong>
            <?php echo $pontos_totais_liga; ?><br>

            <strong>Pontos na última semana da liga:</strong>
            <?php echo $pontos_semana_liga; ?><br>
        </p>

        <h2>Entrar na liga</h2>

        <?php if (!empty($erros_entrada)): ?>
            <div style="color: red;">
                <ul>
                    <?php foreach ($erros_entrada as $erro): ?>
                        <li><?php echo htmlspecialchars($erro); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if ($usuario_ja_membro): ?>

            <p>Você já participa desta liga.</p>

        <?php else: ?>

            <form method="post" action="ligas_detalhe.php?liga_id=<?php echo $liga_id; ?>">
                <p>
                    <label for="chave_entrada">Palavra-chave da liga:</label><br>
                    <input type="text" id="chave_entrada" name="chave_entrada">
                </p>
                <p>
                    <button type="submit">Entrar na liga</button>
                </p>
            </form>

        <?php endif; ?>

        <h2>Ranking de usuários da liga</h2>

        <?php if (count($ranking_usuarios) === 0): ?>

            <p>Nenhum usuário encontrado nesta liga.</p>

        <?php else: ?>

            <table border="1" cellpadding="8" cellspacing="0">
                <thead>
                    <tr>
                        <th>Posição</th>
                        <th>Usuário</th>
                        <th>Pontos na liga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $posicao = 1;
                    foreach ($ranking_usuarios as $linha):
                        $nome_usuario = $linha['nome_usuario'];
                        $pontos_liga  = (int) $linha['pontos_liga'];
                    ?>
                        <tr>
                            <td><?php echo $posicao; ?>º</td>
                            <td><?php echo htmlspecialchars($nome_usuario); ?></td>
                            <td><?php echo $pontos_liga; ?></td>
                        </tr>
                    <?php
                        $posicao++;
                    endforeach;
                    ?>
                </tbody>
            </table>

        <?php endif; ?>

    <?php endif; ?>

    <p>
        <button type="button" onclick="window.location.href='ligas.php'">
            Voltar para ligas
        </button>

        <button type="button" onclick="window.location.href='index.php'">
            Voltar ao menu
        </button>
    </p>

</body>

</html>