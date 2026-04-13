<?php
    include '../../_base.php';
    $_title = "Product List";
    auth('admin');

    $min = req('min');
    $max = req('max');
    $name = req('name');
    $GLOBALS['brand'] = req('brand', []); 
    $GLOBALS['series'] = req('series', []);
    $GLOBALS['scale'] = req('scale', []);

    //for fetching the stuff
    $stm = $_db->query('SELECT DISTINCT brand FROM product WHERE brand IS NOT NULL');
    $brands_list = $stm->fetchAll(PDO::FETCH_COLUMN);
    $brands_options = array_combine($brands_list, $brands_list);

    $stm = $_db->query('SELECT DISTINCT series FROM product WHERE series IS NOT NULL');
    $series_list = $stm->fetchAll(PDO::FETCH_COLUMN);
    $series_options = array_combine($series_list, $series_list);

    $stm = $_db->query('SELECT DISTINCT scale FROM product WHERE scale IS NOT NULL');
    $scale_list = $stm->fetchAll(PDO::FETCH_COLUMN);
    $scale_options = array_combine($scale_list, $scale_list);

    
    if (is_post()){
        if (!$_user){
            temp('info', 'Please login to add an item into your cart!');
            redirect('../login/login.php');
        }

        $product_id = req('product_id');
        if (!$product_id){
            redirect();
        }
    }
    
    $filter = 'SELECT p.*, pi.image_url FROM product p LEFT JOIN product_image pi ON p.product_id = pi.product_id WHERE p.name LIKE ? AND p.status != "deleted"';
    $params = ["%$name%"];
    //changed from separate to a foreach loop using $Globals from base file
    foreach(['brand', 'series', 'scale'] as $key){
        if (!empty($GLOBALS[$key])){
            $placeholder = implode(',', array_fill(0, count($GLOBALS[$key]), '?'));
            $filter .= " AND p.$key IN ($placeholder)";
            $params = array_merge($params, $GLOBALS[$key]);
        }
    }
    if ($min){
        $filter .= " AND p.price >= ?";
        $params[] = $min;
    }
    if ($max){
        $filter .= " AND p.price <= ?";
        $params[] = $max;
    }
    $filter .= ' GROUP BY p.product_id';
    $stm = $_db->prepare($filter);
    $stm->execute($params);
    $products = $stm->fetchAll();

    include '../_head.php';
?>

<style>
    .price-tag { /*fix this with the a tag*/
        color: #ff6b81; 
        font-weight: bold; 
        font-size: 1.3; 
    }
    .search-container{ /*Leaving here to not break the header elsewhere*/
        display: flex;
        gap: 20px;
    }
</style>

<div class="adminProductListSearchBar">
    <form action="" method="get">
        <?= html_search('name', 'placeholder="Search figures..."') ?>
    </form>
</div>

<div class="search-container">
    <aside class="adminProductListSidebar">
        <form id="filter" action="" method ="get">
            <?php html_hidden('name', $name); ?>
            <h3>Filter by Brand</h3>
            <div class="adminProductListFilterGroup">
                <?php html_checkboxes('brand', $brands_options, true) ?>
            </div>

            <h3>Filter by Series</h3>
            <div class="adminProductListFilterGroup">
                <?php html_checkboxes('series', $series_options, true) ?>
            </div>

            <h3>Filter by Scale</h3>
            <div class="adminProductListFilterGroup">
                <?php html_checkboxes('scale', $scale_options, true) ?>
            </div>

            <h3>Filter by Price</h3>
            <div class="adminProductListFilterGroup">
                <?php html_number('min', $min, 0, 9999, 1, 'placeholder="Min"'); ?>
                <?php html_number('max', $max, 0, 9999, 1, 'placeholder="Max"'); ?>
            </div>
            <div class="adminProductListBotButtons">
                <button type="submit">Apply Filters</button>
            </div>
            <a class="adminProductListBotButtons" href="<?= base('product/list.php') ?>">Clear All</a>
        </form>
            <a class="adminProductListBotButtons" href="insert_product.php">Add Product</a>
    </aside>

    <div class="adminProductListContent">
        <h1>All Figures</h1>
        <div class="adminProductListProductsSide">
            <?php foreach ($products as $p): ?>
                <div class="adminProductListProductsCard">
                    <a href="product_details.php?product_id=<?= $p->product_id ?>">
                        <img src="<?= $p->image_url ?>" alt="<?= encode($p->name) ?>">
                    </a>
                    <h3><?= encode($p->name) ?></h3>
                    <p class="price">RM <?= number_format($p->price,2) ?></p>
                    <div class="buttonGroup">
                        <button class = "adminProductListDelete" data-post="delete.php?product_id=<?= $p->product_id ?>">Delete</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php
include '../../_foot.php';
?>