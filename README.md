# Rese

飲食店予約サービス<br>
自社にて予約サービスを運営するため作成しました  
<br>

＜トップページ＞  <br>
店舗の一覧が表示され、お気に入りの登録・削除、店舗の検索が行えます。<br>
また、ランダム・評価の高/低で並び替えができます。<br>
<img src="https://github.com/user-attachments/assets/0c4d085e-f29a-4007-abb9-5392d16da34d" width=60%><br><br>

＜店舗詳細ページ＞<br>
店舗の詳細説明を見ることができます。この画面から日時、人数を指定して予約できます。<br>
予約来店後に店舗への口コミを投稿することができます(口コミを投稿ボタンは店舗側が来店確認をした後に表示されます)。<br>
<img src="https://github.com/user-attachments/assets/04c8e42d-2ed6-4a11-b639-5aad994aa2ef" width=50%><br>
口コミ投稿後はユーザー自身の口コミが店舗詳細ページに表示されます(口コミは１つの店舗につき１件のみ投稿可能です)。<br>
<img src="https://github.com/user-attachments/assets/04e13b09-6ef4-4cbf-9b49-5cf03f72e051" width=50%><br><br>

＜口コミ投稿用ページ＞ <br>
店舗側が来店確認をした後に評価ができるようになります。来店時の評価を★1～5・コメント・画像で評価できます。<br>
<img src="https://github.com/user-attachments/assets/5ff15982-fb41-42cb-968b-56ae826e6847" width=50%><br><br>

＜マイページ＞ <br>
ユーザー個別の予約状況とお気に入りに登録した店舗の一覧が表示されます。予約の変更や取消しが行えます。<br>
また、店舗側が来店確認をした後に支払いボタンが表示され、支払いができるようになります。<br>
<img src="https://github.com/user-attachments/assets/e405e22f-25a6-4b33-b14b-9cf25807e368" width=50%><br><br>

＜管理者用ページ＞ <br>
管理者専用の画面です。店舗代表者のアカウントを作成することができます。メールアドレスを指定してメール送信ができます。<br>
<img src="https://github.com/user-attachments/assets/23bbbed5-1d76-4040-b862-ba2318b0af65" width=50%><br><br>

＜店舗代表者用ページ＞ <br>
店舗代表者専用の画面です。管理者が店舗代表者のアカウントを作成後、店舗情報を作成・編集できます。<br>
店舗情報が未登録の場合はフォームを記入またはCSVファイルをインポートして店舗情報を作成してください。<br><br>
CSVファイルの記載項目は下記の通りです。<br>
※すべての項目は入力必須です<br>
※先頭行にはshop,area,genre,description,imageとし、２行目に該当する項目を順に記入してください
  - 店舗名(shop)：50文字以内
  - 地域(area)：「東京都」「大阪府」「福岡県」のいずれかを記入してください
  - ジャンル(genre)：「寿司」「焼肉」「イタリアン」「居酒屋」「ラーメン」のいずれかを記入してください
  - 店舗概要(description)：400文字以内
  - 画像URL(image)：URL形式、jpeg、pngのみアップロード可能です
  - 例：<br>
        shop,area,genre,description,image<br>
        寿司店サンプル,東京都,寿司,おいしいお寿司のお店,http://sample/sushi/images/example.jpeg<br>
        <img src="https://github.com/user-attachments/assets/7ba9c875-f75a-41d3-adcd-b0f6cb7ba9bb" width=50%><br>
店舗情報を作成後は編集ができます。<br>
予約一覧が表示されており、詳細ボタンから予約詳細を確認できます。<br>
<img src="https://github.com/user-attachments/assets/49d9ed48-245b-47f7-8a72-22dfca5f4d02" width=50%><br><br>

＜予約詳細ページ＞<br>
各予約の詳細を確認できます。来店確認ボタンをクリックすると、決済のための支払い額が設定できるようになります。<br>
<img src="https://github.com/user-attachments/assets/a31d4a8f-bc53-47fe-ac65-d40b009c7d24" width=30%><br>
<br>

## URL

- 本番環境：http://13.211.238.93/
- 開発環境：http://localhost/
- phpMyAdmin：http://localhost:8080/
  <br><br>

## 関連レポジトリ

https://github.com/MiyokoNakada/pro_test_Rese
<br><br>

## 機能一覧

- 会員登録・ログイン・ログアウト機能
- 飲食店一覧（検索機能、並び替え機能）
- お気に入り登録・削除
- 飲食店詳細（予約機能、口コミ一覧表示）
- マイページ（ユーザー個別の予約状況、お気に入り登録店舗)
- 予約変更・削除
- リマインドメール機能（予約当日の朝９時に店舗からQRコード付きリマインドメール）
- 口コミ投稿機能（来店後に店舗詳細画面から投稿可能）
- 決済機能（来店後にマイページから支払い可能）
- 管理者用画面（店舗代表者作成機能、メール送信機能）
- 店舗代表者用画面（店舗情報作成・更新機能、来店確認機能、支払額登録機能)
<br><br>

## 使用技術(実行環境)

- PHP 8.2.12
- Laravel 10.48.12
- MySQL 8.0.36
<br><br>

## テーブル設計
<img src="https://github.com/user-attachments/assets/398c1236-e79a-4262-9d61-89b15f12a6d1" width=50%> 

<img src="https://github.com/user-attachments/assets/05752beb-3934-4a16-95c6-54a5f50da9e6" width=50%>
<br><br>

## ER 図
<img src="https://github.com/user-attachments/assets/331dac32-2ba5-4fea-817e-c81c8422b1d6" width=70%>
<br><br>

## 環境構築

- サンプルユーザー<br>
  管理者<br>
  　Email: admin@email.com <br>
  　Password: admin_pass <br><br>
　店舗代表者(店舗名：仙人)<br>
  　Email: sennin@email.com <br>
  　Password: sennin_pass <br><br>
  一般ユーザー<br>
  　Email: test@email.com <br>
  　Password: test_pass <br><br>
   
- 開発環境はローカル、本番環境はAWSを使用しています。<br>

- メールの確認にはmailtrapを使用しています。<br>
  https://mailtrap.io/email-sandbox/<br>

- 決済にはstripeを使用しています。<br>
  https://stripe.com/jp<br>
  
### (1)開発環境のセットアップ

#### 前提条件

- Docker
- Docker Compose

#### 手順

1. リポジトリをクローン
   ```sh
   git clone git@github.com:MiyokoNakada/pro_test_Rese.git
   cd pro_test_Rese
   ```
2. Docker コンテナをビルドして起動
   ```sh
   docker-compose -f docker-compose.dev.yml up --build -d
   ```
3. .env ファイルを作成し、必要な環境変数を設定

   ```sh
   cp src/.env.example src/.env
   ```

   ```env
   APP_ENV=local
   APP_DEBUG=true
   APP_URL=http://localhost

   DB_HOST=mysql
   DB_DATABASE=laravel_db
   DB_USERNAME=laravel_user
   DB_PASSWORD=laravel_pass

   MAIL_MAILER=smtp
   MAIL_HOST=your_email_host
   MAIL_PORT=2525
   MAIL_USERNAME=your_username
   MAIL_PASSWORD=your_password
   MAIL_ENCRYPTION=
   MAIL_FROM_ADDRESS="rese@email.com"
   MAIL_FROM_NAME="${APP_NAME}"

   STRIPE_KEY=pk_test_51xxxx(your_stripe_key)
   STRIPE_SECRET=sk_test_51xxxx(your_stripe_secret_key)
   ```

4. PHP コンテナにログイン後、composer のインストール
   ```sh
   docker-compose -f docker-compose.dev.yml exec php bash
   ```
   ```php
   composer install
   ```
5. アプリケーションキーの作成
   ```php
   php artisan key:generate
   ```
6. マイグレーションの実行
   ```php
   php artisan migrate
   ```
7. シンボリックリンクの作成
   ```php
   php artisan storage:link
   ```
8. Seederデータの挿入
   ```php
   php artisan db:seed
   ```

### (2)本番環境のセットアップ

#### 前提条件

- AWS EC2 インスタンス
- AWS RDS データベース
- AWS S3 ストレージ

#### 手順

1. EC2 インスタンスを作成し、必要なソフトウェアをインストール

- Docker
- Docker-compose
- Git

2. RDS データーベース、S3バケットを作成し、作成した EC2 に接続
3. リポジトリをクローン
   ```sh
   git clone git@github.com:MiyokoNakada/pro_test_Rese.git
   cd pro_test_Rese
   ```
4. `docker/nginx/default.conf` ファイルを編集
   ```
   server_name your_ec2_instance_public_ip;
   ```
5. Docker コンテナをビルドして起動
   ```sh
   docker-compose -f docker-compose.prod.yml up --build -d
   ```
6. .env ファイルを作成し、必要な環境変数を設定

   ```sh
   cp src/.env.example src/.env
   ```

   ```env
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=http://your_ec2_instance_public_ip/

   DB_HOST=your_rds_endpoint
   DB_DATABASE=your_production_db
   DB_USERNAME=your_db_user
   DB_PASSWORD=your_db_password

   FILESYSTEM_DISK=s3

   MAIL_MAILER=smtp
   MAIL_HOST=your_email_host
   MAIL_PORT=2525
   MAIL_USERNAME=your_username
   MAIL_PASSWORD=your_password
   MAIL_ENCRYPTION=
   MAIL_FROM_ADDRESS="rese@email.com"
   MAIL_FROM_NAME="${APP_NAME}"

   AWS_ACCESS_KEY_ID=IAM_user_access_key
   AWS_SECRET_ACCESS_KEY=IAM_user_secret_access_key
   AWS_DEFAULT_REGION=aws_region
   AWS_BUCKET=your_s3_bucket_name
   AWS_URL=https://your_s3_bucket_name.s3.amazonaws.com
   AWS_USE_PATH_STYLE_ENDPOINT=false
   
   STRIPE_KEY=pk_test_51xxxx(your_stripe_key)
   STRIPE_SECRET=sk_test_51xxxx(your_stripe_secret_key)
   ```

7. PHP コンテナにログイン後、composer のインストール
   ```sh
   docker-compose -f docker-compose.prod.yml exec php bash
   ```
   ```php
   composer install
   ```   
8. S3ファイルシステムのインストール
   ```php
   composer require league/flysystem-aws-s3-v3 "^3.0" --with-all-dependencies
   ```
9. アプリケーションキーの作成
    ```php
    php artisan key:generate
    ```
10. マイグレーションの実行  
    ```php
    php artisan migrate
    ```
11. シンボリックリンクの作成
    ```php
    php artisan storage:link
    ```
12. Seederデータの挿入
    ```php
    php artisan db:seed
    ```
   

