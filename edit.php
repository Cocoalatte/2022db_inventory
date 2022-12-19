<?php

    require("env.php");
    global $inventory_alert,$inventory_isfixed;
    $dbhandle = new SQLite3(DB_FILE);
    #
    if($_GET['eid'] != ""){
        $result = $dbhandle->querySingle("SELECT * from inventory WHERE inventory_id = ".$_GET["eid"].";",true);

        if(empty($result)){
            $inventory_alert = MSG_ASSET_NOT_FOUND;#notfound
        }

    }else{
        $result = $dbhandle -> querySingle("SELECT MAX(id) FROM inventory;");
        if($result != NULL){
            $result['inventory_id'] ++;
        }else{
            $result['inventory_id'] = date("Y")*100000+1;
        }

    }
    $status_items = db_to_array($dbhandle->query("SELECT * FROM inventory_status;"));
    $category_items = db_to_array($dbhandle->query("SELECT * FROM inventory_category;"));
    $budget_items = db_to_array($dbhandle->query("SELECT * FROM inventory_budget;"));






    #maketitle
    generate_html_header(basename(__FILE__));
?>
    <div class="container">
        <!-- -->
        <h1 class="page-header">物品詳細・編集</h1>
        <?php print($inventory_alert);?>
        <form>



            <?php
            forms_textbox("inventory_id","物品ID","","自動採番されます",true);
            forms_textbox("inventory_name","物品名","");
            forms_combobox("inventory_status","ステータス",$status_items);
            forms_textbox("inventory_alias","大学資産番号","");
            forms_textbox("inventory_location","保管場所","");
            forms_combobox("inventory_category","カテゴリ",$category_items);
            forms_textbox("inventory_add_date","購入年月日","");
            forms_combobox("inventory_budget","予算区分",$budget_items);
            forms_combobox("inventory_is_fixed","動産/固定資産",$inventory_isfixed);
            forms_textarea("inventory_memo","メモ","","ここにメモを入力")
            ?>
            <button type="submit" class="btn btn-primary">保存</button>
        </form>
    </div>

</body>
</html>