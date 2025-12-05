document.addEventListener('DOMContentLoaded', function () {

    //REGISTER
    const formRegister = document.getElementById('formRegister');
    if (formRegister) {
        formRegister.addEventListener('submit', function () {
            const nome = formRegister.nome.value.trim();
            const email = formRegister.email.value.trim();
            const senha = formRegister.senha.value;
            const conf = formRegister.confirmar_senha.value;

            const resultado = {
                nomePreenchido: !!nome,
                emailPreenchido: !!email,
                senhaPreenchida: !!senha,
                confirmaPreenchida: !!conf,
                senhaConfere: senha === conf
            };

            console.log('Validação (REGISTER) - front end:', resultado);
        });
    }

    //LOGIN
    const formLogin = document.getElementById('formLogin');
    if (formLogin) {
        formLogin.addEventListener('submit', function () {
            const email = formLogin.email.value.trim();
            const senha = formLogin.senha.value.trim();

            const resultado = {
                emailPreenchido: !!email,
                senhaPreenchida: !!senha
            };

            console.log('Validação (LOGIN) front end:', resultado);
        });
    }

    //CRIACAO DE LIGA
    const formCriarLiga = document.getElementById('formCriarLiga');
    if (formCriarLiga) {
        formCriarLiga.addEventListener('submit', function () {
            const nomeLiga = formCriarLiga.nome_liga.value.trim();
            const chave = formCriarLiga.chave_entrada.value.trim();

            const resultado = {
                nomeLigaPreenchido: !!nomeLiga,
                chavePreenchida: !!chave
            };

            console.log('Validação (LIGAS) front end:', resultado);
        });
    }

    //detalhes das ligas
    const formEntrarLiga = document.getElementById('formEntrarLiga');
    if (formEntrarLiga) {
        formEntrarLiga.addEventListener('submit', function () {
            const chave = formEntrarLiga.chave_entrada.value.trim();

            const resultado = {
                chavePreenchida: !!chave
            };

            console.log('Validação (DETALHES LIGAS) front end:', resultado);
        });
    }

});
