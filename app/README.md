# passo a passo para testes

# 1. Acesse a pasta do projeto
cd ./app

# 2. Instale as dependências PHP
composer install

# 3. Instale as dependências do frontend (Vite)
npm install

# 4. Copie o arquivo de exemplo .env
cp .env.example .env

# 5. Configure o banco de dados no arquivo .env
#    (crie o banco e atualize DB_DATABASE, DB_USERNAME, DB_PASSWORD)

# 6. Gere a chave da aplicação
php artisan key:generate

# 7. Rode as migrações para criar as tabelas
php artisan migrate

# 8. (Opcional) Execute os seeders, se necessário
php artisan db:seed

# 9. Inicie o servidor de desenvolvimento
php artisan serve

# 10. Compile os assets frontend (modo desenvolvimento)
npm run dev
