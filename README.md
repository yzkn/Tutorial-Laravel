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

* ステータスコード
  * 失敗時(共通)
    * `400 Bad Request`
    * `401 Unauthorized`
    * `403 Forbidden`
    * `404 Not Found`
    * `405 Method Not Allowed` GET/HEADの二つは必須で、このエラーコードを返してはいけない
    * `406 Not Acceptable`
    * `408 Request Timeout`
    * `409 Conflict` リクエストがサーバーの現在の状態と矛盾する
    * `410 Gone` リクエストされたコンテンツがサーバーから永久に削除され、転送先アドレスがない
    * `418 I'm a teapot`
    * `429 Too Many Requests` レート制限
    * `451 Unavailable For Legal Reasons` ユーザーが政府によって検閲されたウェブページなど、違法なリソースをリクエストしている
    * `500 Internal Server Error`
    * `501 Not Implemented` リクエストメソッドをサーバーが対応しておらず、扱えない
    * `503 Service Unavailable` リクエストを処理する準備ができていない(メンテナンスや過負荷でダウンしている)
  * メソッド別

| Method | Code(Success) | Code(Failure) | Details |
| --- | --- | --- | --- |
| `GET` | `200 OK` / `304 Not Modified` | `` |  |
| `POST` | `201 Created` | `303 See Other` / `409 Conflict` |  |
| `PUT` | `201 Created` (挿入) / `204 No Content` (更新) | `409 Conflict` | レコードがあれば置換、なければ新規作成 |
| `PATCH` | `200 OK` / `204 No Content` | `404 Not Found` / `409 Conflict` | レコードの一部の項目を更新 |
| `DELETE` | `204 No Content` | `404 Not Found` / `409 Conflict` |  |

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

#### キャッシュクリア系コマンド

```sh
$ php artisan config:clear # 設定ファイル
$ php artisan cache:clear # アプリケーション
$ php artisan route:clear # ルート
$ php artisan view:clear # ビュー

$ composer dump-autoload # オートロード
```

```sh
$ php artisan key:generate # APP_KEY再生成
```

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

### マイグレーションファイルの生成

```bat
REM $ php artisan make:model Item --migration    # モデルとマイグレーションファイルを同時に生成する場合
REM $ php artisan make:model SubItem --migration #

$ php artisan make:migration create_items_table --create=items
$ php artisan make:migration create_subitems_table --create=subitems
```

生成されたファイルのパスを確認、それぞれ開き、カラムを追記する

> Created Migration: 2019_09_16_070521_create_items_table
>
> Created Migration: 2019_09_16_070531_create_subitems_table

* `database/migrations/2019_09_16_070521_create_items_table`
* `database/migrations/2019_09_16_070531_create_subitems_table`

### マイグレーションの実行

```bat
$ php artisan migrate
```

> Migrating: 2019_09_16_070521_create_items_table
>
> Migrated:  2019_09_16_070521_create_items_table (0.03 seconds)
>
> Migrating: 2019_09_16_070531_create_subitems_table
>
> Migrated:  2019_09_16_070531_create_subitems_table (0.02 seconds)

### モデルの生成・編集

```bat
$ php artisan make:model Item
$ php artisan make:model SubItem
```

* `app/Item.php`
* `app/SubItem.php`

### テストデータの挿入

ファクトリを生成

```bat
$ php artisan make:factory ItemFactory --model=Item
$ php artisan make:factory SubItemFactory --model=SubItem
```

* `database/factories/ItemFactory.php`
* `database/factories/SubItemFactory.php`

シーダ―を作成

```bat
$ php artisan make:seeder ItemSeeder
REM $ php artisan make:seeder SubItemSeeder
```

* `database/seeds/ItemSeeder.php`

```php
use App\Item;
use App\SubItem;
```

```php
        factory(Item::class, 50)
            ->create()
            ->each(function ($post) {
                $subitems = factory(App\SubItem::class, 2)->make();
                $post->subitems()->saveMany($subitems);
            });
```

* `database/seeds/DatabaseSeeder.php`

```php
$this->call(PostsTableSeeder::class);
```

シーダ―を実行する

```bat
$ composer dump-autoload
```

```
Generating optimized autoload files> Illuminate\Foundation\ComposerScripts::postAutoloadDump
> @php artisan package:discover --ansi
Discovered Package: facade/ignition
Discovered Package: fideloper/proxy
Discovered Package: laravel/tinker
Discovered Package: laravel/ui
Discovered Package: nesbot/carbon
Discovered Package: nunomaduro/collision
Package manifest generated successfully.
Generated optimized autoload files containing 3811 classes
```

```bat
$ php artisan db:seed
```

> Seeding: ItemSeeder
>
> Database seeding completed successfully.

### コントローラーを作成

```bat
$ php artisan make:controller ItemController --resource
$ php artisan make:controller SubItemController --resource
```

* `routes/api.php`

APIなので、新規作成・編集画面は不要

```php
Route::resource('item', 'ItemController', ['except' => ['create', 'edit']]);
Route::resource('subitem', 'SubItemController', ['except' => ['create', 'edit']]);

// エンドポイントをホワイトリストで制限する場合
//  Route::resource('item', 'ItemController', ['only' => ['index']]);
```

* `app/Http/Controllers/ItemController.php`

CRUD(Readは1件／全件)の5つに対応する関数の中身を記述する

| Method | Endpoint | Function | Name |
| --- | --- | --- | --- |
| `GET`           | `/item`           | `index`   | `item.index` |
| `POST`          | `/item`           | `store`   | `item.store` |
| `GET`           | `/item/{id}`      | `show`    | `item.show` |
| `PUT` / `PATCH` | `/item/{id}`      | `update`  | `item.update` |
| `DELETE`        | `/item/{id}`      | `destroy` | `item.destroy` |

---

## 論理削除(ソフトデリート)

### マイグレーション

```bat
$ php artisan make:migration add_column_softDeletes_users_table --table=users
$ php artisan make:migration add_column_softDeletes_items_table --table=items
$ php artisan make:migration add_column_softDeletes_subitems_table --table=subitems
```

それぞれのファイルに追記する

```php
$table->dropColumn('deleted_at');
```

マイグレーションを実行する

```bat
$ php artisan migrate
```

### モデルの編集

`App/User.php`, `App/Item.php`, `App/SubItem.php`

```php
use Illuminate\Database\Eloquent\SoftDeletes;

    // クラスの中
    use SoftDeletes;
    protected $dates = ['deleted_at'];
```

## バリデーションの追加(FormRequest)

```bat
$ php artisan make:request ItemRequest
$ php artisan make:request SubItemRequest
```

追加されたFormRequestを編集

* `app/Http/Requests/ItemRequest.php`
* `app/Http/Requests/SubItemRequest.php`

```php
    public function authorize()
    {
        return // false;
        return true;
    }
```

ItemControllerに以下のuse文を追記し、関数の引数にあるRequestをそれぞれのFormRequestに変更

* ItemController.php

```php
use App\Http\Requests\ItemRequest;


    // public function store(Request $request)
    public function store(ItemRequest $request)

    // public function update(Request $request, $id)
    public function update(ItemRequest $request, $id)
```

* SubItemController.php

```php
use App\Http\Requests\SubItemRequest;


    // public function store(Request $request)
    public function store(SubItemRequest $request)

    // public function update(Request $request, $id)
    public function update(SubItemRequest $request, $id)
```

## JWTAuthによるAPI認証

### JWTAuthのインストール

[Packagist](https://packagist.org/packages/tymon/jwt-auth) で、1.x台のうち最新のバージョンを確認し、composerコマンドの引数に指定

```bat
$ composer require tymon/jwt-auth v1.0.0-rc.5

REM 設定ファイル(config/jwt.php)を生成
$ php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"

REM .envにキー(JWT_SECRET)を追記
$ php artisan jwt:secret
```

### Userモデルの修正

* `app/User.php`

```php
// Add
use Tymon\JWTAuth\Contracts\JWTSubject;


// Replace
# class User extends Authenticatable
class User extends Authenticatable implements JWTSubject


// Add
    // JWTAuth
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }

```

### 設定ファイルの修正

* `config/auth.php`

```php
// Replace
    // 'defaults' => [
    //     'guard' => 'web',
    //     'passwords' => 'users',
    // ],

      'defaults' => [
        'guard' => 'api',
        'passwords' => 'users',
    ],

// Replace
    // 'guards' => [
    //     'api' => [
    //         'driver' => 'token',
    //         'provider' => 'users',
    //         'hash' => false,
    //     ],
    // ],

    'guards' => [
        'api' => [
            'driver' => 'jwt',
            'provider' => 'users',
        ],
    ],
```

### AuthControllerの作成

```bat
$ php artisan make:controller AuthController
```

* `app/Http/Controllers/AuthController.php`

```php
// Add
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

// Add
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
```

### ルーティングの修正

* `routes/api.php`

```php
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});
```

### 動作確認

RESTクライアントで、アクセストークンを取得できるか確認

#### Request

* POST [http://127.0.0.1:8000/auth/login](http://127.0.0.1:8000/auth/login)
* Header
  * `Content-Type` : `application/json`
* Body
  * `email` : `***`
  * `password` : `***`

#### Response

```json
{
  "access_token": "yZmRlYzk3MT...",
  "token_type": "bearer",
  "expires_in": 3600
}
```

取得したアクセストークンで、ログインユーザーの情報を取得して確認

`http://127.0.0.1:8000/api/auth/me?token=`

#### Request

* POST [http://127.0.0.1:8000/api/auth/me](http://127.0.0.1:8000/api/auth/me)
* Header
  * `Authorization` : `Bearer yZmRlYzk3MT...`

#### Response

```json
{
  "id": 1,
  "name": "Y",
  "email": "ya.androidapp@gmail.com",
  "email_verified_at": null,
  "created_at": "2019-09-15 15:01:25",
  "updated_at": "2019-09-15 15:01:25",
  "deleted_at": null
}
```

## Role(権限)管理の追加

### マイグレーション

```bat
$ php artisan make:migration add_role_to_users_table
```

* `database/migrations/2019_09_22_104030_add_role_to_users_table.php`

```php
// Add
            $table->smallInteger('role')->default(0);

// Add
            $table->dropColumn('role');
```

```bat
$ php artisan migrate
```

### ミドルウェアの追加

``` bat
$ php artisan make:middleware JWTAuthenticateRole
```

* `config/auth.php`

```php
// Add
    // Role
    'role' => [
        'sysadmin' => '2',
        'admin' => '10',
        'general' => '100',
        'guest' => '1000',
    ],
```

* `app/Http/Middleware/JWTAuthenticateRole.php`

```php
// Add
use Config;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Http\Middleware\Authenticate;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;


// Replace
// class JWTAuthenticateRole
class JWTAuthenticateRole extends Authenticate


// Replace
    public function handle($request, Closure $next, $role=null)
    {
        Log::debug(sprintf('JWTAuthenticateRole::handle(%s, Closure, %s)', $request, $role));

        $this->authenticate($request);

        /*
        Role     Num
        sysadmin 1
        admin    10-99
        general  100-999
        guest    1000-9999
        */

        $user = $this->auth->parseToken()->user();

        // 設定値の確認
        // Log::debug(sprintf('JWTAuthenticateRole::handle() sysadmin: %s', Config::get('auth.role.sysadmin', 2)));

        // 権限チェック
        $is_authorized = false;
        if ($role == 'sysadmin' && $user['role'] == Config::get('auth.role.sysadmin', 1)) {
            $is_authorized = true;
        } elseif ($role == 'admin' && $user['role'] > 0 && $user['role'] < 10 * Config::get('auth.role.admin', 10)) {
            $is_authorized = true;
        } elseif ($role == 'general' && $user['role'] > 0 && $user['role'] < 10 * Config::get('auth.role.general', 100)) {
            $is_authorized = true;
        } elseif ($role == 'guest' && $user['role'] > 0 && $user['role'] < 10 * Config::get('auth.role.guest', 1000)) {
            $is_authorized = true;
        } elseif ($role == null) {
            $is_authorized = true;
        }

        if (!$is_authorized) {
            throw new UnauthorizedHttpException('jwt-auth', 'User role error.');
        }

        return $next($request);
    }
```

* `app/Http/Kernel.php`

```php
// Add
        'jwt.auth.role' => \App\Http\Middleware\JWTAuthenticateRole::class,
```

作成したミドルウェアを経由するように指定

* `routes\api.php`

```php
Route::group(['middleware' => ['jwt.auth.role:admin']], function() {
    // ...
}
```

例外発生時にJSONを返す

* `app/Exceptions/Handler.php`

```php
// Add
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;


// Add
        if ($request->expectsJson()) {
            if ($exception instanceof UnauthorizedHttpException) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        }
```

---

Copyright (c) 2019 YA-androidapp(https://github.com/YA-androidapp) All rights reserved.