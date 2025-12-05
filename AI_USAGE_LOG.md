# Relatório de Uso de Inteligência Artificial Generativa

Este documento registra as interações significativas com ferramentas de IA generativa durante o desenvolvimento deste projeto. O objetivo é promover o uso ético e transparente da IA como *ferramenta de apoio ao aprendizado*, e não como substituta para o estudo de programação, fundamentos de web e banco de dados.

## Política de Uso

O uso de IA foi permitido para as seguintes finalidades:
- Esclarecimento de dúvidas conceituais sobre HTML, CSS, JavaScript, PHP e banco de dados.
- Sugestões de padrões de layout, cores e organização visual de telas.
- Exemplos genéricos de estruturas de código para fins didáticos.
- Revisão de ideias já implementadas, apontando possíveis melhorias.
- Apoio na escrita de documentação em Markdown.

Não foi permitido:
- Copiar trechos de código sem entender o funcionamento.
- Utilizar respostas da IA como substituto para o estudo de materiais da disciplina.
- Delegar decisões de arquitetura e regras de negócio à IA.

---

## Registro de Interações

---

## Interação 1 — Organização visual do menu inicial

- *Data:* 04/12/2025  
- *Etapa do Projeto:* Organização visual do menu inicial  
- *Ferramenta de IA Utilizada:* Chat  
- *Objetivo da Consulta:* Entender formas de posicionar informações do usuário logado (nome e logout) em um banner no topo da página, mantendo consistência com o restante do layout.

- *Resumo da Resposta da IA:*  
  A IA explicou conceitos de posicionamento em CSS (uso de containers fixos, alinhamento, espaçamentos, reaproveitamento de paleta de cores) e sugeriu uma estrutura de classes para separar responsabilidade entre banner, nome do usuário e botão de saída.

- *Análise e Aplicação:*  
  As orientações ajudaram a reorganizar o HTML e CSS da página inicial e aprofundar o entendimento de hierarquia visual.

- *Referência no Código:*  
  Arquivo `index.php` e folhas de estilo associadas (`styleind.css`).

---

## Interação 2 — Estruturação da tabela de histórico com rolagem

- *Data:* 04/12/2025  
- *Etapa do Projeto:* Tela de histórico de partidas  
- *Ferramenta de IA Utilizada:* Chat  
- *Objetivo da Consulta:* Aprender como montar uma tabela com rolagem interna, cabeçalho fixo e card de resumo em tema escuro.

- *Resumo da Resposta da IA:*  
  A IA explicou como usar `overflow-y`, `position: sticky` e conceitos de contraste de cores para melhorar a legibilidade e organização do conteúdo.

- *Análise e Aplicação:*  
  Ajudou a compor o card central e a tabela fixa da página de histórico.

- *Referência no Código:*  
  Arquivos como `history.php, ranking_usuarios e ligas` e folha de estilo `stylehistory.css`.

---

## Interação 3 — Destaque visual do ranking geral

- *Data:* 04/12/2025  
- *Etapa do Projeto:* Tela de ranking de jogadores  
- *Ferramenta de IA Utilizada:* Chat  
- *Objetivo da Consulta:* Receber sugestões para destacar o top 3 e o usuário logado dentro da tabela.

- *Resumo da Resposta da IA:*  
  A IA sugeriu classes específicas para 1º, 2º e 3º, além de variações sutis de cor para realçar a linha do usuário logado.

- *Análise e Aplicação:*  
  As sugestões ajudaram a compor a tabela final, melhorando hierarquia e leitura.

- *Referência no Código:*  
  Arquivo `ranking_jogadores.php` e folha de estilo `styleranking.css`.  asd

---

## Interação 4 — Layout da tela de ligas com Grid/Flex

- *Data:* 04–05/12/2025  
- *Etapa do Projeto:* Tela de listagem e criação de ligas  
- *Ferramenta de IA Utilizada:* Chat  
- *Objetivo da Consulta:* Entender como dividir a tela em duas colunas (lista e formulário) com Grid/Flex e padronizar o estilo das tabelas.

- *Resumo da Resposta da IA:*  
  Explicou diferentes estratégias de grid e responsividade, além de propor padrões visuais similares ao ranking geral.

- *Análise e Aplicação:*  
  Ajudou a manter unidade visual entre telas e organizar os elementos da tela de ligas.

- *Referência no Código:*  
  Arquivo `ligas.php` e folha de estilo `styleligas.css`.

---

## Interação 5 — Hierarquia visual na tela de detalhes da liga

- *Data:* 05/12/2025  
- *Etapa do Projeto:* Tela de detalhes de uma liga  
- *Ferramenta de IA Utilizada:* Chat  
- *Objetivo da Consulta:* Estruturar visualmente as seções de informações da liga, formulário de entrada e ranking interno.

- *Resumo da Resposta da IA:*  
  A IA sugeriu separar blocos visuais com leves variações de fundo e espaçamento para criar hierarquia clara de leitura.

- *Análise e Aplicação:*  
  Orientou a organização final da tela e alinhou as seções ao tema dark geral.

- *Referência no Código:*  
  Arquivo `ligas_detalhe.php` e folha de estilo `styleligas_detalhe.css`.

---

## Interação 6 — Criação de lista inicial de palavras do jogo

- *Data:* 05/12/2025  
- *Etapa do Projeto:* Conteúdo textual do jogo de digitação  
- *Ferramenta de IA Utilizada:* Chat  
- *Objetivo da Consulta:* Obter sugestões de palavras sem acento para prática de digitação.

- *Resumo da Resposta da IA:*  
  A IA forneceu várias palavras simples e sem acentuação, adequadas para manter o foco na digitação.

- *Análise e Aplicação:*  
  Serviu como inspiração inicial da lista final implementada.

- *Referência no Código:*  
  Arquivo `jogo_digitacao.js`, no array responsável pelo conjunto de palavras.

---

## Interação 7 — Estrutura de README em Markdown

- *Data:* 05/12/2025  
- *Etapa do Projeto:* Documentação do repositório (README)  
- *Ferramenta de IA Utilizada:* Chat  
- *Objetivo da Consulta:* Obter um modelo de README organizado e didático.

- *Resumo da Resposta da IA:*  
  A IA apresentou uma estrutura comum para documentação de projetos, com seções de descrição, execução e tecnologias.

- *Análise e Aplicação:*  
  Essa estrutura guiou a montagem do README final.

- *Referência no Código:*  
  Arquivo `README.md` no repositório.

---

(As próximas interações — 8, 9, 10, 11 e 12 — você já tem prontas no formato novo. Basta colar logo abaixo deste bloco.)



## Interação 8 — Validação de formulários em JavaScript (front-end)

- *Data:* 05/12/2025  
- *Etapa do Projeto:* Validação de formulários de login, registro e criação de ligas  
- *Ferramenta de IA Utilizada:* Chat GPT  
- *Objetivo da Consulta:* Esclarecer como implementar validação no front-end **sem exibir alertas**, sem pop-ups, sem mensagens duplicadas, deixando o PHP responsável pelas mensagens e mantendo a validação silenciosa no JS.

- *Resumo da Resposta da IA:*  
  A IA explicou como estruturar funções de validação que impedem o envio do formulário caso haja campos vazios ou inválidos, mas sem mostrar mensagens no navegador. A orientação focou em retornos booleanos e uso opcional de classes CSS ao invés de alertas invasivos.

- *Análise e Aplicação:*  
  Isso permitiu montar o arquivo `validacao_forms.js` com validações discretas, enquanto o PHP manteve a responsabilidade clara pelas mensagens exibidas ao usuário. Assim, a experiência ficou consistente e sem poluição visual.

- *Referência no Código:*  
  Arquivo `validacao_forms.js`, nas funções que verificam campos obrigatórios antes do envio dos formulários.
---

## Interação 9 — Uso de `usort()` para ordenação personalizada em PHP

- *Data:* 05/12/2025  
- *Etapa do Projeto:* Ordenação dinâmica da lista de ligas  
- *Ferramenta de IA Utilizada:* Chat GPT  
- *Objetivo da Consulta:* Entender como ordenar um array de ligas de acordo com diferentes critérios (pontuação total ou semanal), usando uma função de comparação personalizada.

- *Resumo da Resposta da IA:*  
  A IA explicou o funcionamento conceitual de `usort()`, como uma função de comparação deve retornar valores negativos/positivos e como alternar entre diferentes critérios sem modificar a consulta SQL.

- *Análise e Aplicação:*  
  Com a explicação foi possível implementar a ordenação flexível das ligas no PHP, fazendo com que a escolha de ordenação do usuário fosse aplicada diretamente no array carregado do banco. O código final foi escrito manualmente com base no conceito aprendido.

- *Referência no Código:*  
  Arquivo `ligas.php`, na parte responsável por ordenar o array `$ligas` após calcular as pontuações.
---

## Interação 10 — Consulta SQL com `CASE WHEN` e cálculo de pontuação semanal

- *Data:* 05/12/2025  
- *Etapa do Projeto:* Rankings geral e rankings internos das ligas  
- *Ferramenta de IA Utilizada:* Chat GPT  
- *Objetivo da Consulta:* Aprender como aplicar `CASE WHEN`, `COALESCE` e filtros temporais diretamente em consultas SQL para calcular pontuação semanal e total ao mesmo tempo.

- *Resumo da Resposta da IA:*  
  A IA explicou a utilidade de `CASE WHEN` dentro de `SUM()` para diferenciar pontuações por intervalo de tempo, além de esclarecer o uso de `COALESCE` para evitar valores nulos. Também discutiu por que isso simplifica ordenações posteriores.

- *Análise e Aplicação:*  
  As consultas finais foram escritas manualmente, mas baseadas na compreensão adquirida. Isso permitiu criar rankings mais consistentes, usando apenas uma query para obter tanto valores totais quanto semanais.

- *Referência no Código:*  
  Arquivo `ranking_jogadores.php` nas consultas onde pontuação total e semanal são calculadas simultaneamente.
---

## Interação 11 — Controle de “scroll visual” das palavras no jogo

- *Data:* 05/12/2025  
- *Etapa do Projeto:* Ajustes de experiência do usuário no jogo de digitação  
- *Ferramenta de IA Utilizada:* Chat GPT  
- *Objetivo da Consulta:* Entender como manter a palavra atual sempre visível dentro da área do jogo, simulando um scroll apenas das palavras, sem rolar a página inteira.

- *Resumo da Resposta da IA:*  
  A IA explicou o conceito de comparar a posição dos elementos na tela por meio de medições de posição vertical, e como usar esse cálculo para deslocar o container das palavras conforme o jogador avança. A ideia geral foi mover visualmente o bloco de palavras quando a palavra atual ultrapassa uma área limite definida dentro da região do jogo.

- *Análise e Aplicação:*  
  Com esse entendimento, foi implementado no jogo um mecanismo de “scroll visual” que ajusta o deslocamento vertical do container das palavras sempre que a palavra atual passa de um limite pré-definido, garantindo que o texto permaneça acessível e centralizado durante a digitação.

- *Referência no Código:*  
  Arquivo `jogo_digitacao.js`, na parte responsável pelo ajuste visual do container de palavras conforme a progressão do jogador.


## Interação 12 — Comportamento dinâmico do botão “Novo Jogo”

- *Data:* 05/12/2025  
- *Etapa do Projeto:* Fluxo de jogo e usabilidade do botão “Novo Jogo”  
- *Ferramenta de IA Utilizada:* Chat GPT  
- *Objetivo da Consulta:* Entender como fazer o botão de “Novo Jogo” aparecer apenas quando o jogador realmente começa a digitar ou depois que ele já terminou uma partida, evitando que o botão fique sempre visível sem necessidade.

- *Resumo da Resposta da IA:*  
  A IA explicou a ideia de controlar a visibilidade do botão a partir do estado do jogo:
  - no carregamento inicial, o jogo começa automaticamente com o botão escondido,  
  - quando o usuário pressiona uma tecla pela primeira vez, o botão passa a ser exibido como “Reiniciar Jogo”,  
  - e, após o fim da partida, uma informação vinda do back-end (via PHP) indica ao JavaScript que já existe um resultado anterior, permitindo mostrar o botão “Novo Jogo” logo que a página é carregada de volta.

  A orientação foi conceitual, focando em como combinar uma variável de controle vinda do servidor com a lógica do evento de teclado no front-end para decidir quando o botão deve aparecer.

- *Análise e Aplicação:*  
  Com esse entendimento, foi implementado um fluxo em que:
  - ao entrar na página pela primeira vez, o jogo é iniciado automaticamente, o botão permanece oculto e só aparece quando o jogador começa a digitar;  
  - após uma partida ser finalizada, o resultado é salvo e, no retorno da página, uma variável de controle indica ao JavaScript que já houve jogo anterior, fazendo o botão surgir imediatamente como opção de “Novo Jogo”.

  Isso deixou a interface mais limpa no início e, ao mesmo tempo, mais prática para quem já terminou uma partida e quer jogar novamente.

- *Referência no Código:*  
  Arquivos `game.php` (parte que define a informação de resultado para o front-end) e `jogo_digitacao.js` (lógica que controla quando o botão “Novo Jogo” é exibido de acordo com o estado do jogo).

## Interação 13 — Revisões gerais e checagens de boas práticas

- *Data:* 05/12/2025  
- *Etapa do Projeto:* Revisão final  
- *Ferramenta de IA Utilizada:* Chat GPT  
- *Objetivo da Consulta:* Revisar raciocínios, checar se a estrutura geral seguia boas práticas e garantir consistência em PHP, SQL, JS e fluxo de páginas.

- *Resumo da Resposta da IA:*  
  A IA revisou conceitos importantes como:
  - uso correto de sessões e redirecionamento,
  - organização de funções no PHP,
  - padronização de consultas SQL,
  - coerência entre validação front-end e back-end,
  - clareza na comunicação entre JS e PHP.

  Tudo isso foi apresentado de forma teórica, sem fornecer código para copiar.

- *Análise e Aplicação:*  
  As explicações foram usadas como checklist final, garantindo que o projeto estivesse consistente com boas práticas e com os requisitos da disciplina, sem substituir o desenvolvimento manual.

- *Referência no Código:*  
  Revisão ampla envolvendo `game.php`, `ligas.php`, `ligas_detalhe.php`, `ranking_jogadores.php`, `jogo_digitacao.js` e outras páginas do sistema.
---

## Interação 14 — Apoio na identificação de erros durante o desenvolvimento

- *Data:* 05/12/2025  
- *Etapa do Projeto:* Depuração e correção de erros gerais  
- *Ferramenta de IA Utilizada:* Chat GPT  
- *Objetivo da Consulta:* Obter auxílio para entender causas de erros quando certas partes do código não funcionavam como esperado, tanto no PHP quanto no JavaScript. A consulta foi voltada para interpretar mensagens de erro, compreender comportamentos inesperados e revisar a ordem lógica das instruções.

- *Resumo da Resposta da IA:*  
  A IA ajudou explicando possíveis origens dos erros reportados (problemas de sessão, variáveis não definidas, erros de fluxo, retorno de SQL vazio, problemas de escopo no JavaScript). A ênfase foi em compreender *por que* o erro ocorria e quais verificações poderiam ser feitas para isolar a causa: revisar seções do código, checar valores recebidos, validar estados anteriores do jogo e analisar trechos onde a lógica poderia não estar sendo executada conforme o previsto.

- *Análise e Aplicação:*  
  Com esse suporte conceitual, foi possível identificar mais rapidamente onde estavam inconsistências do projeto — como problemas de sessão expirada, pequenos detalhes no fluxo de POST/Redirect/GET, validações que não acionavam ou comportamentos inesperados em eventos de teclado. Isso acelerou a depuração ao fornecer caminhos de investigação claros, mantendo todas as correções e implementações feitas manualmente.

- *Referência no Código:*  
  Revisão e correção aplicadas em diversos pontos:  
  - `game.php` (tratamento de sessão, PRG, mensagens de erro),  
  - `jogo_digitacao.js` (eventos de teclado, estados do jogo, atualização de interface),  
  - `ligas.php` e `ligas_detalhe.php` (validações de dados e conferência de retornos do banco),  
  - e outras áreas onde comportamentos inesperados surgiram durante testes.


## Conclusão

Ao longo do desenvolvimento, a IA foi utilizada *principalmente como ferramenta de aprendizado e apoio conceitual*, especialmente em:

- Organização de layout e identidade visual em CSS.
- Melhoria de usabilidade e legibilidade em tabelas e cards.
- Exemplos de estruturação de documentação em Markdown.
- Sugestões de vocabulário para o conteúdo textual do jogo.

Todas as decisões de implementação, lógica de negócio, consultas ao banco de dados e fluxos de autenticação foram cuidadosamente estudadas e implementadas pelos autores, usando a IA apenas como suporte para enriquecer o entendimento e acelerar tarefas de estudo e experimentação visual.