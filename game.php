<?php
require_once 'force_authenticate.php';
require_once 'functions_db.php';

$mensagem_erro = '';
$wpm_atual = null;
$pontos_atual = null;

function calcular_pontos_por_wpm(int $wpm): int
{
    if ($wpm <= 0) {
        return 0;            
    }
    if ($wpm < 20) return 10;
    elseif ($wpm < 25) return 15;
    elseif ($wpm < 30) return 25;
    elseif ($wpm < 35) return 40;
    elseif ($wpm < 40) return 60;
    elseif ($wpm < 45) return 85;
    elseif ($wpm < 50) return 115;
    elseif ($wpm < 55) return 150;
    elseif ($wpm < 60) return 190;
    elseif ($wpm < 65) return 235;
    elseif ($wpm < 70) return 285;
    elseif ($wpm < 75) return 340;
    else return 400;
}

if (isset($_SESSION['ultimo_wpm']) && isset($_SESSION['ultimo_pontos'])) {
    $wpm_atual = $_SESSION['ultimo_wpm'];
    $pontos_atual = $_SESSION['ultimo_pontos'];

    unset($_SESSION['ultimo_wpm'], $_SESSION['ultimo_pontos']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pontuacao'])) {

    $wpm = max(0, (int) $_POST['pontuacao']);

    if (!isset($_SESSION['user_id'])) {
        $mensagem_erro = "Sessão expirada. Faça login novamente.";
    } else {
        $usuario_id = (int) $_SESSION['user_id'];

        $conn = connect_db();
        if (!$conn) {
            $mensagem_erro = "Erro ao conectar ao banco.";
        } else {
            $sql_user = "SELECT id FROM usuarios WHERE id = $usuario_id";
            $res = mysqli_query($conn, $sql_user);

            if ($res && mysqli_num_rows($res) === 1) {

                $pontos = calcular_pontos_por_wpm($wpm);

                $sql_insert = "INSERT INTO partidas (usuario_id, wpm, pontuacao)
                               VALUES ($usuario_id, $wpm, $pontos)";

                if (!mysqli_query($conn, $sql_insert)) {
                    $mensagem_erro = "Erro ao salvar: " . mysqli_error($conn);
                } else {
//aqui pedi ajuda de IA para ver como poderia fazer para que não houvesse reenvio do form com o resultado do jogo ao dar refresh
//a solução foi o metodo POST - redirect - GET  --> faz o post e dpois redirect com get dai não tem form case de f5                    
                    $_SESSION['ultimo_wpm'] = $wpm;
                    $_SESSION['ultimo_pontos'] = $pontos;

                    header('Location: game.php');
                    exit;
                }
            } else {
                $mensagem_erro = "Usuário não encontrado.";
            }

            close_db($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jogo Digitação - Web 1</title>
    <link rel="stylesheet" href="CSS/styleGame.css">
</head>

<body>

    <header class="cabecalho-pagina">
        <h1>Jogo Digitação - Web 1</h1>
        <p>Digite o máximo de palavras corretas antes do tempo acabar.</p>
    </header>

    <main>

        <?php if (!empty($mensagem_erro)) : ?>
            <p style="color:red ;text-align:center;"><?php echo $mensagem_erro; ?></p>
        <?php endif; ?>

        <form id="formPontuacao" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

            <section class="secao-jogo">

                <div class="linha-tempo">
                    <span id="info">
                        <?php if ($wpm_atual !== null): ?>
                            <div class="titulo-pontuacao">PONTUAÇÃO</div>
                            <div class="pontuacao-valor"><?php echo $wpm_atual; ?> WPM</div>
                            <div class="pontuacao-texto">
                                Você fez <strong><?php echo $wpm_atual; ?></strong> palavras por minuto!
                            </div>
                            <?php if ($pontos_atual !== null): ?>
                                <div class="pontuacao-texto">
                                    Pontos calculados: <strong><?php echo $pontos_atual; ?></strong>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </span>
                </div>

                <div id="jogo" tabindex="0">
                    <div id="palavras"></div>
                </div>

                <p class="msg-ajuda-inicial">
                    Clique no quadro de palavras e comece a digitar para o tempo começar a contar.
                </p>

                <input type="hidden" name="pontuacao" id="pontuacao" value="">

                <div class="botoes-jogo">
                    <button type="button" id="botaoNovoJogo" style="display: none;">Novo Jogo</button>
                    <button type="button" id="botaoVoltarMenu" onclick="window.location.href='index.php'">
                        Voltar para o menu
                    </button>
                </div>

            </section>

        </form>
    </main>

    <script>
        const teveResultado = <?php echo $wpm_atual !== null ? 'true' : 'false'; ?>;
    </script>

    <script src="JS/jogo_digitacao.js"></script>

</body>

</html>

