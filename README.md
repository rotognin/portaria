# Controle de portaria - entrada e saída de visitantes e veículos

<em>Projeto de estudo particular</em>

Este sistema consiste em um controle de visitas em uma empresa, com suporte a matriz e filiais, podendo ter uma ou mais portarias em uma mesma unidade. O registro de login do operador estará ligado à unidade e à portaria onde ele irá atuar.

No registro de movimentação de entrada, o visitante irá receber um crachá identificado e deverá devolvê-lo na saída. Poderá informar o nome de um contato na empresa com quem irá tratar, além de cadastrar acompanhantes que estiverem junto com o mesmo.

## Ambientes:

- <strong>Administrativo:</strong> ambiente voltado à gerência, para o cadastro de usuários (administradores e clientes), Unidades (matriz e filiais), Portarias da Unidade, Crachás a serem disponibilizados, acompanhamento das movimentações e relatórios. Apenas usuários cadastrados como <em>Administradores</em> podem acessar esse ambiente.

- <strong>Movimentações:</strong> movimentações de entrada e saída, cadastro de empresas e visitantes, listagem de relatório. Quaisquer usuários que não estiverem cadastrados como <em>Administradores</em> irão acecssar esse ambiente automaticamente, devendo selecionar a unidade e a portaria em que irão atuar após o login.

Um usuário cadastrado como "Usuário Comum" não tem acesso ao sistema administrativo, assim como administradores não terão acesso ao ambiente de movimentações.

## Detalhes técnicos:

Sistema sendo desenvolvido em PHP 7.4+, usando a arquitetura MVC (POO), CoffeeCode DataLayer como ORM, banco de dados MySQL, seguindo as melhores práticas de programação (separação de camadas, separação de responsabilidades, nomes de variáveis e métodos com coerência).

Necessário para o funcionamento do sistema: PHP 7.4+, MySQL, Composer.

## Procedimentos para instalação local:

- Baixe o projeto em uma pasta
- Acesse a pasta via linha de comando
- Entre com o seguinte comando: <code> composer update </code>
- Crie um banco com o nome <code>portaria_db</code>
- Verifique as configurações de acesso ao banco de dados no arquivo <code>src/config.php</code>
- Rode o script <code>docs/tabelas.sql</code> no banco para criar as tabelas do sistema
- Será criado o usuário "admin" no banco, senha "123", com acesso ao ambiente administrativo.

### Considerações

O projeto está em constante atualização, sendo adicionadas funcionalidades e melhorias. Sugestões serão muito bem vindas.

### Melhorias futuras

- Geração de relatórios em PDF
- Envio de e-mails para a empresa quando o visitante der entrada
- Criação de parâmetros:
  - Acompanhante pode sair antes?
  - Atribuir crachás específicos para acompanhantes
  - Previsão de saída (exibirá mensagem ao passar do horário previsto)
- Exibir mais informações nos detalhes de uma movimentação
- Geração de gráficos
- Envio de mensagens entre os ambientes
- Na administração:
  - verificar quais portarias estão ativas no momento
  - exibir movimentações não finalizadas de dias anteriores
- Criação de um log de acompanhamento das movimentações