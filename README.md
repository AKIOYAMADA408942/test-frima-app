# Coahchtechフリマ

Coachtech模擬案件用のフリマアプリです。  

## 1 環境構築
1.1〜1.5までの環境環境構築を行なって下さい。

### 1.1 Dockerビルド
    1.コマンドラインにてディレクトリを指定およびDockerDesktopを立ち上げる。
    2.リポジトリをクローンする。
        git clone git@github.com:AKIOYAMADA408942/test-frima-app.git
    3.ディレクトリに移動
        cd test-frima-app
    4.コンテナの生成および起動
        docker compose up -d --build  

### 　1.2 Laravel 環境構築  
    
    1.PHPコンテナに入る
        docker compose exec php bash
    2.Composer パッケージのインストール
        composer install
    3. .env.example ファイルをコピーして .env ファイルを作成
        cp .env.example .env
    4. .env ファイルのデータベース設定を下記に変更
        DB_CONNECTION=mysql
        DB_HOST=mysql
        DB_PORT=3306
        DB_DATABASE=laravel_db
        DB_USERNAME=laravel_user
        DB_PASSWORD=laravel_pass
    5.laravelアプリケーションキーの生成
        php artisan key:generate
    6.データベースのマイグレーション
        php artisan migrate
    7.データベースに初期データの挿入
        php artisan db:seed
    8.シンボリックリンクの設定
        php artisan storage:link

初期データについて  
CategoryTableSeederクラスはアプリの動作に必要なカテゴリのデータの挿入になりますので必ず実行して下さい。

### 1.3 Stripe決済
    本アプリはstripe決済を利用しています.  
    https://stripe.com/jp にアクセスして、Stripeのアカウントを作成して下さい。作成後、2点の設定を行ってください。  

        1. Stripeにログインし、コンビニ支払いを有効にして下さい。順にクリック(ダッシュボードから設定(歯車)→製品の設定欄から決済→決済手段→コンビニ支払いを有効)  
        2. ダッシュボードからAPIキーを確認して .envファイルに下記欄を追記して下さい。

        STRIPE_KEY=　(公開キー)　　　　　
        STRIPE_SECRET_KEY= (シークレットキー)

### 1.4 メール送信および認証
メール送信および認証にmailtrapを使用しました。https://mailtrap.io/ja からアクセスしてアカウント登録をお願いします。ログインしたらサイドバーの「sandboxes」をクリック、「MyInbox」をクリック「Integrations」から「sample code」欄から「laravel7.x and 8.x」を選択し、記載のある下記項目1をコピーして　.envファイルに上書きしてください。項目2も任意で架空のメールアドレスを記述してください

項目1  
MAIL_MAILER=  
MAIL_HOST=  
MAIL_PORT=  
MAIL_USERNAME=  
MAIL_PASSWORD=  
MAIL_ENCRYPTION=  

項目2  
MAIL_FROM_ADDRESS=  

### 1.5 PHPUnit
テスト用のデータベースの作成および設定をします。  
1.mysql コンテナ上でrootユーザーでログイン  

    mysql -u root -p

2.passwordは[ root ]でログインし、テスト用データベース
(demo_test)の作成  

    CREATE DATABASE demo_test;

3.phpコンテナ内でテスト用のマイグレーションを実行  

    php artisan migrate --env=testing

4.　.env.testingファイルでAPP_KEY=　の値が空であることを確認してテスト用のlaravelアプリケーションキーを作成  

    php artisan key:generate --env=testing

## 2　テスト
試験的に動かす際、2.1〜2.4までお読みの上、動かして下さい。

### 2.1 商品のダミーデータについて
下記、商品のダミーデータになります。  
| 商品ID | 商品名           | 価格   | 商品説明                               | コンディション       |
| ------ | ---------------- | ------ | -------------------------------------- | -------------------- |
| CO01   | 腕時計           | 15,000 | スタイリッシュなデザインのメンズ腕時計 | 良好                 |
| CO02   | HDD              | 5,000  | 高速で信頼性の高いハードディスク       | 目立った傷や汚れなし |
| CO03   | 玉ねぎ3束        | 300    | 新鮮な玉ねぎ3束のセット                | やや傷や汚れあり     |
| CO04   | 革靴             | 4,000  | クラシックなデザインの革靴             | 状態が悪い           |
| CO05   | ノートPC         | 45,000 | 高性能なノートパソコン                 | 良好                 |
| CO06   | マイク           | 8,000  | 高音質のレコーディング用マイク         | 目立った傷や汚れなし |
| CO07   | ショルダーバッグ | 3,500  | おしゃれなショルダーバッグ             | やや傷や汚れあり     |
| CO08   | タンブラー       | 500    | 使いやすいタンブラー                   | 状態が悪い           |
| CO09   | コーヒーミル     | 4,000  | 手動のコーヒーミル                     | 良好                 |
| CO10   | メイクセット     | 2,500  | 便利なメイクアップセット               | 目立った傷や汚れなし |

### 2.2 テストアカウント
メール認証済のテストアカウントを３つ用意しましたのでご活用ください。
下記、2.1の表にある商品５点ずつを出品したユーザー２名と出品なしのユーザー1名となります。

名前:test1  
Email: test1@example.com  
password: password  
出品した商品ID: C01〜C05  

名前:test2  
Email: test2@example.com  
password: password  
出品した商品ID: C06〜C10  

名前:test3  
Email: test3@example.com  
password: password

### 2.3 Stripe決済におけるテスト

カード支払いでテストする場合、https://docs.stripe.com/testing からテストカードの記載がありますのでご確認ください。

コンビニ支払いでテストする場合、印刷画面まで遷移したら、支払い完了は出来ないため、http://localhost//purchase/{item_id}/success からitem_idを指定して決済を完了して下さい。

### 2.4 PHPを用いたテスト
以下のテストを用意しました。各テスト終了毎にテーブルのドロップおよびマイグレーションを行います。

* 会員登録機能 (RegisterUserTest.php)
* ログイン登録機能 (LoginTest.php)
* ログアウト機能 (LogoutTest.php)
* 商品一覧取得 (ListItemTest.php)
* マイリスト一覧取得 (MylistTest.php)
* 商品検索機能 (SearchTest.php)
* 商品詳細情報取得 (DetailItemTest.php)
* いいね機能 (LikeTest.php)
* コメント送信機能 (CommentTest.php)
* 商品購入機能 (PurchaseTest.php)
* 支払い方法選択機能(未実装)(PaymentMethodTest.php(laravel dusk))
* 配送先変更機能 (AddressTest.php)
* ユーザー情報取得 (GetProfileTest.php)
* ユーザー情報変更 (EditProfileTest.php)
* 出品商品情報登録 (SellTest.php)

各機能テストはphpコンテナ内で下記に上記の()内のファイル名を入れて実行して下さい。

    vendor/bin/phpunit tests/Feature/ファイル名

全てのテストを実行

    vendor/bin/phpunit

## 3 使用技術
DockerCompose 3.8  
laravel 8.83.29  
PHP 7.4.9  
nginx 1.21  
MySQL 8.0.26  
laravel Fortify  
Stripe  
Mailtrap  
laravel dusk  

## 4 ER図
![Alt text](<ER .png>)

## 5 データテーブル
| テーブル名                    | カラム名                  | 型              | PRIMARY KEY | UNIQUE KEY | NOT NULL | FOREIGN KEY    |
| ----------------------------- | ------------------------- | --------------- | ----------- | ---------- | -------- | -------------- |
| usersテーブル                 | id                        | unsigned bigint | ○           |            | ○        |                |
|                               | name                      | string          |             |            | ○        |                |
|                               | email                     | string          |             | ○          | ○        |                |
|                               | email_verified_at         | timestamp       |             |            |          |                |
|                               | password                  | varchar(255)    |             |            | ○        |                |
|                               | two_factor_secret         | text            |             |            |          |                |
|                               | two_facror_recovery_codes | text            |             |            |          |                |
|                               | rememberToken             | varchar(100)    |             |            |          |                |
|                               | created_at                | timestamp       |             |            |          |                |
|                               | updated_at                | timestamp       |             |            |          |                |
|                               | postal_code               | varchar(255)    |             |            |          |                |
|                               | thubmnail_path            | varchar(255)    |             |            |          |                |
|                               | adress                    | varchar(255)    |             |            |          |                |
|                               | building                  | varchar(255)    |             |            |          |                |
| テーブル名                    | カラム名                  | 型              | PRIMARY KEY | UNIQUE KEY | NOT NULL | FOREIGN KEY    |
| itemsテーブル                 | id                        | unsigned bigint | ○           |            | ○        |                |
|                               | user_id                   | unsigned bigint |             |            | ○        | users(id)      |
|                               | name                      | varchar(255)    |             |            | ○        |                |
|                               | condition                 | varchar(255)    |             |            | ○        |                |
|                               | brand                     | varchar(255)    |             |            |          |                |
|                               | content                   | text            |             |            | ○        |                |
|                               | price                     | unsigned bigint |             |            | ○        |                |
|                               | img_path                  | varchar(255)    |             |            | ○        |                |
|                               | created_at                | timestamp       |             |            |          |                |
|                               | updated_at                | timestamp       |             |            |          |                |
| テーブル名                    | カラム名                  | 型              | PRIMARY KEY | UNIQUE KEY | NOT NULL | FOREIGN KEY    |
| categoriesテーブル            | id                        | unsigned bigint | ○           |            | ○        |                |
|                               | name                      | varchar(255)    |             | ○          | ○        |                |
|                               | created_at                | timestamp       |             |            |          |                |
|                               | updated_at                | timestamp       |             |            |          |                |
| テーブル名                    | カラム名                  | 型              | PRIMARY KEY | UNIQUE KEY | NOT NULL | FOREIGN KEY    |
| category_itemテーブル         | id                        | unsigned bigint | ○           |            | ○        |                |
|                               | category_id               | unsigned bigint |             |            | ○        | categories(id) |
|                               | item_id                   | unsigned bigint |             |            | ○        | items(id)      |
|                               | created_at                | timestamp       |             |            |          |                |
|                               | updated_at                | timestamp       |             |            |          |                |
| テーブル名                    | カラム名                  | 型              | PRIMARY KEY | UNIQUE KEY | NOT NULL | FOREIGN KEY    |
| likesテーブル                 | id                        | unsigned bigint | ○           |            | ○        |                |
|                               | user_id                   | unsigned bigint |             |            | ○        | users(id)      |
|                               | item_id                   | unsigned bigint |             |            | ○        | items(id)      |
|                               | created_at                | timestamp       |             |            |          |                |
|                               | updated_at                | timestamp       |             |            |          |                |
| テーブル名                    | カラム名                  | 型              | PRIMARY KEY | UNIQUE KEY | NOT NULL | FOREIGN KEY    |
| commentsテーブル              | id                        | unsigned bigint | ○           |            | ○        |                |
|                               | user_id                   | unsigned bigint |             |            | ○        | users(id)      |
|                               | item_id                   | unsigned bigint |             |            | ○        | items(id)      |
|                               | content                   | text            |             |            | ○        |                |
|                               | created_at                | timestamp       |             |            |          |                |
|                               | updated_at                | timestamp       |             |            |          |                |
| テーブル名                    | カラム名                  | 型              | PRIMARY KEY | UNIQUE KEY | NOT NULL | FOREIGN KEY    |
| purchasesテーブル             | id                        | unsigned bigint | ○           |            | ○        |                |
|                               | user_id                   | unsigned bigint |             |            | ○        | users(id)      |
|                               | item_id                   | unsigned bigint |             |            | ○        | items(id)      |
|                               | payment_method            | varchar(255)    |             |            | ○        |                |
|                               | address                   | varchar(255)    |             |            | ○        |                |
|                               | building                  | varchar(255)    |             |            | ○        |                |
|                               | postal_code               | varchar(255)    |             |            | ○        |                |
|                               | created_at                | timestamp       |             |            |          |                |
|                               | updated_at                | timestamp       |             |            |          |                |
|                               | transaction_completed_at  | datetime        |             |            |          |                |
| テーブル名                    | カラム名                  | 型              | PRIMARY KEY | UNIQUE KEY | NOT NULL | FOREIGN KEY    |
| trading_chat_messagesテーブル | id                        | unsigned bigint | ○           |            | ○        |                |
|                               | purchase_id               | unsigned bigint |             |            | ○        | purchases(id)  |
|                               | sender_id                 | unsigned bigint |             |            | ○        | users(id)      |
|                               | content                   | text            |             |            | ○        |                |
|                               | chatting_image_path       | varchar(255)    |             |            |          |                |
|                               | is_read                   | tinyint(1)      |             |            |          |                |
|                               | created_at                | timestamp       |             |            |          |                |
|                               | updated_at                | timestamp       |             |            |          |                |
| テーブル名                    | カラム名                  | 型              | PRIMARY KEY | UNIQUE KEY | NOT NULL | FOREIGN KEY    |
| reviewsテーブル               | id                        | unsigned bigint | ○           |            | ○        |                |
|                               | purchase_id               | unsigned bigint |             |            | ○        | purchases(id)  |
|                               | reviewer_id               | unsigned bigint |             |            | ○        | users(id)      |
|                               | reviewee_id               | unsigned bigint |             |            | ○        | users(id)      |
|                               | score                     | tinyint         |             |            | ○        |                |
|                               | created_at                | timestamp       |             |            |          |                |
|                               | updated_at                | timestamp       |             |            |          |                |
## 6 URL
* 開発環境 http://localhost/
* phpMyAdmin http://localhost:8080/
* Mailtrap https://mailtrap.io/ja 
* Stripe  https://stripe.com/jp 



