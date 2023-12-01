
# Products Parser

Desenvolvimento de uma REST API para o controle de notas fiscais dos usuários.

## Tecnologias

- Linguagem: Php
- Framework: Laravel
- Tecnologia: Mysql, FakerPhp, PestPhp

## Instalação

1. Clone o repositório: `git clone https://https://github.com/HenriqueTex/invoice_management`
2. Acesse o diretório do projeto: `cd invoice_management`

Localmente:
3. Instale as dependências: `npm install` ou `composer install`
4. Configure as variáveis de ambiente: crie um arquivo `.env` e `.env.testing` com base no arquivo `.env.example` e configure as informações necessárias.
6. Inicie o servidor local: `php artisan serve`

Utilizando Docker:
3. Execute o comando `docker-compose up -d` para iniciar os containers.
4. Configure as variáveis de ambiente: crie um arquivo `.env` e `.env.testing` com base no arquivo `.env.example` e configure as informações necessárias.
5. Execute o comando `./vendor/bin/sail artisan migrate` para criar as tabelas no banco de dados.

## Uso

    Utilize a rota de registro para gerar um acesso e se autenticar na rota de login, utilize o token retornado para acessar as demais rotas do CRUD de notas fiscais. 
    Na raiz do projeto existe um arquivo chamado `Insomnia_doc.json` que pode ser importado no Insomnia para testar as rotas da API.
    A env.example está com a configuração padrão de filas para sync, para utilizar o Redis, basta alterar a variável QUEUE_CONNECTION para redis e configurar as variáveis REDIS_HOST, REDIS_PASSWORD e REDIS_PORT. Neste caso deve-se utilizar o comando `php artisan queue:work` para iniciar o worker das filas.
