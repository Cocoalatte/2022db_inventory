<?php require("core.php");
global $dbhandle,$category_items,$budget_items,$isfixed_items;


if($_POST["inventory_mode"]!= ""){
    $item = input_escape($_POST["add_item"]);
    $dbhandle->querySingle("BEGIN;");
    switch ($_POST["inventory_mode"]){
        case "category":
            if(!empty($category_items)){
                $eid = $category_items[array_key_last($category_items)][0];
                $eid++;
            }else{
                $eid =0;
            }
            $result = $dbhandle -> querySingle('INSERT INTO inventory_category VALUES ('.$eid.',"'.$item.'")');
            if(empty($result)){
                $write_status = 1;
            }else{
                $write_status = 2;
            }
            break;
        case "budget":
            if(!empty($budget_items)){
                $eid = $budget_items[array_key_last($budget_items)][0];
                $eid++;
            }else{
                $eid =0;
            }
            $result = $dbhandle -> querySingle('INSERT INTO inventory_budget VALUES ('.$eid.',"'.$item.'")');
            if(empty($result)){
                $write_status = 1;
            }else{
                $write_status = 2;
            }
            break;
        case "isfixed":
            if(!empty($isfixed_items)){
                $eid = $isfixed_items[array_key_last($isfixed_items)][0];
                $eid++;
            }else{
                $eid =0;
            }
            $result = $dbhandle -> querySingle('INSERT INTO inventory_asset_division VALUES ('.$eid.',"'.$item.'")');
            if(empty($result)){
                $write_status = 1;
            }else{
                $write_status = 2;
            }
            break;



    }

    if($write_status == 1){
        $dbhandle->querySingle("COMMIT;");
        setcookie('status',1,time() + 3600);
        //header("HTTP/1.1 302");
        redirect302("./settings.php");
    }else{
        $dbhandle->querySingle("ROLLBACK;");
        setcookie('status',2,time() + 3600);
        $inventory_alert = MSG_WRITE_FAILED_BUSY;

    }
}



$table_out_category = "";
$table_out_budget = "";
$table_out_isfixed = "";


foreach($category_items as $out){
    $table_out_category = $table_out_category.'<tr><td>'.$out[0].'</td><td>'.$out[1].'</td></tr>';
}
foreach($budget_items as $out){
    $table_out_budget = $table_out_budget.'<tr><td>'.$out[0].'</td><td>'.$out[1].'</td></tr>';
}
foreach($isfixed_items as $out){
    $table_out_isfixed = $table_out_isfixed.'<tr><td>'.$out[0].'</td><td>'.$out[1].'</td></tr>';
}

$inventory_alert = status_msg($_COOKIE["status"]);
#maketitle
maketitle(basename(__FILE__));

?>

    <div class="container">
        <?php print($inventory_alert);?>
        <h1 class="page-header">各種設定</h1><hr>
        <h2>カテゴリ追加</h2>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">カテゴリ名</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php print($table_out_category);?>
                    </tbody>
                </table>
                <form method="post" action="settings.php">
                    <?php

                        forms_hidden("inventory_mode","category");
                        forms_textbox("add_item","追加するカテゴリ","","追加したいカテゴリ名を入力",false,true);
                        forms_submit("保存");
                    ?>
                </form>
            </div>
        <h2>予算区分追加</h2>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">区分名</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php print($table_out_budget);?>
                    </tbody>
                </table>
                <form method="post" action="settings.php">
                    <?php

                    forms_hidden("inventory_mode","budget");
                    forms_textbox("add_item","追加する予算区分","","追加したい区分名を入力",false,true);
                    forms_submit("保存");
                    ?>
                </form>
            </div>
        <h2>資産区分追加</h2>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">区分名</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php print($table_out_isfixed);?>
                    </tbody>
                </table>
                <form method="post" action="settings.php">
                    <?php

                    forms_hidden("inventory_mode","isfixed");
                    forms_textbox("add_item","追加する資産区分","","追加したい区分名を入力",false,true);
                    forms_submit("保存");
                    ?>
                </form>
            </div>
    </div>

<?php makefooter() ?>