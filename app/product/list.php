<?php
    include '../_base.php';
    $_title = "Product List";

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

    //Quick Add stuff
    if (is_post()){
        if (!$_user){
            if (req('action') == 'wishlist'){
                temp('info', 'Please login to add an item into your wishlist!');
                redirect('../login/login.php');
            }else{
                temp('info', 'Please login to add an item into your cart!');
                redirect('../login/login.php');
            }
        }

        $product_id = req('product_id');
        if (!$product_id){
            redirect();
        }

        if (req('action') == 'wishlist'){
            $wishlist_id = get_wishlist();

            $stm = $_db->prepare('SELECT 1 FROM wishlist_product WHERE wishlist_id = ? AND product_id = ?');
            $stm->execute([$wishlist_id, $product_id]);
            $duplicates = $stm->fetch();

            if (!$duplicates){
                $stm = $_db->prepare('INSERT INTO wishlist_product (wishlist_id, product_id) VALUES (?,?)');
                $stm->execute([$wishlist_id, $product_id]);
                temp('info', 'Added to Wishlist! ❤️');
            }
            else {
                temp('info', 'Already in your Wishlist! 😊');
            }
            
        }
        else{
            $stm = $_db->prepare('SELECT stock_quantity FROM product WHERE product_id = ?');
            $stm->execute([$product_id]);
            $real_stock = $stm->fetchColumn();

            $stm = $_db->prepare('SELECT status FROM product WHERE product_id = ?');
            $stm->execute([$product_id]);
            $status = $stm->fetchColumn();

            if($status != 'Available'){
                temp('info', 'This item is no longer on sale!');
                redirect();
            }
            
            $cart_id = get_cart();
            //this is for checking if the product exists in the member's cart
            $stm = $_db->prepare('SELECT * FROM cart_product WHERE product_id = ? AND cart_id = ? ');
            $stm->execute([$product_id,$cart_id]);
            $exists = $stm->fetch();

            if($exists->quantity + $quantity > $real_stock){
                temp('info', 'Your cart is full 😡!!');
                redirect();
            }
            if($exists){
                //update existing product
                $stm = $_db->prepare('UPDATE cart_product SET quantity = quantity + 1 WHERE product_id = ? AND cart_id = ?');
                $stm->execute([$product_id,$cart_id]);
                temp('info', 'Added to Cart!! 🛒');
                redirect();    
            }
            else{
                //insert new product
                $stm = $_db->prepare('INSERT INTO cart_product (product_id, cart_id, quantity) VALUES (?,?,1)');
                $stm->execute([$product_id,$cart_id]);
                temp('info', 'Added to Cart!! 🛒');
                redirect();
            }
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
    .search-container{ /*leave this to prevent search header breaking*/
        display: flex;
        gap: 20px;
    }
</style>

<div class="productListSearchBar">
    <form action="" method="get">
        <?= html_search('name', 'placeholder="Search figures..."') ?>
    </form>
</div>

<div class="search-container">
    <aside class="productListSidebar">
        <form class="productListFilter" action="" method ="get">
            <?php html_hidden('name', $name); ?>
            <div class="productListFilterContainer">
                <h3>Filter by Brand</h3>
                <div class="productListFilterGroup">
                    <?php html_checkboxes('brand', $brands_options, true) ?>
                </div>

                <h3>Filter by Series</h3>
                <div class="productListFilterGroup">
                    <?php html_checkboxes('series', $series_options, true) ?>
                </div>

                <h3>Filter by Scale</h3>
                <div class="productListFilterGroup">
                    <?php html_checkboxes('scale', $scale_options, true) ?>
                </div>  

                <h3>Filter by Price</h3>
                <div class="productListFilterGroup">
                    <?php html_number('min', $min, 0, 9999, 1, 'placeholder="Min"'); ?>
                    <?php html_number('max', $max, 0, 9999, 1, 'placeholder="Max"'); ?>
                </div>
            </div>

            <button type="submit">Apply Filters</button>
            <a href="<?= base('product/list.php') ?>">Clear All</a>
        </form>
    </aside>

    <div class="productListContent">
        <h1>All Figures</h1>
        <div class="productListProductsSide">
            <?php foreach ($products as $p): ?>
                <div class="productListProductsCard">
                    <a href="productDetails.php?product_id=<?= $p->product_id ?>">
                        <img src="<?= $p->image_url ?>" alt="<?= encode($p->name) ?>">
                        <h3><?= encode($p->name) ?></h3>
                        <p class="price">RM <?= number_format($p->price,2) ?></p>
                    </a>
                    
                    <div class="buttonGroup">
                        <button data-post="?product_id=<?= $p->product_id ?>" class="productListQuickAdd">Quick Add🌟</button>
                        <button data-post="?product_id=<?= $p->product_id ?>&action=wishlist" class="productListWishlist">❤️</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php
    include '../_foot.php';
?>