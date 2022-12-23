<?php
    #m@gic
    require("core.php");
    global $inventory_alert,$inventory_isfixed,$dbhandle;
    #submit action
    $date_time = date("Y/m/d H:i:s");


    if($_GET["e"] = "w"){
        #Post data processing
        $inventory_id = input_escape($_POST["inventory_id"]);
        $inventory_name = "'".input_escape($_POST["inventory_name"])."'";
        $inventory_status = input_escape($_POST["inventory_status"]);
        $inventory_alias = "'".input_escape($_POST["inventory_alias"])."'";
        $inventory_category = input_escape($_POST["inventory_category"]);
        $inventory_add_date = "'".input_escape($_POST["inventory_add_date"])."'";
        $inventory_budget = input_escape($_POST["inventory_budget"]);
        $inventory_is_fixed_asset = input_escape($_POST["inventory_is_fixed"]);
        $inventory_location = "'".input_escape($_POST["inventory_location"])."'";

        if($_POST["inventory_mode"]== 0){

        }else if($_POST["inventory_mode"] == 1){
            $sql_insert_values = "(".$_POST["inventory_id"].",'" .input_escape($_POST["inventory_name"])."',".$_POST["inventory_status"].",'".input_escape($_POST["inventory_alias"])."',".$_POST["inventory_category"].",'".input_escape($_POST["inventory_add_date"])."',)";
            $dbhandle->querySingle("INSERT INTO inventory VALUES ");

        }
    }



    $button_status = false;
    #
    if($_GET['eid'] != ""){
        $result = $dbhandle->querySingle("SELECT * from inventory WHERE inventory_id = ".$_GET["eid"].";",true);
        $inventory_edit_mode = 0;# 0=edit 1=new
        if(empty($result)){
            $result['inventory_id'] = $_GET["eid"];
            $inventory_alert = MSG_ASSET_NOT_FOUND;#notfound message
            $button_status = true;
        }

    }else{
        $inventory_edit_mode = 1;
        $result = $dbhandle -> querySingle("SELECT MAX(id) FROM inventory;");
        if($result != NULL){
            $result['inventory_id'] ++;
        }else{
            $result['inventory_id'] = date("Y")*100000+1;#yyyynnnnnn
        }
        $inventory_alert = MSG_NEW_ASSET;

    }

    $status_items = query_to_array($dbhandle,"SELECT * FROM inventory_status;");
    $category_items = query_to_array($dbhandle,"SELECT * FROM inventory_category");
    $budget_items = query_to_array($dbhandle,"SELECT * FROM inventory_budget");





    #maketitle
    maketitle(basename(__FILE__));
?>
    <div class="container">
        <!-- -->
        <h1 class="page-header">物品詳細・編集</h1>
        <?php print($inventory_alert);?>
        <form method="post" action="">

            <?php
            #makeform
            #forms_hidden("inventory_verify",generate_csrf_param());
            forms_hidden("inventory_mode",$inventory_edit_mode);
            forms_textbox("inventory_id","物品ID(自動採番)",$result["inventory_id"],"自動採番されます",true);
            forms_textbox("inventory_name","物品名",$result["inventory_name"]);
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