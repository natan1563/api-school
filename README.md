## Instruções pós download/clone

- Rodar o comando no terminal: ``composer update``
- Criar arquivo ``.env`` com base no arquivo ``.env-example``
- Verificar credenciais de acesso a base de dados no arquivo ``.env``
- Importar base de dados ``/database/app_school.sql`` para o servidor de banco de dados. 
- Subir o servidor de banco de dados.
- Rodar os comandos no terminal: ``php artisan key:generate`` | ``php artisan jwt:secret`` | ``php artisan migrate`` 
- Rodar os comandos no terminal: ``php artisan serve``
