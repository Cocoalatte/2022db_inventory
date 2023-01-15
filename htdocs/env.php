<?php
#config
#timezone
date_default_timezone_set('Asia/Tokyo');
#application name
define("APP_NAME","Inventory");
#database file
define("DB_FILE","inventory.db");

#pages
$inventory_pages[0]['script'] = "index.php";
$inventory_pages[0]['name'] = "Home";
$inventory_pages[1]['script'] = "edit.php";
$inventory_pages[1]['name'] = "物品登録";
$inventory_pages[2]['script'] = "list.php";
$inventory_pages[2]['name'] = "物品一覧";
$inventory_pages[3]['script'] = "settings.php";
$inventory_pages[3]['name'] = "設定";




#message
define("MSG_ASSET_RENEW_COMPLETE",'<div class="alert alert-success" role="alert">更新に成功しました。</div>');
define("MSG_ASSET_NOT_FOUND",'<div class="alert alert-danger" role="alert">指定された物品IDは存在しません。</div>');
define("MSG_NEW_ASSET",'<div class="alert alert-info" role="alert">物品を新規登録します。</div>');
define("MSG_WRITE_FAILED_BUSY",'<div class="alert alert-danger" role="alert">情報の更新に失敗しました。(他のユーザが更新中、もしくはその他の理由により書き込めませんでした)</div>');
define("MSG_WRITE_FAILED_NAME_NULL",'<div class="alert alert-danger" role="alert">物品名が入力されていません。</div>');
define("MSG_ITEM_EMPTY",'<div class="alert alert-danger" role="alert">データが存在しません</div>');
