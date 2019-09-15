# Tutorial-Laravel
LaravelでWebアプリケーションを作る

---

## 設定値

* アプリケーション名: `Tutorial-Laravel`

* ディレクトリ
  * XAMPPインストール先: `C:\pleiades\xampp`
  * プロジェクトフォルダ: `C:\Users\y\Documents\GitHub\Tutorial-Laravel`

* PostgreSQL
  * データベース名: `tutorial_laravel`
  * ユーザー名: `tutorial_user`

---

## ツール類のインストール

### XAMPPのインストール

[XAMPP Installers and Downloads for Apache Friends](https://www.apachefriends.org/jp/index.html)から、
[Windows向けXAMPP](https://www.apachefriends.org/xampp-files/7.3.9/xampp-windows-x64-7.3.9-0-VC15-installer.exe)をダウンロードして実行

以下のコンポーネントをインストールする

* Apache 2
* PHP 7.3
* phpMyAdmin

### PostgreSQL

[PostgreSQL Database Download | EnterpriseDB](https://www.enterprisedb.com/downloads/postgres-postgresql-downloads)から、
[11.5](https://www.enterprisedb.com/thank-you-downloading-postgresql?anid=1256714)をダウンロードして実行

#### データベースの準備

```bat
$ psql -h localhost -p 5432 -U postgres -d postgres
> CREATE DATABASE tutorial_laravel ;
> \l
> CREATE ROLE tutorial_user WITH LOGIN PASSWORD 'Passw0rd' ;
> \du
> GRANT ALL ON DATABASE tutorial_laravel TO tutorial_user ;

$ psql -h localhost -p 5432 -U postgres -d postgres
# > ALTER SCHEMA public OWNER TO tutorial_user;

$ psql -h localhost -p 5432 -U tutorial_user -d postgres
> SELECT * FROM pg_database;


$ psql -h localhost -p 5432 -U tutorial_user -d tutorial_laravel
> drop schema public cascade;
> create schema public;
```

### Composer

[Composer](https://getcomposer.org/download/)から、
[Composer-Setup.exe](https://getcomposer.org/Composer-Setup.exe)をダウンロードして実行

### Laravel

#### Laravelプロジェクトの作成

```bat
$ cd C:\Users\y\Documents\GitHub

REM composer global require "laravel/installer"
REM laravel -f new Tutorial-Laravel
REM  or
$ composer create-project --prefer-dist laravel/laravel Tutorial-Laravel
```

#### Laravelのバージョンを確認

```bat
$ php artisan --version
```

> Laravel Framework 6.0.3

#### ロケールの設定

* config/app.php

```php
'timezone' => 'Asia/Tokyo',
'locale' => 'ja',
```

#### .envファイルの編集( or .env.exampleをコピーして作成)

初期設定ではMySQLを使用する設定になっているため、変更する

```ini
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=tutorial_laravel
DB_USERNAME=tutorial_user
DB_PASSWORD=***
```

##### SQLiteを使用する場合の.envファイル

`DB_HOST`などは記述しない。データベースファイルは`database/database.sqlite`に格納しておく (`$ touch database/database.sqlite`で作成)

```ini
DB_CONNECTION=sqlite
```

データベースファイルとして`database/database.sqlite`以外を使用する場合は、`DB_DATABASE`を絶対パスで定義する

```ini
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database.sqlite
```

#### シンボリックリンクの作成

```bat
$ cd C:\pleiades\xampp\htdocs
$ mklink /D Tutorial-Laravel C:\Users\y\Documents\GitHub\Tutorial-Laravel
```

### 動作確認

```bat
$ php artisan serve
```

[http://127.0.0.1:8000](http://127.0.0.1:8000)にアクセスして動作確認する

---

## 認証機能のセットアップ

Laravel 6.0から、標準のコマンドだった`php artisan make:auth`で認証機能を作成できなくなったため、[Laravel UI](https://laravel.com/docs/6.x/frontend)(`laravel/ui`)パッケージをインストールする必要がある

```bat
$ composer require laravel/ui
$ php artisan ui vue --auth
REM `vue`のほかに、`react`、`bootstrap`も指定できる

$ npm install && npm run dev
```

`--auth`を付けずに`ui`コマンドを実行してしまった場合は、別途`ui:auth`コマンドを実行する

### 認証機能用のマイグレーション

```bat
$ php artisan migrate
```

### 動作確認

```bat
$ php artisan serve
```

[http://127.0.0.1:8000](http://127.0.0.1:8000)にアクセスして動作確認する

---

## アイテム格納用にデータベースとモデルを作成

マイグレーションファイルを作成し、生成されたファイルのパスを確認する

```bat
$ php artisan make:migration create_items_table --create=items
$ php artisan make:migration create_subitems_table --create=subitems
```

> Created Migration: 2019_09_16_070521_create_items_table
>
> Created Migration: 2019_09_16_070531_create_subitems_table

---

Copyright (c) 2019 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.