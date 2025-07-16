### English 
# Multitenant Finances Management System

## Tecnologies used
- Laravel
- Vuejs- Inertiajs
- Mysql
- Docker with Sail

## Laravel Libs

## Vuejs Libs
- Pirme Vue for toasts - https://primevue.org/
- V-money - https://www.npmjs.com/package/v-money

## Features
- Full Auth with Breeze @DONE
- Tenants management @DONE
- Users management @DONE
- Categories management @DONE
- Finances records management @DONE
- Full transalation in English @DONE
- Full transalation in Portugues @TODO

All categories and finances are linked to a tenant. The tenant attribute is setted via creating event and the filter is made via global scope in App/Traits/TenantManager.php

## How to install

Note: Make sure you have docker installed in your machine.

### clone the repository
```bash
git clone https://github.com/katalekoweb/laravel12-vue-inertiajs-saas-gestao-financeira.git
cd laravel12-vue-inertiajs-saas-gestao-financeira
```

### Copy the env file 
```bash
cp .env.example .env
```

### Install the dependencies 
```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs
```

### Run the containers with sail
```bash
./vendor/bin/sail up -d
```

### Generate the app key
```bash
./vendor/bin/sail artisan key:generate
```

### Run the migrations and seeders
```bash
./vendor/bin/sail artisan migrate --seed
```

### Open the project in your browser
http://locathost
Login: username:admin@admin.com, password: password

# Portuguese 
# Sistema de gestão financeira Multitenant

## Tecnologias usadas
- Laravel
- Vuejs- Inertiajs
- Mysql
- Docker com Sail

## Bibliotecas Laravel

## Bibliotecas Vuejs
- Pirme Vue for toasts - https://primevue.org/
- V-money - https://www.npmjs.com/package/v-money

## Funcionalidades
- Autenticação completa @DONE
- Gestão de tenants @DONE
- Gestão de usuários @DONE
- Gestão de categorias @DONE
- Gestão de movimentos financeiros @DONE
- Tradução completa em inglês @DONE
- Tradução completa em Poetuguês @TODO

Todas as categorias e finanças estão vinculadas a um locatário. O atributo do tenant é definido por meio do evento de criação e o filtro é feito por meio do escopo global em App/Traits/TenantManager.php.

## Como instalar na sua máquina

Note: Para rodar este projeto tenha certeza que você tem o docker instalado em sua máquina.

### clone o repositório
```bash
git clone https://github.com/katalekoweb/laravel12-vue-inertiajs-saas-gestao-financeira.git
cd laravel12-vue-inertiajs-saas-gestao-financeira
```

### Copie o ficheiro .env
```bash
cp .env.example .env
```

### Instale as dependencias
```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs
```

### Rode os containers com o Laravel sail
```bash
./vendor/bin/sail up -d
```

### Gere a chave do programa
```bash
./vendor/bin/sail artisan key:generate
```

### Rode as migrations e os seeders
```bash
./vendor/bin/sail artisan migrate --seed
```

### Abra o seu projeto
http://locathost
Login: username:admin@admin.com, senha: password

## My email: juliofeli78@gmail.com
## Linkedin: https://www.linkedin.com/in/juliaokataleko/