<?php
require("core.php");
global $inventory_isfixed,$dbhandle,$date_time;
maketitle(basename(__FILE__));
#maketable

$status_items = query_to_array($dbhandle,"SELECT * FROM inventory_status;");
$category_items = query_to_array($dbhandle,"SELECT * FROM inventory_category");
$budget_items = query_to_array($dbhandle,"SELECT * FROM inventory_budget");

$result = $dbhandle -> query("SELECT * FROM inventory ORDER BY inventory_id ASC;");

if($result != false){
    $i = 0;
    $table_out = "";
    while($low = $result->fetchArray()) {
        $inventory_status = $status_items[$low["inventory_status"]][1];
        $inventory_category = $category_items[$low["inventory_category"]][1];
        $inventory_budget = $budget_items[$low["inventory_budget"]][1];
        $inventory_is_fixed = $inventory_isfixed[$low["inventory_is_fixed_asset"]][1];
        $out = '<tr><th scope="row"><a href="edit.php?eid='.$low["inventory_id"].'">'.$low["inventory_id"].'</a></th><td>'.$low["inventory_name"].'</td><td>'.$inventory_status. '</td><td>'.$low["inventory_alias"]. '</td><td>'.$low["inventory_location"].'</td><td>'.$inventory_category.'</td><td>'.$low["inventory_add_date"].'</td><td>'.$inventory_budget.'</td><td>'.$inventory_is_fixed.'</td><td>'.$low["inventory_last_modify"].'</td></tr>';
        $table_out = $table_out.$out."\n";

    }
}


?>
    <div class="container">
        <!-- -->
        <h1 class="page-header">物品一覧</h1>
        物品番号を押すと詳細閲覧・編集ができます。
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
                    <th scope="col">動産/固定資産</th>
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
