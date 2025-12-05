const palavras = 'habilidade capaz sobre acima aceitar segundo conta atraves agir acao atividade realmente adicionar endereco administracao admitir adulto afetar depois novamente contra idade agencia agente atras concordar acordo adiante ar todo permitir quase sozinho longo ja tambem embora sempre americano entre quantia analise e animal outro resposta qualquer alguem qualquercoisa aparecer aplicar abordagem area argumentar braco redor chegar arte artigo artista como perguntar assumir em ataque atencao advogado publico autor autoridade disponivel evitar longe bebe costas ruim bolsa bola banco bar base ser bater bonito porque tornar cama antes comecar comportamento atras acreditar beneficio melhor melhor entre alem grande conta bilhao pouco preto sangue azul conselho corpo livro nascido ambos caixa garoto quebrar trazer irmao orcamento construir predio negocio mas comprar por chamar camera campanha pode cancer candidato capital carro cartao cuidar carreira carregar caso pegar causa celula centro central seculo certo certamente cadeira desafio chance mudanca carater cobrar checar crianca escolha escolher igreja cidadao cidade civil alegar classe claro claramente fechar tecnico frio colecao faculdade cor vir comercial comum comunidade companhia comparar computador preocupacao condicao conferencia congresso considerar consumidor conter continuar controle custo poderia pais casal curso tribunal cobrir criar crime cultural cultura copo atual cliente cortar escuro dados filha dia morto lidar morte debate decada decidir decisao profundo defesa grau democrata democratico descrever design apesar detalhe determinar desenvolver desenvolvimento morrer diferenca diferente dificil jantar direcao diretor descobrir discutir discussao doenca fazer medico cachorro porta abaixo desenhar sonho dirigir cair droga durante cada cedo leste facil comer economico economia borda educacao efeito esforco oito qualquerum eleicao outro empregado fim energia aproveitar suficiente entrar inteiro ambiente ambiental especialmente estabelecer ate noite evento sempre todo todomundo todos tudo evidencia exatamente exemplo executivo existir esperar experiencia perito explicar olho rosto fato fator falhar familia longe rapido pai medo federal sentir sentimento poucos campo lutar figura encher filme final finalmente financeiro achar bem dedo terminar fogo firma primeiro peixe cinco chao voar foco seguir comida pe para forca estrangeiro esquecer forma antigo frente quatro livre amigo de frente cheio fundo futuro jogo jardim gas geral geracao obter garota dar ir objetivo bom governo grande verde grupo crescer crescimento adivinhar arma cara cabelo metade mao acontecer feliz duro ter ele cabeca saude ouvir coracao calor pesado ajudar ela aqui ela mesmo alto historia acerto segurar casa esperar hospital quente hotel hora como contudo enorme humano cento marido ideia identificar imagem imaginar impacto importante melhorar incluir incluindo aumentar realmente indicar individual industria informacao dentro vez instituicao interesse interessante internacional entrevista investimento envolver questao item trabalho unir apenas manter chave garoto matar tipo saber conhecimento terra idioma ultimo tarde depois rir lei colocar liderar lider aprender menos sair esquerda perna legal deixar carta nivel vida luz gostar provavel linha lista ouvir pouco viver local longo olhar perder perda muito amor baixo maquina revista principal manter maioria homem gerenciar muitos mercado casamento material questao talvez eu significar medida midia encontrar encontro membro memoria mencionar mensagem metodo meio militar milhao mente minuto missao modelo moderno momento dinheiro mes mais manha mae boca mover movimento filme muito musica meu mesmo nome nacao nacional natural perto quase necessario precisar rede nunca novo noticias jornal proximo noite nao nenhum norte nota nada notar agora numero ocorrer fora oferecer escritorio oficial frequente oleo velho umavez so abrir operacao oportunidade opcao ordem organizacao outro outros nosso lado sobre proprio dono pagina dor papel parte participante particular parceiro partido passar passado paciente padrao pagar paz pessoas desempenho talvez periodo pessoa pessoal telefone fisico escolher imagem peca lugar plano planta jogar jogador ponto politica pobre popular populacao posicao positivo possivel poder pratica preparar presente presidente pressao prevenir preco privado provavelmente problema processo produzir produto producao profissional professor programa propriedade proteger provar fornecer publico puxar proposito empurrar colocar qualidade pergunta rapidamente raca radio aumentar taxa ler pronto real realidade perceber realmente razao receber recente reconhecer registro vermelho reduzir refletir regiao relacionar relacao religioso permanecer lembrar remover relatorio representar requerer pesquisa recurso responder resposta responsabilidade descanso resultado retornar revelar rico direito risco estrada rocha papel quarto regra correr seguro mesmo salvar dizer cena escola ciencia cientista pontuacao mar estacao assento segundo secao seguranca ver buscar parecer vender enviar sentido serie serio servir servico definir sete varios sexo sacudir compartilhar atirar curto tiro ombro mostrar lado sinal significativo similar simples simplesmente desde cantar unico irma sentar situacao seis tamanho habilidade pele pequeno sorriso entao social sociedade soldado algum alguem alguem alguma coisa vezes filho musica tipo som fonte sul espaco falar especial especifico discurso gastar esporte primavera equipe estagio ficar padrao estrela comecar estado declaracao ficar passo ainda acao parar loja historia estrategia rua forte estrutura estudante estudo estilo assunto sucesso repentino sofrer sugerir verao apoio certo superficie sistema tabela tarefa imposto ensinar professor tecnologia televisao contar dez termo teste aquele agradecer deles entao teoria la estes coisa pensar terceiro isto aqueles embora pensamento mil ameaca atraves jogar fora assim tempo hoje juntos topo total duro cidade comercio tradicional treinamento viagem tratar tratamento arvore julgamento problema verdadeiro verdade tentar virar dois tipo entender unidade ate cima valor varios vitima visao violencia visitar voz voto esperar andar parede querer guerra assistir agua caminho arma usar semana peso oeste oque quando onde qual enquanto branco quem todo cujo porque amplo esposa vencer vento janela desejar dentro sem mulher palavra trabalho trabalhador mundo preocupar escrever escritor errado quintal ano ainda voce jovem'.split(' ');

const tempoJogo = 30 * 1000;
window.timer = null;
window.incicioJogo = null;


function adicionarClasse(elemento, nomeClasse) {
    elemento.className += ' ' + nomeClasse;
}

function removerClasse(elemento, nomeClasse) {
    elemento.className = elemento.className.replace(nomeClasse, '');
}

function palavraAleatoria() {
    return palavras[Math.floor(Math.random() * palavras.length)];
}

function formatarPalavra(palavra) {
    return `<div class="palavra"><span class="letra">${palavra.split('').join('</span><span class="letra">')}</span></div>`;
}

//iniciar novo jogo  
function novoJogo() {
    const container = document.getElementById('palavras');
    container.innerHTML = '';
    container.style.marginTop = '0px';

    for (let i = 0; i < 200; i++) {
        container.innerHTML += formatarPalavra(palavraAleatoria());
    }

    adicionarClasse(document.querySelector('.palavra'), 'current');
    adicionarClasse(document.querySelector('.letra'), 'current');

    document.getElementById('info').innerHTML =
        'Você tem ⭢ <span class="tempo-numero">' +
        (tempoJogo / 1000) +
        '</span> segundos';

    window.timer = null;
    window.incicioJogo = null;

    removerClasse(document.getElementById('jogo'), 'fim');
}

//calculando palavras por min   
function palavrasPorMinuto() {
    const palavrasDOM = [...document.querySelectorAll('.palavra')];
    const ultima = document.querySelector('.palavra.current');
    const index = palavrasDOM.indexOf(ultima) + 1;
    const digitadas = palavrasDOM.slice(0, index);

    const corretas = digitadas.filter(palavra => {
        const letras = [...palavra.children];
        const incorretas = letras.filter(l => l.className.includes('incorreta'));
        const certas = letras.filter(l => l.className.includes('correta'));
        return incorretas.length === 0 && certas.length === letras.length;
    });

    return corretas.length / tempoJogo * 60000;
}

//fim de jogo 
function fimJogo() {
    clearInterval(window.timer);
    adicionarClasse(document.getElementById('jogo'), 'fim');

    const resultado = palavrasPorMinuto();
    const wpm = Math.round(resultado);

    const inputPontuacao = document.getElementById('pontuacao');
    const formPontuacao = document.getElementById('formPontuacao');

    inputPontuacao.value = wpm;
    formPontuacao.submit();

}

//Capturando as teclas digitadas
document.getElementById('jogo').addEventListener('keyup', ev => {
    const key = ev.key;
    const currentPalavra = document.querySelector('.palavra.current');
    const currentLetra = document.querySelector('.letra.current');
    const esperada = currentLetra.innerHTML;
    const isLetra = key.length === 1 && key !== ' ';
    const isEspaco = key === ' ';

    if (document.querySelector('#jogo.fim')) return;

    document.getElementById('botaoNovoJogo').style.display = 'inline-block';
    document.getElementById('botaoNovoJogo').textContent = 'Reiniciar Jogo';


    //temporizador
    if (!window.timer && isLetra) {
        window.timer = setInterval(() => {
            if (!window.incicioJogo) {
                window.incicioJogo = new Date().getTime();
            }
            const atual = new Date().getTime();
            const ms = atual - window.incicioJogo;
            const segPassou = Math.round(ms / 1000);
            const segRestante = tempoJogo / 1000 - segPassou;

            if (segRestante <= 0) {
                fimJogo();
                return;
            }

            //exibindo os segundos restantes com uma class pra poder estilizar
            document.getElementById('info').innerHTML =
                'Tempo restante ⭢ <span class="tempo-numero">' +
                segRestante +
                '</span> segundos';

        }, 1000);
    }

    //quando digitam uma letra
    if (isLetra) {

        const resolvida =
            currentLetra.classList.contains('correta') ||
            currentLetra.classList.contains('incorreta');

        if (resolvida) return;

        if (key === esperada) {
            const errouAntes = currentLetra.dataset.errou === "true";
            if (errouAntes) {
                adicionarClasse(currentLetra, 'incorreta');
            } else {
                adicionarClasse(currentLetra, 'correta');
            }

            removerClasse(currentLetra, 'current');

            const prox = currentLetra.nextSibling;
            adicionarClasse(prox && prox.classList.contains("letra") ? prox : currentLetra, "current");

        } else {
            currentLetra.dataset.errou = "true";
        }

        return;
    }

    //quando digitam um espaço
    if (isEspaco) {
        const proxLetra = currentLetra.nextElementSibling;
        if (proxLetra && proxLetra.classList.contains("letra")) return;

        const finalizada =
            currentLetra.classList.contains('correta') ||
            currentLetra.classList.contains('incorreta');

        if (!finalizada) return;

        const proxPalavra = currentPalavra.nextElementSibling;
        if (!proxPalavra || !proxPalavra.classList.contains('palavra')) return;

        removerClasse(currentPalavra, "current");
        adicionarClasse(proxPalavra, "current");

        removerClasse(currentLetra, "current");
        const primeiraL = proxPalavra.querySelector('.letra');
        adicionarClasse(primeiraL, "current");
        delete primeiraL.dataset.errou;


        //scrol das palavras
        const jogo = document.getElementById('jogo');
        const topoJogo = jogo.getBoundingClientRect().top;
        const limite = topoJogo + 70;

        const topoPalavra = currentPalavra.getBoundingClientRect().top;

        if (topoPalavra > limite) {
            const palavrasDiv = document.getElementById('palavras');
            const marginAtual = parseInt(palavrasDiv.style.marginTop || '0', 10);
            palavrasDiv.style.marginTop = (marginAtual - 35) + 'px';
        }

        return;
    }
});

//botões
document.getElementById('botaoNovoJogo').addEventListener('click', () => {
    clearInterval(window.timer);
    window.timer = null;
    window.incicioJogo = null;
    removerClasse(document.getElementById('jogo'), 'fim');
    novoJogo();
});

//não iniciar automatico se acabaou de receber o post 
if (typeof teveResultado === 'undefined' || !teveResultado) {
    // o normal é- entra na página sem ter acabado de jogar
    novoJogo();
} else {
    // acabou de jogar e voltou do redirect: mostrar botão "Novo Jogo"
    const botaoNovo = document.getElementById('botaoNovoJogo');
    if (botaoNovo) {
        botaoNovo.style.display = 'inline-block';
        botaoNovo.textContent = 'Novo Jogo';
    }
}

