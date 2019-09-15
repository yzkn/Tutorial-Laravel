# Tutorial-Laravel
LaravelでWebアプリケーションを作る

---

## 設定値

* XAMPPインストール先: `C:\pleiades\xampp`

* アプリケーション名: `Tutorial-Laravel`
* プロジェクトフォルダ: `C:\Users\y\Documents\GitHub\Tutorial-Laravel`

---

## ツール類のインストール

### XAMPPのインストール

[XAMPP Installers and Downloads for Apache Friends](https://www.apachefriends.org/jp/index.html)から、
[Windows向けXAMPP](https://www.apachefriends.org/xampp-files/7.3.9/xampp-windows-x64-7.3.9-0-VC15-installer.exe)をダウンロードして実行

以下のコンポーネントをインストールする

* Apache 2
* PHP 7.3
* phpMyAdmin

### PostgreSQLのインストール

[PostgreSQL Database Download | EnterpriseDB](https://www.enterprisedb.com/downloads/postgres-postgresql-downloads)から、
[11.5](https://www.enterprisedb.com/thank-you-downloading-postgresql?anid=1256714)をダウンロードして実行

### Composerのインストール

[Composer](https://getcomposer.org/download/)から、
[Composer-Setup.exe](https://getcomposer.org/Composer-Setup.exe)をダウンロードして実行

### Laravelのインストール

```bat
$ composer global require "laravel/installer"
```

### Laravelプロジェクトの作成

```bat
$ cd C:\Users\y\Documents\GitHub
$ laravel -f new Tutorial-Laravel
```

### シンボリックリンクの作成

```bat
$ cd C:\pleiades\xampp\htdocs
$ mklink /D Tutorial-Laravel C:\Users\y\Documents\GitHub\Tutorial-Laravel
```
