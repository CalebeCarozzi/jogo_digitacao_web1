const palavras = 'ability able about above accept according account across act action activity actually add address administration admit adult affect after again against age agency agent ago agree agreement ahead air all allow almost alone along already also although always american among amount analysis and animal another answer any anyone anything appear apply approach area argue arm around arrive art article artist as ask assume at attack attention attorney audience author authority available avoid away baby back bad bag ball bank bar base be beat beautiful because become bed before begin behavior behind believe benefit best better between beyond big bill billion bit black blood blue board body book born both box boy break bring brother budget build building business but buy by call camera campaign can cancer candidate capital car card care career carry case catch cause cell center central century certain certainly chair challenge chance change character charge check child choice choose church citizen city civil claim class clear clearly close coach cold collection college color come commercial common community company compare computer concern condition conference congress consider consumer contain continue control cost could country couple course court cover create crime cultural culture cup current customer cut dark data daughter day dead deal death debate decade decide decision deep defense degree Democrat democratic describe design despite detail determine develop development die difference different difficult dinner direction director discover discuss discussion disease do doctor dog door down draw dream drive drop drug during each early east easy eat economic economy edge education effect effort eight either election else employee end energy enjoy enough enter entire environment environmental especially establish even evening event ever every everybody everyone everything evidence exactly example executive exist expect experience expert explain eye face fact factor fail fall family far fast father fear federal feel feeling few field fight figure fill film final finally financial find fine finger finish fire firm first fish five floor fly focus follow food foot for force foreign forget form former forward four free friend from front full fund future game garden gas general generation get girl give glass go goal good government great green ground group grow growth guess gun guy hair half hand hang happen happy hard have he head health hear heart heat heavy help her here herself high him himself his history hit hold home hope hospital hot hotel hour house how however huge human hundred husband I idea identify if image imagine impact important improve in include including increase indeed indicate individual industry information inside instead institution interest interesting international interview into investment involve issue it item its itself job join just keep key kid kill kind kitchen know knowledge land language large last late later laugh law lawyer lay lead leader learn least leave left leg legal less let letter level lie life light like likely line list listen little live local long look lose loss lot love low machine magazine main maintain major majority make man manage management manager many market marriage material matter may maybe me mean measure media medical meet meeting member memory mention message method middle might military million mind minute miss mission model modern moment money month more morning most mother mouth move movement movie mr mrs much music must my myself name nation national natural near nearly necessary need network never new news newspaper next nice night no none nor north not note nothing notice now number occur of off offer office officer official often oh oil ok old on once one only onto open operation opportunity option or order organization other others our out outside over own owner page pain painting paper parent part participant particular particularly partner party pass past patient pattern pay peace people per perform performance perhaps period person personal phone physical pick picture piece place plan plant play player point police policy political politics poor popular population position positive possible power practice prepare present president pressure pretty prevent price private probably problem process produce product production professional professor program property protect prove provide public pull purpose push put quality question quickly quite race radio raise range rate rather reach read ready real reality realize really reason receive recent recently recognize record red reduce reflect region relate relationship religious remain remember remove report represent Republican require research resource respond response responsibility rest result return reveal rich right rise risk road rock role room rule run safe same save say scene school science scientist score sea season seat second section security see seek seem sell send senior sense series serious serve service set seven several sex sexual shake share she shoot short shot should shoulder show side sign significant similar simple simply since sing single sister sit site situation six size skill skin small smile so social society soldier some somebody someone something sometimes son song soon sort sound source south southern space speak special specific speech spend sport spring staff stage stand standard star start state statement station stay step still stock stop store story strategy street strong structure student study stuff style subject success successful such suddenly suffer suggest summer support sure surface system table take talk task tax teach teacher team technology television tell ten tend term test than thank that the their them themselves then theory there these they thing think third this those though thought thousand threat three through throughout throw thus time to today together tonight too top total tough toward town trade traditional training travel treat treatment tree trial trip trouble true truth try turn TV two type under understand unit until up upon us use usually value various very victim view violence visit voice vote wait walk wall want war watch water way we weapon wear week weight well west western what whatever when where whether which while white who whole whom whose why wide wife will win wind window wish with within without woman wonder word work worker world worry would write writer wrong yard yeah year yes yet you young your yourself'.split(' ');

const tempoJogo = 5 * 1000;
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
            adicionarClasse(currentLetra, errouAntes ? 'incorreta' : 'correta');

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

