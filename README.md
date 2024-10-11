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
    <p>Execute o comando abaixo para instalar todas as dependências necessárias:</p>
   ```composer install ```

3. **Instale as dependências do Node.js**:
    <p>```npm install ```</p>

4. **Configure o arquivo .env**:
    <p>Atualize as informações de configuração do banco de dados conforme necessário.</p>
    

5. **Execute as migrações do banco de dados**:
    <p>Após configurar o banco de dados, execute as migrações</p>
    ```php artisan migrate ```


## Executando o projeto
1. **Compilar os assets do frontend**:
    <p>``` npm run dev ```</p>
    

2. **Iniciar o servidor Laravel**:

    <p>```php artisan migrate ```</p>
