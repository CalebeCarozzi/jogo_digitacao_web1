# Jogo de Digitação – DS122

## 0. Autores

- **Calebe Rodrigues Carozzi**
- **Rafael Blaskowski Demeterko**

Projeto desenvolvido para a disciplina **DS122 – Desenvolvimento de Aplicações Web 1**.

---

Aplicação web em **PHP**, **JavaScript**, **HTML** e **CSS** que implementa um jogo de digitação com sistema de pontuação, histórico de partidas, ranking global e ligas entre jogadores.

A ideia é simples: o usuário se cadastra, faz login, joga partidas de digitação, acumula pontos e pode comparar seu desempenho com outros jogadores (geral e por ligas).

---

## 1. Visão geral do sistema

Depois de autenticado, o usuário tem acesso a um **menu principal** com as seguintes opções:

- **Jogar** – abre o jogo de digitação.
- **Histórico de partidas** – mostra todas as partidas que ele já jogou.
- **Ranking de jogadores** – mostra o ranking geral de todos os usuários do sistema.
- **Ligas** – onde é possível criar ligas, entrar em ligas e ver a pontuação delas.

Todo o registro de contas, pontuações, ligas e membros de ligas é salvo em banco de dados (MySQL/MariaDB).

---

## 2. Telas principais e funcionamento

### 2.1. Login e cadastro

- **Cadastro (register.php)**  
  - Usuário informa **nome**, **e-mail** e **senha**.  
  - Os campos são validados (tanto em PHP quanto em JavaScript).  
  - A senha é salva no banco como **hash**, não em texto puro.  
  - Se o e-mail já existir, é exibida uma mensagem de erro.

- **Login (login.php)**  
  - Usuário informa **e-mail** e **senha**.  
  - O sistema confere as credenciais no banco.  
  - Em caso de sucesso, o ID e o nome do usuário são guardados na sessão.  
  - Em caso de erro, uma mensagem simples é exibida (e a senha não é mostrada em lugar nenhum).

- **Acesso restrito**  
  - Páginas como *game.php*, *history.php*, *ranking_jogadores.php*, *ligas.php* e *ligas_detalhe.php* só podem ser acessadas por usuários logados.  
  - Isso é controlado por um arquivo de proteção chamado `force_authenticate.php`, que redireciona para o login se não houver usuário na sessão.

---

### 2.2. Menu principal (index.php)

Depois do login, o usuário cai na tela inicial, que:

- Mostra **botões** para:
  - Iniciar o jogo de digitação.
  - Ver o histórico de partidas.
  - Abrir o ranking global.
  - Acessar a parte de ligas.
  - Fazer logout.

Essa tela é mais de navegação mesmo, para encaminhar o usuário para as outras funções.

---

### 2.3. Jogo de Digitação (game.php + `JS/jogo_digitacao.js`)

- O jogo é todo feito em **JavaScript**, como exigido na disciplina.
- Ao entrar na tela:
  - É exibido um bloco com **várias palavras aleatórias**.
  - O usuário clica na área do jogo e começa a digitar.
- Funcionamento básico:
  - Um **temporizador** conta o tempo da partida (30 segundos).
  - A cada tecla digitada, o script confere se a letra está correta:
    - Letras corretas ganham uma cor específica.
    - Letras erradas ganham outra cor.
  - Quando o tempo acaba, o jogo:
    - Conta quantas palavras foram digitadas **corretamente**.
    - Calcula **palavras por minuto (WPM)**.
    - Converte esse WPM em **pontos**, usando uma tabela de faixas.
    - Envia os dados (WPM e pontos) para o PHP, que grava no banco na tabela `partidas`.

Toda a lógica visual (cores, foco, movimentação das palavras) é tratada no JavaScript e estilizada em CSS.

---

### 2.4. Histórico de Partidas (history.php)

Essa tela é focada apenas no usuário logado.

- Mostra:
  - **Nome do usuário** (no topo).
  - Uma **tabela** com todas as partidas dele, ordenadas da mais recente para a mais antiga.
- Para cada partida são exibidos:
  - Número da partida (1, 2, 3…).
  - **Data** (formato dia/mês/ano).
  - **Hora** da partida.
  - **Palavras por minuto (WPM)**.
  - **Pontuação** daquela partida.

No final da página, há um pequeno **resumo** com:

- Total de partidas jogadas.
- Soma total de pontos.
- Soma de pontos na última semana (considerando os últimos 7 dias).
- Recorde de palavras por minuto (maior WPM já alcançado pelo usuário).

Se o usuário ainda não jogou nenhuma partida, a tela só mostra uma mensagem do tipo “Você ainda não jogou nenhuma partida” e um botão para ir direto ao jogo e outro para voltar para o menu inicial.

---

### 2.5. Ranking de Jogadores (ranking_jogadores.php)

Aqui aparece a competição geral entre todos os usuários do sistema.

A tela exibe:

- Uma tabela com:
  - **Posição** no ranking (1º, 2º, 3º…).
  - **Nome do usuário**.
  - **Recorde de WPM** (maior valor de WPM entre as partidas daquela pessoa).
  - **Pontos na última semana** (somando as partidas dos últimos 7 dias).
  - **Pontos totais** (somando todas as partidas já feitas).

- Há **botões de filtro** para mudar a ordenação da tabela:
  - Ordenar por recorde de WPM.
  - Ordenar por pontos da semana.
  - Ordenar por pontos totais.

- Destaques visuais:
  - O **top 3** fica com estilo diferenciado (por exemplo, cores de ouro, prata, bronze).
  - O **usuário logado** aparece destacado na tabela, mesmo que não esteja no top 3.

---

### 2.6. Ligas (ligas.php)

As ligas são grupos de usuários que competem entre si dentro do sistema.

Na tela de ligas temos duas áreas principais:

#### (a) Lista / ranking de ligas

Uma tabela que mostra **todas as ligas cadastradas** no sistema, com:

- **Posição** da liga (1ª, 2ª, 3ª…), conforme o critério de ordenação.
- **Nome da liga**.
- **Pontos na última semana da liga**.
- **Pontos totais da liga**.
- Um botão **“Ver liga”**, que leva para a tela de detalhes da liga.

Os pontos da liga são calculados assim:

- **Pontos totais da liga**:  
  soma de todos os pontos das partidas dos membros **a partir do momento em que cada usuário entrou na liga**.
- **Pontos na semana da liga**:  
  mesma ideia, mas considerando apenas as partidas dos últimos 7 dias.

Ou seja, se o usuário entrou hoje na liga, as partidas que ele jogou antes não contam para aquela liga.

Também existem botões para **ordenar** as ligas:

- Por pontos totais.
- Por pontos na última semana.

E a liga em que o usuário está pode aparecer com uma classe especial para ser destacada no CSS.

#### (b) Formulário de criação de liga

Na mesma página, há um formulário simples para **criar uma nova liga**, com:

- Campo **Nome da liga** (obrigatório e único).
- Campo **Palavra-chave** (obrigatório), usada para que outros jogadores consigam entrar nessa liga.
- Botão **Criar liga**.

Funcionamento:

- O sistema verifica:
  - Se os campos não estão vazios.
  - Se não existe outra liga com o mesmo nome.
- Se estiver tudo certo:
  - Insere a nova liga na tabela de ligas.
  - Automaticamente adiciona o usuário criador como **membro** dessa liga.
  - Mostra uma mensagem de sucesso e atualiza a lista.

---

### 2.7. Detalhe da Liga (ligas_detalhe.php)

Essa tela é aberta quando o usuário clica em **“Ver liga”** na lista de ligas.

Ela mostra:

- **Nome da liga**.
- **Nome do dono da liga**.
- **Data de criação**.
- **Pontos totais da liga** (somando os pontos dos membros desde que cada um entrou na liga).
- **Pontos na última semana da liga** (também só considerando partidas feitas depois da entrada na liga).

Além disso, aparece um pequeno **ranking dos usuários daquela liga**:

- Posição na liga.
- Nome do usuário.
- Pontos acumulados **dentro da liga** (de novo, só valem as partidas a partir da data de entrada na liga).

#### Entrar na liga

Na parte de baixo (ou lateral), existe o formulário para entrar na liga:

- Se o usuário **já participa** da liga:
  - A tela mostra apenas uma mensagem:  
    **“Você já participa desta liga.”**
  - O formulário não aparece.

- Se o usuário **não for membro**:
  - Aparece o campo para digitar a **palavra-chave** da liga.
  - Se a palavra-chave estiver correta, o usuário é adicionado na tabela de membros daquela liga.
  - Se estiver errada ou vazia, são mostradas mensagens de erro simples, como:
    - “Palavra-chave inválida.”
    - “Campo obrigatório.”

Depois de entrar com sucesso, a página é recarregada e o usuário passa a ser considerado membro da liga.

---

## 3. Regras básicas de pontuação

- O jogo calcula **palavras por minuto (WPM)** a partir das palavras digitadas corretamente dentro do tempo.
- O WPM é convertido em **pontos** usando uma tabela de faixas (quanto maior o WPM, mais pontos).
- Sempre que o usuário termina uma partida:
  - Uma nova linha é inserida em `partidas` com:
    - ID do usuário,
    - WPM,
    - pontuação,
    - data e hora da partida.
- Todos os outros relatórios (histórico, ranking e ligas) usam esses registros para calcular:
  - Pontuação total.
  - Pontuação semanal.
  - Recordes.

---

## 4. Tecnologias utilizadas

| Tecnologia       | Uso principal                                   |
|------------------|--------------------------------------------------|
| **PHP**          | Back-end, regras de negócio, acesso ao banco    |
| **MySQL/MariaDB**| Armazenar usuários, partidas e ligas            |
| **JavaScript**   | Lógica do jogo, temporizador, feedback visual   |
| **HTML5**        | Estrutura das páginas                           |
| **CSS3**         | Layout, tema escuro e estilos de tabelas/botões |

---

## 5. Banco de dados (visão simples)

O sistema utiliza quatro tabelas principais:

- **usuarios**  
  Guarda os dados de login:
  - id, nome, email, hash da senha, data de criação.

- **partidas**  
  Registra cada partida jogada:
  - id, usuario_id, wpm, pontuacao, data_partida.

- **ligas**  
  Controla as ligas criadas:
  - id, nome, chave_entrada, dono_id, data_criacao.

- **ligas_membros**  
  Liga usuários às ligas:
  - id, liga_id, usuario_id, data_entrada.

As consultas ao banco usam esses dados para montar o histórico, os rankings e as estatísticas de cada liga.

---



