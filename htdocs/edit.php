<?php
    #m@gic
    require("core.php");
    global $inventory_alert,$inventory_isfixed,$dbhandle,$date_time;



#-----------------------------submit action-----------------------------
    if($_POST["inventory_mode"] != ""){
        #Post data processing
        if($_POST["inventory_name"] == ""){
            setcookie('status',3,time() + 3600);
            //header("HTTP/1.1 302");
            header("Location: ./edit.php");
            die();
        }

        $inventory_id = input_escape($_POST["inventory_id"]);
        $inventory_name = "'".input_escape($_POST["inventory_name"])."'";
        $inventory_status = input_escape($_POST["inventory_status"]);
        $inventory_alias = "'".input_escape($_POST["inventory_alias"])."'";
        $inventory_category = input_escape($_POST["inventory_category"]);
        $inventory_add_date = "'".input_escape($_POST["inventory_add_date"])."'";
        $inventory_budget = input_escape($_POST["inventory_budget"]);
        $inventory_is_fixed_asset = input_escape($_POST["inventory_is_fixed"]);
        $inventory_location = "'".input_escape($_POST["inventory_location"])."'";
        $inventory_memo = "'".input_escape($_POST["inventory_memo"])."'";
        $inventory_last_modify = "'".$date_time."'";
        $write_status = 0;

        #start transaction
        $dbhandle->querySingle("BEGIN;");

        if($_POST["inventory_mode"]== 1){
            $query = "UPDATE inventory SET  inventory_name=".$inventory_name.", inventory_status=".$inventory_status.", inventory_alias=".$inventory_alias.", inventory_category=".$inventory_category.", inventory_add_date=".$inventory_add_date.", inventory_budget=".$inventory_budget.", inventory_is_fixed_asset=".$inventory_is_fixed_asset.", inventory_location=".$inventory_location.", inventory_memo=".$inventory_memo.", inventory_last_modify=".$inventory_last_modify." WHERE inventory_id = ".$inventory_id.";";
            log_write("[SQLite3]exec:".$query);
            $result = $dbhandle->querySingle($query);
            log_write("[SQLite3]return:".$result);
            if(empty($result)){
                $write_status = 1;
            }else{
                $write_status = 2;
            }
        }else if($_POST["inventory_mode"] == 2){
            $query = "INSERT INTO inventory VALUES (".$inventory_id.",".$inventory_name.",".$inventory_status.",".$inventory_alias.",".$inventory_category.",".$inventory_add_date.",".$inventory_budget.",".$inventory_is_fixed_asset.",".$inventory_location.",".$inventory_memo.",".$inventory_last_modify.");";
            log_write("[SQLite3]exec:".$query);
            $result = $dbhandle->querySingle($query);
            log_write("[SQLite3]return:".$result);
            if(empty($result)){
                $write_status = 1;
            }else{
                $write_status = 2;
            }

        }
#-----------------------------commit or rollback-----------------------------
        if($write_status == 1){
            $dbhandle->querySingle("COMMIT;");
            setcookie('status',1,time() + 3600);
            //header("HTTP/1.1 302");
            header("Location: ./edit.php?eid=".$inventory_id);
            die();
        }else{
            $dbhandle->querySingle("ROLLBACK;");
            setcookie('status',2,time() + 3600);
            //header("HTTP/1.1 302");
            header("Location: ./edit.php");
            die();
        }
    }

#-----------------------------view-----------------------------

    $button_status = false;
    #
    if($_GET['eid'] != ""){
        $result = $dbhandle->querySingle("SELECT * from inventory WHERE inventory_id = ".$_GET["eid"].";",true);
        $inventory_edit_mode = 0;# 0=edit 1=new
        $inventory_id = $result["inventory_id"];
        $inventory_edit_mode = 1;
        if(empty($result)){
            $inventory_id = $_GET["eid"];
            $inventory_alert = MSG_ASSET_NOT_FOUND;#notfound message
            $button_status = true;
            $inventory_edit_mode = 1;
        }

    }else{
        $inventory_edit_mode = 1;
        $result = $dbhandle -> querySingle("SELECT MAX(inventory_id) FROM inventory;");
        if($result != NULL){
            $inventory_id = $result + 1;
            $inventory_edit_mode = 2;
        }else{
            $inventory_id = 1;
            $inventory_edit_mode = 2;
        }
        $inventory_alert = MSG_NEW_ASSET;

    }

    $status_items = query_to_array($dbhandle,"SELECT * FROM inventory_status;");
    $category_items = query_to_array($dbhandle,"SELECT * FROM inventory_category");
    $budget_items = query_to_array($dbhandle,"SELECT * FROM inventory_budget");


    switch($_COOKIE["status"]){
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



    #maketitle
    maketitle(basename(__FILE__));
?>
    <div class="container">
        <!-- -->
        <h1 class="page-header">物品詳細・編集</h1>
        <?php print($inventory_alert);?>
        <form method="post" action="edit.php">

            <?php
            #makeform
            #forms_hidden("inventory_verify",generate_csrf_param());
            forms_hidden("inventory_mode",$inventory_edit_mode);
            forms_textbox("inventory_id","物品ID(自動)",$inventory_id,"自動採番されます",true);
            forms_textbox("inventory_name","物品名(必須)",$result["inventory_name"]);
            forms_combobox("inventory_status","ステータス",$status_items,$result["inventory_status"]);
            forms_textbox("inventory_alias","大学資産番号",$result["inventory_alias"]);
            forms_textbox("inventory_location","保管場所",$result["inventory_location"]);
            forms_combobox("inventory_category","カテゴリ",$category_items,$result["inventory_category"]);
            forms_textbox("inventory_add_date","購入年月日",$result["inventory_add_date"]);
            forms_combobox("inventory_budget","予算区分",$budget_items,$result["inventory_budget"]);
            forms_combobox("inventory_is_fixed","動産/固定資産",$inventory_isfixed,$result["inventory_is_fixed_asset"]);
            forms_textarea("inventory_memo","メモ",$result["inventory_memo"],"ここにメモを入力");
            forms_submit("保存",$button_status);
            ?>
        </form>
    </div>

<?php makefooter(); ?>