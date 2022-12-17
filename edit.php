<?php require("env.php");?>
<!DOCTYPE HTML>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <title>台帳編集 - <?php print(APP_NAME);?></title>
</head>
<body>
<?php generate_navbar(basename(__FILE__))?>
<!--
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#"><?php print(APP_NAME);?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
            </li>
        </ul>
    </div>
</nav>
-->
    <div class="container">
        <!-- -->
        <h1 class="page-header">物品詳細・編集</h1>

        <form>
            <div class="form-group">
                <label for="inventory_id" class="col-form-label">物品ID(自動)</label>
                <input type="text" class="form-control" id="inventory_id" readonly>
            </div>
            <div class="form-group">
                <label for="inventory_name" class="col-form-label">物品名</label>
                <input type="text" class="form-control" id="inventory_name">
            </div>
            <div class="form-group">
                <label for="inventory_status" class="col-form-label">ステータス</label>
                <select class="custom-select" id="inventory_status">
                    <option value="1">在庫</option>
                    <option value="2">注文中</option>
                    <option value="3">修理中</option>
                    <option value="4">捜索中</option>
                    <option value="5">除却</option>
                </select>
            </div>
            <div class="form-group">
                <label for="inventory_alias" class="col-form-label">大学資産番号</label>
                <input type="text" class="form-control" id="inventory_alias">
            </div>
            <div class="form-group">
                <label for="inventory_location" class="col-form-label">保管場所</label>
                <input type="text" class="form-control" id="inventory_location">
            </div>
            <div class="form-group">
                <label for="inventory_category" class="col-form-label">カテゴリ</label>
                <select class="custom-select" id="inventory_category">
                    <option value="1">PC</option>
                    <option value="2">家電・ガジェット</option>
                    <option value="3">書籍</option>
                </select>
            </div>
            <div class="form-group">
                <label for="inventory_add_date" class="col-form-label">購入年月</label>
                <input type="text" class="form-control" id="inventory_add_date">
            </div>
            <label for="inventory_budget" class="col-form-label">利用予算</label>
            <select class="custom-select" id="inventory_budget">
                <option value="0">未登録</option>
                <option value="1">実験実習費</option>
            </select>
            <div class="form-group">
                <label for="inventory_is_fixed_asset" class="col-form-label">動産/固定資産</label>
                <select class="custom-select" id="inventory_is_fixed_asset">
                    <option value="1">動産</option>
                    <option value="2">固定資産</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">保存</button>
        </form>
    </div>

</body>
</html>