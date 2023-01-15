# これなに
大学の課題で作成したプログラムです。MITとしますので自由に使ってください。
# 実行方法
## (docker/非docker共通)データベースの初期化
`htdocs`内に`inventory.db`をsqlite3を使って作成してください。作成後、`htdocs`内にある`init.sql`を`inventory.db`に流し込んでください。
## dockerを使った実行方法
dockerを使って実行する場合は、Dockerの環境を整えた後、`docker-compose.yml`が入っているディレクトリ内で`docker-compose up -d`を実行してください。
成功すると、localhost:8090からUIにアクセスできるようになります。ポートに不都合がある場合は`docker-compose.yml`を書き換えてください。
## dockerを使わない方法
任意のPHPが実行可能なWebサーバのドキュメントルート内に`htdocs`に入っているものをすべて`inventory.db`ごと置いてください。
このとき、`inventory.db`に読み書きが行えるように権限を忘れずに設定してください。
