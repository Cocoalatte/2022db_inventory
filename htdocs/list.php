<?php
require("core.php");
global $isfixed_items,$dbhandle,$date_time,$status_items,$category_items,$budget_items;
maketitle(basename(__FILE__));
#maketable
$filter_status = "all";
$filter_category = "all";
$filter_division = "all";
$filter_budget = "all";

if($_POST["mode"] == 1){
    $filter_q="";
    if( $_POST["category"] != ""){
        if($_POST["category"]!= "all" ){
            $filter_category = input_escape($_POST["category"]);
            $filter_q = "WHERE inventory_category = ".$filter_category;
        }

    }
    if($_POST["status"]!= ""){
        if($_POST["status"]!= "all"){
            $filter_status = input_escape($_POST["status"]);
            if($filter_q != ""){
                $filter_q = $filter_q . " AND inventory_status = ".$filter_status;
            }else{
                $filter_q = "WHERE inventory_status =".$filter_status;
            }
        }


    }
    if($_POST["budget"]!= ""){
        if($_POST["budget"]!= "all" ){
            $filter_budget = input_escape($_POST["budget"]);
            if($filter_q != ""){
                $filter_q = $filter_q . " AND inventory_budget = ".$filter_budget;
            }else{
                $filter_q = "WHERE inventory_budget =".$filter_budget;
            }
        }

    }
    if($_POST["division"]!= ""){
        if($_POST["division"]!= "all" ){
            $filter_division = input_escape($_POST["division"]);
            if($filter_q != ""){
                $filter_q = $filter_q . " AND inventory_is_fixed_asset = ".$filter_division;
            }else{
                $filter_q = "WHERE inventory_is_fixed_asset =".$filter_division;
            }
        }

    }
}
$query = "SELECT * FROM inventory ".$filter_q." ORDER BY inventory_id ASC;";
log_write("[SQLite3] exec:".$query);
$result = query_to_array($dbhandle ,$query);
 $table_out = "";
    if($result != false){
        foreach($result as $row) {
            $inventory_status = $status_items[$row["inventory_status"]][1];
            $inventory_category = $category_items[$row["inventory_category"]][1];
            $inventory_budget = $budget_items[$row["inventory_budget"]][1];
            $inventory_is_fixed = $isfixed_items[$row["inventory_is_fixed_asset"]][1];
            $out = '<tr><th scope="row"><a href="edit.php?eid='.$row["inventory_id"].'">'.$row["inventory_id"].'</a></th><td>'.$row["inventory_name"].'</td><td>'.$inventory_status. '</td><td>'.$row["inventory_alias"]. '</td><td>'.$row["inventory_location"].'</td><td>'.$inventory_category.'</td><td>'.$row["inventory_add_date"].'</td><td>'.$inventory_budget.'</td><td>'.$inventory_is_fixed.'</td><td>'.$row["inventory_amount"].'</td><td>'.$row["inventory_last_modify"].'</td></tr>';
            $table_out = $table_out.$out."\n";

        }
    }else{
        $inventory_alert = status_msg(5);
    }




?>
<!-- filter modal -->
    <div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="filterModaltitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModaltitle">絞り込み設定(工事中)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="list.php" method="post">

                        <h3>カテゴリ</h3>
                        <?php
                            forms_hidden("mode",1);
                            if($filter_category == "all"){
                                forms_radio("s_ca","category","すべて","all",true);
                            }else{
                                forms_radio("s_ca","category","すべて","all",false);
                            }

                            foreach($category_items as $item){
                                if($filter_category == $item[0]){
                                    forms_radio("s_c".$item[0],"category",$item[1],$item[0],true);
                                }else{
                                    forms_radio("s_c".$item[0],"category",$item[1],$item[0],false);
                                }

                            }
                        ?>
                        <hr>
                        <h3>ステータス</h3>
                        <?php
                            if($filter_status == "all"){
                                forms_radio("s_sa","status","すべて","all",true);
                            }else{
                                forms_radio("s_sa","status","すべて","all",false);
                            }

                            foreach($status_items as $item){
                                if($filter_status == $item[0]){
                                    forms_radio("s_s".$item[0],"status",$item[1],$item[0],true);
                                }else{
                                    forms_radio("s_s".$item[0],"status",$item[1],$item[0],false);
                                }

                            }
                        ?>
                        <hr>
                        <h3>予算区分</h3>
                        <?php
                            if($filter_budget == "all"){
                                forms_radio("s_ba","budget","すべて","all",true);
                            }else{
                                forms_radio("s_ba","budget","すべて","all",false);
                            }

                            foreach($budget_items as $item){
                                if($filter_budget ==$item[0]){
                                    forms_radio("s_b".$item[0],"budget",$item[1],$item[0],true);
                                }else{
                                    forms_radio("s_b".$item[0],"budget",$item[1],$item[0],false);
                                }

                            }
                        ?>
                        <hr>
                        <h3>資産区分</h3>
                        <?php
                            if($filter_division == "all"){
                                forms_radio("s_dva","division","すべて","all",true);
                            }else{
                                forms_radio("s_dva","division","すべて","all",false);
                            }

                            foreach($isfixed_items as $item){
                                if($filter_division == $item[0]){
                                    forms_radio("s_dv".$item[0],"division",$item[1],$item[0],true);
                                }else{
                                    forms_radio("s_dv".$item[0],"division",$item[1],$item[0],false);
                                }

                            }
                        ?>

                </div>
                <div class="modal-footer">

                    <?php
                        forms_submit("決定");
                    ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <!-- -->
        <?php print($inventory_alert);?>
        <h1 class="page-header">物品一覧</h1>

        物品番号を押すと詳細閲覧・編集ができます。<br>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#filterModal">
            絞り込み設定
        </button>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th scope="col">物品番号</th>
                    <th scope="col">物品名</th>
                    <th scope="col">ステータス</th>
                    <th scope="col">大学資産番号</th>
                    <th scope="col">保管場所</th>
                    <th scope="col">カテゴリ</th>
                    <th scope="col">購入年月日</th>
                    <th scope="col">予算区分</th>
                    <th scope="col">資産区分</th>
                    <th scope="col">取得金額</th>
                    <th scope="col">最終更新日</th>
                </tr>
                </thead>
                <tbody>
                    <?php print($table_out);?>
                </tbody>
            </table>

        </div>
    </div>
<?php
makefooter();
?>
