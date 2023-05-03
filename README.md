# CRUD de Contatos

Sistema de gerenciamento de contatos, desenvolvido com Symfony e Bootstrap. Este sistema visa apresentar algumas caracteristicas e competências diante do desenvolvimento de aplicações Web. O foco deste projeto está em aprender um novo Framework, e conseguir criar os CRUD's de Pessoa e Contato.

Dentre as tecnologias abordadas neste projeto, as principais foram

- Bootstrap(Front-end);
- Composer(Gerenciador de dependências);
- Doctrine(ORM);
- PostgreSQL(Banco de Dados);
- Symfony(Back-end).

## Pacotes do composer que fora utilizados

- orm;
- symfony/form;
- symfony/maker-bundle;
- symfony/orm-pack;
- symfony/twig-bundle;
- twig.

## Como configurar o projeto para a execução

Para rodar o projeto de modo local em sua máquina é necessário possuir os seguintes programas instalados

- Symfony;
- PostgreSQL;
- Navegador Web;
- PHP.

### Alterando o php.ini(arquivo de configuração do PHP)

As extensões abaixo devem estar presentes no arquivo php.ini:

- extension=pdo_pgsql;
- extension=pgsql;

### Criando o banco de Dados

Acesse o pgAdmin, e crie um novo DB. Este projeto foi configurado com o banco de dados possuindo um usuário denominado de postgres e a senha definida como aluno, em um banco com o nome de "contatos". Você pode utilizar as suas configurações atuais da máquina, desde que altere o arquivo ".env"(próximo passo).

### .env (arquivo de configuração do projeto)

O arquivo ".env" é responsável por aplicar as configurações do projeto. Encontre o arquivo dentro da raíz do projeto, e altere a linha:

>DATABASE_URL="postgresql://app:!ChangeMe!@127.0.0.1:5432/app?serverVersion=15&charset=utf8"

A linha deve ser modificada para que se enquadre como o exemplo abaixo: 
>DATABASE_URL=postgresql://NOME_USUARIO_BANCO:SENHA_BANCO@127.0.0.1:5432/NOME_DATA_BASE

Obs.: Certifique-se de que o domínio utilizado pelo seu pgsql está no mesmo ip que o do exemplo acima.

### Rodando o projeto

Execute a sequência de comandos abaixo no terminal PowerShell dentro do diretório do projeto

- symfony check:requirements

> Irá verificar todos os pacotes do projeto garantindo que estão aptos para a execução

- symfony server:start

> Inicia um servidor local executando o projeto

- php bin/console doctrine:migrations:migrate

> Este comando deve criar as tabelas "pessoa" e "contato" no seu database. Verifique se elas estão presentes com todas as colunas esperadas

Obs.: Caso o comando acima não seja executado com sucesso, execute o seguinte comando

- php bin/console make:migration

> Agora haverá um arquivo de migrations para ser executado

- php bin/console doctrine:migrations:migrate

#### Rotas do sistema

- index: localhost/

- pessoa_consultar: localhost/pessoa

- pessoa_cadastrar: localhost/pessoa/cadastrar

- pessoa_editar: localhost/pessoa/editar/{id}

- pessoa_excluir: localhost/pessoa/excluir/{id}

- contato_consultar: localhost/contato

- contato_cadastrar: localhost/contato/cadastrar

- contato_editar: localhost/contato/editar/{id}

- contato_excluir: localhost/contato/excluir/{id}
