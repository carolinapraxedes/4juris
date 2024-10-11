# Projeto 

Este é um projeto Laravel que utiliza Laravel Jetstream e Docker para criar uma API com CRUD. Este README contém as instruções necessárias para configurar e rodar o projeto localmente.

## Pré-requisitos

Antes de começar, certifique-se de ter os seguintes itens instalados:


- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/)


## Configuração do projeto

1. **Clone o repositório**:
   ```bash
   git clone <url-do-repositorio>
   cd <nome-do-projeto>

2. **Instale as dependências do PHP**
    Execute o comando abaixo para instalar todas as dependências necessárias:
   ```composer install ```

3. **Instale as dependências do Node.js**:
    ```npm install ```

4. **Configure o arquivo .env**:
    Atualize as informações de configuração do banco de dados conforme necessário.
    

5. **Execute as migrações do banco de dados**:
    Após configurar o banco de dados, execute as migrações
    ```php artisan migrate ```


## Executando o projeto
1. **Compilar os assets do frontend**:
    ``` npm run dev ```
    

2. **Iniciar o servidor Laravel**:

    ```php artisan migrate ```
