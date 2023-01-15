<?php
#talisman
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING &~E_DEPRECATED);
#
#
#
require("env.php");
global $inventory_pages;

$date_time = date("Y-m-d H:i:s");
#--------------------------common--------------------------

#--------------------------maketitle--------------------------
function maketitle($script_name):void{
    print ('<!DOCTYPE HTML>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    ');

    generate_title($script_name);

    print ('</head><body>');
    generate_navbar($script_name);
}


function generate_title($script_name):void{
    global $inventory_pages;
    $page_title = "";
    foreach($inventory_pages as $nav_item){
        if($script_name == $nav_item["script"]){
            $page_title = $nav_item["name"];
        }

    }

    print ('<title>'.$page_title.' - '.APP_NAME.'</title>');
}


function generate_navbar($script_name): void{
    global $inventory_pages;

    print ('<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">'.APP_NAME.'</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">');

    foreach($inventory_pages as $nav_item){
        if($script_name == $nav_item["script"]){
            $nav_item_class = 'nav-item active';
        }else{
            $nav_item_class = 'nav-item';
        }
        print ('<li class="'.$nav_item_class.'">
                <a class="nav-link" href="'.$nav_item["script"].'">'.$nav_item["name"].'</a>
            </li>');
    }


    print ('</ul></div></nav>');

}

function makefooter():void{
    print ('</body></html>');
}

#--------------------------form parts maker--------------------------

function forms_combobox($tag_id,$label,$itemarray,$seleteced = null):void{
    print ('<div class="form-group row"><label for="'.$tag_id.'" class="col-form-label col-sm-2">'.$label.'</label>
                    <select name="'.$tag_id.'" class="custom-select  col-sm-8" id="'.$tag_id.'">');
    foreach($itemarray as $item){
        if($seleteced == $item[0]){
            print ('<option value="'.$item[0].'" selected>'.$item[1].'</option>');
        }else{
            print ('<option value="'.$item[0].'">'.$item[1].'</option>');
        }

    }
    print ('</select></div>');
}


function forms_textbox($tag_id,$label,$value = "",$placeholder = "",$readonly = false,$required = false):void{

    if($readonly){
        $tag_option = "readonly";
    }
    if($required){
        $tag_option = $tag_option." required";
        $req_mark ='<span class="badge badge-danger">必須</span>';
    }

    print ('<div class="form-group row"><label for="'.$tag_id.'" class="col-form-label col-sm-2">'.$label.' '.$req_mark.'</label>');
    print ('<input type="text" name="'.$tag_id.'" class="form-control col-sm-8" id="'.$tag_id.'" placeholder="'.$placeholder.'" value="'.$value.'" '.$tag_option.'></div>');

}
function forms_datebox($tag_id,$label,$value = "",$placeholder = "",$readonly = false,$required = false):void{

    if($readonly){
        $tag_option = "readonly";
    }
    if($required){
        $tag_option = $tag_option." required";
        $req_mark ='<span class="badge badge-danger">必須</span>';
    }

    print ('<div class="form-group row"><label for="'.$tag_id.'" class="col-form-label col-sm-2">'.$label.' '.$req_mark.'</label>');
    print ('<input type="date" name="'.$tag_id.'" class="form-control  col-sm-8" id="'.$tag_id.'" placeholder="'.$placeholder.'" value="'.$value.'" '.$tag_option.'></div>');

}

function forms_textarea($tag_id,$label,$value="",$placeholder = "",$readonly = false,$required = false):void{
    if($readonly){
        $tag_option = "readonly";
    }
    if($required){
        $tag_option = $tag_option." required";
        $req_mark ='<span class="badge badge-danger">必須</span>';
    }

    print ('<div class="form-group row"><label for="'.$tag_id.'" class="col-form-label col-sm-2">'.$label.' '.$req_mark.'</label>');
    print ('<textarea class="form-control col-sm-8" name="'.$tag_id.'" id="'.$tag_id.'" placeholder="'.$placeholder.'" '.$tag_option.'>'.$value.'</textarea></div>');

}

function forms_hidden($tag_id,$value = ""):void{
    print ('<input type="hidden" name="'.$tag_id.'" value="'.$value.'">');
}


function forms_submit($label,$disabled=false): void{
    if($disabled){
        print ('<button type="submit" class="btn btn-secondary" disabled>'.$label.'</button>');
    }else{
        print ('<button type="submit" class="btn btn-primary">'.$label.'</button>');
    }
}

#-----------------------------database-----------------------------
#cocoroconect
if(file_exists(DB_FILE)){
    $dbhandle = new SQLite3(DB_FILE);
}else{
    die("データベースに接続できません");
}


$status_items = query_to_array($dbhandle,"SELECT * FROM inventory_status;");
$category_items = query_to_array($dbhandle,"SELECT * FROM inventory_category;");
$budget_items = query_to_array($dbhandle,"SELECT * FROM inventory_budget;");
$isfixed_items = query_to_array($dbhandle,"SELECT * FROM inventory_asset_division;");


#to support PDO in the future
function query_to_array($dbhandle_,$sql): bool|array{
    return db_to_array($dbhandle_->query($sql));
}

function db_to_array($db_input): bool|array{
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

function input_escape($in){
    return SQLite3::escapeString($in);
}


function log_write($text):void{
    global $date_time;
    $fp=fopen("logs.log","a");
    fwrite($fp,$date_time.": ". $text."\n");
    fclose($fp);
}


#CSRF

/*
function generate_csrf_param(): string{
    global $dbhandle;
    $chkhash = hash("sha256",uniqid("",true));

    $dbhandle->querySingle("INSERT INTO inventory_csrf_chk VALUES ('".$chkhash."',0);");
    return $chkhash;
}

function csrf_make_used($param):void{
    global $dbhandle;
    $dbhandle->querySingle("UPDATE inventory_csrf_chk SET inventory_csrf_used = 1 WHERE inventory_csrf_hash ='".$param."';");
}


function csrf_is_used($param):bool{
    global $dbhandle;
    $result = $dbhandle->querySingle("SELECT inventory_csrf_used FROM inventory_csrf_chk WHERE inventory_csrf_hash = '".$param."';");
    if($result == 1){
        return true;
    }else{
        return false;
    }
}
*/

#--------action------

function redirect302($url):void{
    header("Location: ".$url);
    die();
}

function status_msg($status_code = 0):string{
    if($status_code != 0 && $status_code != ""){
        switch($status_code){
            case 1:
                $inventory_alert = MSG_ASSET_RENEW_COMPLETE;
                break;
            case 2:
                $inventory_alert = MSG_WRITE_FAILED_BUSY;
                break;
            case 3:
                $inventory_alert = MSG_WRITE_FAILED_NAME_NULL;
                break;
        }
        setcookie('status',0,time() + 3600);
        return $inventory_alert;
    }else{
        return "";
    }

}
