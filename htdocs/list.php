<?php
require("core.php");
global $isfixed_items,$dbhandle,$date_time,$status_items,$category_items,$budget_items;
maketitle(basename(__FILE__));
#maketable

if($result = query_to_array($dbhandle ,"SELECT * FROM inventory ORDER BY inventory_id ASC;")){
    $table_out = "";

    foreach($result as $row) {
        $inventory_status = $status_items[$row["inventory_status"]][1];
        $inventory_category = $category_items[$row["inventory_category"]][1];
        $inventory_budget = $budget_items[$row["inventory_budget"]][1];
        $inventory_is_fixed = $isfixed_items[$row["inventory_is_fixed_asset"]][1];
        $out = '<tr><th scope="row"><a href="edit.php?eid='.$row["inventory_id"].'">'.$row["inventory_id"].'</a></th><td>'.$row["inventory_name"].'</td><td>'.$inventory_status. '</td><td>'.$row["inventory_alias"]. '</td><td>'.$row["inventory_location"].'</td><td>'.$inventory_category.'</td><td>'.$row["inventory_add_date"].'</td><td>'.$inventory_budget.'</td><td>'.$inventory_is_fixed.'</td><td>'.$row["inventory_last_modify"].'</td></tr>';
        $table_out = $table_out.$out."\n";

    }
}


?>
    <div class="container">
        <!-- -->
        <?php print($inventory_alert);?>
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
                    <th scope="col">資産区分</th>
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
