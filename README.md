# CakeNews plugin for CakePHP

version 2017.11.30

## 更新履歴

2017.11.30 定数用のconfig/const.phpを追加

2017.11.28 作成時に順序が最後になるように修正。

2017.11.25 削除のエラーとソートの順番表示を修正。

2017.11.23 アップロードしたファイルが傾く問題を修正。

2017.11.20 お知らせ機能作成。


## 手動インストール

手動でファイル一式をpluginsに保存します。

下記のコンフィグに一行追加して読み込みます。
config/bootstrap.php
```
Plugin::load('trycatch-inc\\CakeNews', ['bootstrap' => true, 'routes' => true]);
```

composer.jsonのautoload.psr-4に`"CakeNews\\": "./plugins/CakeNews/src"`を追記
composer.jsonのautoload-dev.psr-4に`"CakeNews\\Test\\": "./plugins/CakeNews/tests"`を追記
以下、例
```
"autoload": {
    "psr-4": {
        "App\\": "src",
        "CakeNews\\": "./plugins/CakeNews/src"
    }
},
"autoload-dev": {
    "psr-4": {
        "App\\Test\\": "tests",
        "CakeNews\\Test\\": "./plugins/CakeNews/tests"
    }
},
```

その後キャッシュをクリア
```
docker-compose run --rm php php composer.phar dumpautoload
```

### テーブルを作成
```
docker-compose run --rm php php bin/cake.php migrations migrate -p trycatch-inc/CakeNews
```

### 設定

`plugins/CakeNews/config/news.php`をコピーして`config`に置きます。
config/bootstrap.phpに以下一行追加して読み込みます。
```
Configure::load("news");
```

#### 文言を変更する場合
`plugins/CakeNews/src/Locale/ja_JP/default.po`の内容を以下のファイルに追加してください。
`src/Locale/ja_JP/default.po`（ない場合は作成）


## コンポーザーからインストール（リポジトリと認証設定が必要）

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:

```
composer require trycatch-inc/CakeNews
```

## 依存パッケージ

```
"cakedc/users": "^5.2",
"friendsofcake/cakephp-upload": "3.*",
"friendsofcake/search": "4.*",
```
