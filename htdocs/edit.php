<?php
    #m@gic
    require("core.php");
    global $inventory_alert,$isfixed_items,$dbhandle,$date_time,$status_items,$category_items,$budget_items;
    $renew_error_exit = false;


#-----------------------------submit action-----------------------------
    if($_POST["inventory_mode"] != ""){
        #Post data processing
        if($_POST["inventory_name"] == ""){
            $inventory_alert = status_msg(3);
            $renew_error_exit =true;
        }else if(!is_numeric($_POST["inventory_amount"])){
            $inventory_alert = status_msg(4);
            $renew_error_exit =true;
        }else{
            $inventory_id = input_escape($_POST["inventory_id"]);
            $inventory_name = "'".input_escape($_POST["inventory_name"])."'";
            $inventory_status = input_escape($_POST["inventory_status"]);
            $inventory_alias = "'".input_escape($_POST["inventory_alias"])."'";
            $inventory_category = input_escape($_POST["inventory_category"]);
            $inventory_add_date = "'".input_escape($_POST["inventory_add_date"])."'";
            $inventory_budget = input_escape($_POST["inventory_budget"]);
            $inventory_is_fixed_asset = input_escape($_POST["inventory_is_fixed"]);
            $inventory_location = "'".input_escape($_POST["inventory_location"])."'";
            $inventory_amount = input_escape($_POST["inventory_amount"]);
            $inventory_memo = "'".input_escape($_POST["inventory_memo"])."'";
            $inventory_last_modify = "'".$date_time."'";
            $write_status = 0;

            #start transaction
            $dbhandle->querySingle("BEGIN;");

            if($_POST["inventory_mode"]== 1){
                $query = "UPDATE inventory SET  inventory_name=".$inventory_name.", inventory_status=".$inventory_status.", inventory_alias=".$inventory_alias.", inventory_category=".$inventory_category.", inventory_add_date=".$inventory_add_date.", inventory_budget=".$inventory_budget.", inventory_is_fixed_asset=".$inventory_is_fixed_asset.", inventory_location=".$inventory_location.", inventory_memo=".$inventory_memo.", inventory_last_modify=".$inventory_last_modify.", inventory_amount=".$inventory_amount." WHERE inventory_id = ".$inventory_id.";";
                log_write("[SQLite3]exec:".$query);
                $result = $dbhandle->querySingle($query);
                log_write("[SQLite3]return:".$result);
                if(empty($result)){
                    $write_status = 1;
                }else{
                    $write_status = 2;
                }
            }else if($_POST["inventory_mode"] == 2){
                $query = "INSERT INTO inventory VALUES (".$inventory_id.",".$inventory_name.",".$inventory_status.",".$inventory_alias.",".$inventory_category.",".$inventory_add_date.",".$inventory_budget.",".$inventory_is_fixed_asset.",".$inventory_location.",".$inventory_memo.",".$inventory_amount.",".$inventory_last_modify.");";
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
                redirect302("./edit.php?eid=".$inventory_id);
            }else{
                $dbhandle->querySingle("ROLLBACK;");
                $inventory_alert = status_msg(3);
                $renew_error_exit =true;

            }
        }
    }



#-----------------------------view-----------------------------

    $button_status = false;
    if($renew_error_exit ==false){
        $inventory_alert = status_msg($_COOKIE["status"]);
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
    }






    #maketitle
    maketitle(basename(__FILE__));
?>
    <div class="container">
        <!-- -->
        <?php print($inventory_alert);?>
        <h1 class="page-header">物品詳細・編集</h1>



        <form method="post" action="edit.php">

            <?php
            #makeform
            #forms_hidden("inventory_verify",generate_csrf_param());
            forms_hidden("inventory_mode",$inventory_edit_mode);
            forms_textbox("inventory_id","物品ID(自動)",$inventory_id,"自動採番されます",true);
            forms_textbox("inventory_name","物品名",$result["inventory_name"],"",false,true);
            forms_combobox("inventory_status","ステータス",$status_items,$result["inventory_status"]);
            forms_textbox("inventory_alias","大学資産番号",$result["inventory_alias"]);
            forms_textbox("inventory_location","保管場所",$result["inventory_location"]);
            forms_combobox("inventory_category","カテゴリ",$category_items,$result["inventory_category"]);
            forms_datebox("inventory_add_date","購入年月日",$result["inventory_add_date"]);
            forms_combobox("inventory_budget","予算区分",$budget_items,$result["inventory_budget"]);
            forms_combobox("inventory_is_fixed","資産区分",$isfixed_items,$result["inventory_is_fixed_asset"]);
            forms_numberbox("inventory_amount","取得金額",$result["inventory_amount"],"",false,true);
            forms_textarea("inventory_memo","メモ",$result["inventory_memo"],"ここにメモを入力");
            forms_textbox("inventory_last_modify","最終更新日時",$result["inventory_last_modify"],"",true);
            forms_submit("保存",$button_status);
            ?>
        </form>
    </div>

<?php makefooter(); ?>