# Controle de portaria - entrada e saída de visitantes e veículos

Este sistema consiste em um controle de visitantes em uma empresa, seja ela uma matriz ou suas filiais, pois o controle é feito de forma a suportar essa divisão, podendo ter uma ou mais portarias em uma mesma unidade.

No registro de movimentação ded entrada, o visitante irá receber um crachá identificado e deverá devolvê-lo na saída. Poderáinformar o nome de um contato na empresa com quem irá tratar, além de cadastrar acompanhantes que estiverem junto com o mesmo.

## Ambientes:

- <strong>Administrativo:</strong> ambiente para o cadastro de usuários (administrativos e clientes), Unidades (matriz e filiais), Portarias da Unidade, Crachás a serem disponibilizados, acompanhamento das movimentações e relatórios. Apenas usuários cadastrados como <em>Administradores</em> podem acessar esse ambiente.

- <strong>Movimentações:</strong> movimentações de entrada e saída, cadastro de empresas e visitantes, listagem de relatório. Quaisquer usuários que não estiverem cadastrados como <em>Administradores</em> irão acecssar esse ambiente automaticamente, devendo selecionar a unidade e a portaria em que irão atuar após o login.

## Detalhes técnicos:

Sistema sendo desenvolvido em PHP 7.4+, usando a arquitetura MVC (POO), CoffeeCode DataLayer como ORM, banco de dados MySQL.

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