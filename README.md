# CakeNews plugin for CakePHP

version 2017.12.19.00

## 更新履歴

2017.12.19.00 ネームスペースの修正

2017.12.05.00 src/Model/Entity/Menu.phpとsrc/Template/Menus/add.ctpを修正

2017.11.30.00 定数用のconfig/const.phpを追加

2017.11.28.00 作成時に順序が最後になるように修正。

2017.11.25.00 削除のエラーとソートの順番表示を修正。

2017.11.23.00 アップロードしたファイルが傾く問題を修正。

2017.11.20.00 お知らせ機能作成。


## 手動インストール

手動でファイル一式をpluginsに保存します。

下記のコンフィグに一行追加して読み込みます。
config/bootstrap.php
```
Plugin::load('CakePG\\CakeNews', ['bootstrap' => true, 'routes' => true]);
```

`composer.json`に下記のを追記
以下、例
```
"repositories": [
    {
        "type": "vcs",
        "no-api": true,
        "url":  "git@github.com:CakePG/CakeNews.git"
    }
],
```

その後キャッシュをクリア
```
docker-compose run --rm php php composer.phar dumpautoload
```

### テーブルを作成
```
docker-compose run --rm php php bin/cake.php migrations migrate -p CakePG/CakeNews
```

### 設定

`vendor/CakePG/CakeNews/config/news.php`をコピーして`config`に置きます。
config/bootstrap.phpに以下一行追加して読み込みます。
```
Configure::load("news");
```

#### 文言を変更する場合
`vendor/CakePG/CakeNews/src/Locale/ja_JP/cakenews.po`の内容を以下のファイルに追加してください。
`src/Locale/ja_JP/cakenews.po`（ない場合は作成）
