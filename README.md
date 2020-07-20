# News test app

   Тестовое задание на PHP.
   
   Использовать PHP 7.3+, Laravel Framework 7+, PostgreSQL, Swagger, ElasticSearch
    
   1) Создать форму авторизации и регистрации с использованием reCaptcha v3
   2) Добавить страницу "Профиль" с полями ФИО, дата рождения, фото 
   3) Создать страницу новости (заголовок, сокращенный текст, новости, маленькое фото для превью, дата создания новости). 
     Добавить 200 записей, по 12 записей на странице
   4) Реализовать RESTfull api для авторизации, регистрации, восстановления пароля, профиля и новостей
   5) Дополнить новости поиском через ElasticSearch по тексту и заголовку
   6) Дополнить новости категорией, добавить фильтрацию по категориям
    
   API для получения новостей, наполнения тестовыми данными на Ваш выбор. 
    
   Код оформить по стандартам PSR 
    
   Результат представить ссылкой на репозиторий



## Install project
* Install Docker: [macOS](https://hub.docker.com/editions/community/docker-ce-desktop-mac) | [Linux](https://docs.docker.com/engine/install/ubuntu/) | [Windows](https://hub.docker.com/editions/community/docker-ce-desktop-windows)
* Install [Docker Compose](https://docs.docker.com/compose/install/#install-compose)
* (optional) Clone project from `git clone git@bitbucket.org:srx_rws/rws_back.git`
* Go to project directory `cd news-app/backend`
* Run command `make install`
* Edit `/etc/hosts` file. 
    * Add `127.0.0.1 news.test` for API host
* (optional) If you need frontend app. Go to project directory `cd news-app/backend`
    Run command `yarn run build` or `npm run build` 
* Done

## Access
* Database (from .env):
    *DB_HOST=postgres
    *DB_PORT=5432
    *DB_DATABASE=news_app
    *DB_USERNAME=sabah
    *DB_PASSWORD=secret
* Hosts
    * Traefik dashboard http://localhost:8000 (see `.env`)    
    * Backend API http://news.test (see `.env`)

## Start, stop and restart
* To start containers run `make up`
* To stop containers run `make down`
* To restart containers run `make restart`

## Any errors?
* Run `make prune`

## Available CLI commands
* Run `make` or `make help`


