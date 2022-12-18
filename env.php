<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
#共通処理&環境変数
#
#

#env
define("APP_NAME","Inventory");
define("DB_FILE","inventory.db");

#for dynamic navbar
$inventory_navbar['0']['script'] = "index.php";
$inventory_navbar['0']['name'] = "Home";
$inventory_navbar['1']['script'] = "edit.php";
$inventory_navbar['1']['name'] = "新規物品登録";
$inventory_navbar['2']['script'] = "list.php";
$inventory_navbar['2']['name'] = "物品一覧";



#common

#cocoroconect
function sqlite_connect(){
    $db = sqlite_open(DB_FILE, 0666);
    if (!$db) {
        #fault
        return false;
    } else {
        return $db;
    }
}

#cocoroshutout


#dynamic~~chord~~ navbar
function generate_navbar($script_name){
    global $inventory_navbar;

    print '<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">'.APP_NAME.'</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">';

    foreach($inventory_navbar as $nav_item){
        if($script_name == $nav_item["script"]){
            $nav_item_class = 'nav-item active';
        }else{
            $nav_item_class = 'nav-item';
        }
        print '<li class="'.$nav_item_class.'">
                <a class="nav-link" href="'.$nav_item["script"].'">'.$nav_item["name"].'</a>
            </li>';
    }


    print '</ul></div></nav>';

}