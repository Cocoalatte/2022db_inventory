CREATE TABLE inventory(
    inventory_id INTEGER PRIMARY KEY ,
    inventory_name TEXT NOT NULL,
    inventory_status INTEGER NOT NULL,
    inventory_alias TEXT,
    inventory_category INTEGER,
    inventory_add_date TEXT,
    inventory_budget INTEGER NOT NULL,
    inventory_is_fixed_asset INTEGER NOT NULL,
    inventory_location TEXT,
    inventory_memo TEXT,
    inventory_amount INTEGER,
    inventory_last_modify TEXT NOT NULL

);
CREATE TABLE inventory_status(
    inventory_status_id INTEGER PRIMARY KEY REFERENCES inventory(inventory_status),
    inventory_status_name INTEGER NOT NULL
);
CREATE TABLE inventory_category(
    inventory_category_id INTEGER PRIMARY KEY REFERENCES inventory(inventory_category),
    inventory_category_name TEXT NOT NULL
);

CREATE TABLE inventory_budget(
    inventory_budget_id INTEGER PRIMARY KEY REFERENCES inventory(inventory_budget),
    inventory_budget_name TEXT
);


CREATE TABLE inventory_asset_division(
    inventory_division TEXT PRIMARY KEY ,
    inventory_division_name TEXT NOT NULL
);

INSERT INTO inventory_status VALUES (0,"在庫"),(1,"注文中"),(2,"修理中"),(3,"捜索中"),(4,"除却");

INSERT INTO inventory_budget VALUES (0,"未登録"),(1,"実験実習費"),(2,"学科運営費"),(3,"科研費");

INSERT INTO inventory_category VALUES  (0,"未分類"),(1,"PC"),(2,"家電・ガジェット"),(3,"書籍");

INSERT INTO inventory_asset_division VALUES (0,"動産"),(1,"固定資産");