<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING &~E_DEPRECATED);
#共通処理&環境変数
#
#
#timezone
date_default_timezone_set('Asia/Tokyo');
#env
define("APP_NAME","Inventory");
define("DB_FILE","inventory.db");

#pages
$inventory_pages[0]['script'] = "index.php";
$inventory_pages[0]['name'] = "Home";
$inventory_pages[1]['script'] = "edit.php";
$inventory_pages[1]['name'] = "物品登録・編集";
$inventory_pages[2]['script'] = "list.php";
$inventory_pages[2]['name'] = "物品一覧";

#isfixed
$inventory_isfixed[0][0] = 0;
$inventory_isfixed[0][1] = "動産";
$inventory_isfixed[1][0]= 1;
$inventory_isfixed[1][1]= "固定資産";

#message
define("MSG_ASSET_RENEW_COMPLETE",'<div class="alert alert-success" role="alert">物品情報を更新しました。</div>');
define("MSG_ASSET_NOT_FOUND",'<div class="alert alert-danger" role="alert">指定された物品IDは存在しません。</div>');

#--------------------------common--------------------------

#--------------------------maketitle--------------------------
function generate_html_header($script_name){
    print '<!DOCTYPE HTML>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    ';

    generate_title($script_name);

    print '</head>
<body>';
    generate_navbar($script_name);
}

function generate_title($script_name){
    global $inventory_pages;
    $page_title = "";
    foreach($inventory_pages as $nav_item){
        if($script_name == $nav_item["script"]){
            $page_title = $nav_item["name"];
        }

    }

    print '<title>'.$page_title.' - '.APP_NAME.'</title>';
}


function generate_navbar($script_name){
    global $inventory_pages;

    print '<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">'.APP_NAME.'</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">';

    foreach($inventory_pages as $nav_item){
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

#--------------------------form parts maker--------------------------

function forms_combobox($tag_id,$label,$itemarray,$seleteced = null){
    print '<div class="form-group"><label for="'.$tag_id.'" class="col-form-label">'.$label.'</label>
                    <select class="custom-select" id="'.$tag_id.'">';
    foreach($itemarray as $item){
        print '<option value="'.$item[0].'">'.$item[1].'</option>';
    }
    print '</select></div>';
}


function forms_textbox($tag_id,$label,$value = "",$placeholder = "",$readonly = false){

    if($readonly){
        $tag_option = "readonly";
    }

    print '<div class="form-group"><label for="'.$tag_id.'" class="col-form-label">'.$label.'</label>';
    print '<input type="text" class="form-control" id="'.$tag_id.'" placeholder="'.$placeholder.'" value="'.$value.'" '.$tag_option.'></div>';

}

function forms_textarea($tag_id,$label,$value="",$placeholder = "",$readonly = false){
    if($readonly){
        $tag_option = "readonly";
    }

    print '<div class="form-group"><label for="'.$tag_id.'" class="col-form-label">'.$label.'</label>';
    print '<textarea class="form-control" id="'.$tag_id.'" placeholder="'.$placeholder.'" value="'.$value.'" '.$tag_option.'></textarea></div>';

}

#-----------------------------database------------------------------
function db_to_array($db_input){
    if($db_input){
        $i = 0;
        while($toarraytmp = $db_input->fetchArray()){
            $db_data[$i] = $toarraytmp;
            $i++;
        }
        return $db_data;
    }else{
        return false;
    }


}