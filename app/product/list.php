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
            }else {
                temp('info', 'Already in your Wishlist! 😊');
            }
        }else{
            $quantity = 1;
            $stm = $_db->prepare('SELECT stock_quantity FROM product WHERE product_id = ?');
            $stm->execute([$product_id]);
            $real_stock = $stm->fetchColumn();
            
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
                $stm = $_db->prepare('UPDATE cart_product SET quantity = quantity + ? WHERE product_id = ? AND cart_id = ?');
                $stm->execute([$quantity,$product_id,$cart_id]);
                temp('info', 'Added to Cart!! 🛒');
                redirect();    
            }else{
                //insert new product
                $stm = $_db->prepare('INSERT INTO cart_product (product_id, cart_id, quantity) VALUES (?,?,?)');
                $stm->execute([$product_id,$cart_id,$quantity]);
                temp('info', 'Added to Cart!! 🛒');
                redirect();
            }
        }
    }   
    $filter = 'SELECT p.*, pi.image_url FROM product p LEFT JOIN product_image pi ON p.product_id = pi.product_id WHERE p.name LIKE ?';
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
    .search-bar{
        text-align: center;
        margin: 20px;
    }
    .search-bar input{
        width: 50%;
        padding: 10px;
        border-radius: 20px;
        border: 2px solid #FF5E7E;
    }
    .search-bar input:focus{
        border-color:#ff1f4b;
        outline: none;
        box-shadow: 0 0 8px rgba(255, 94, 126, 0.3);
    }
    .search-container{
        display: flex;
        gap: 20px;
    }
    .sidebar{
        width: 250px;
        flex-shrink:0; /*this is to prevent shrinking for the sidebar*/
        border-right: 3px solid #FF5E7E;
    }
    .content{
        flex-grow: 1; /* this is to let the content div to take up the remaining spaces in the page. */
    }
    .products-side {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 30px;
        padding: 40px;
    }
    .products-card {
        border: 1px solid #FF5E7E;;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        background: #ffffff;
        transition: transform 0.2s;
    }
    .products-card img {
        width: 100%;
        height: 200px;
        object-fit: contain;
    }
    .products-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .price-tag { 
        color: #ff6b81; 
        font-weight: bold; 
        font-size: 1.3; 
    }
</style>
    <div class="search-bar">
        <form action="" method="get">
            <?= html_search('name', 'placeholder="Search figures..."') ?>
        </form>
    </div>

    <div class="search-container">
        <aside class="sidebar">
            <form id="filter" action="" method ="get">
                <?php html_hidden('name', $name); ?>
                <h3>Filter by Brand</h3>
                <div class="filter-group">
                    <?php html_checkboxes('brand', $brands_options, true) ?>
                </div>

                <h3>Filter by Series</h3>
                <div class="filter-group">
                    <?php html_checkboxes('series', $series_options, true) ?>
                </div>

                <h3>Filter by Scale</h3>
                <div class="filter-group">
                    <?php html_checkboxes('scale', $scale_options, true) ?>
                </div>

                <h3>Filter by Price</h3>
                <div class="filter-group">
                    <?php html_number('min', $min, 0, 9999, 1, 'placeholder="Min"'); ?>
                    <?php html_number('max', $max, 0, 9999, 1, 'placeholder="Max"'); ?>
                </div>

                <button type="submit">Apply Filters</button>
                <a href="<?= base('product/list.php') ?>">Clear All</a>
            </form>
        </aside>

        <div class="content">
            <h1>All Figures</h1>
            <div class="products-side">
                <?php foreach ($products as $p): ?>
                    <div class="products-card">
                        <a href="productDetails.php?product_id=<?= $p->product_id ?>">
                            <img src="<?= $p->image_url ?>" alt="<?= encode($p->name) ?>">
                            <h3><?= encode($p->name) ?></h3>
                            <p class="price">RM <?= number_format($p->price,2) ?></p>
                        </a>
                        <div class="buttonGroup">
                        <button data-post="?product_id=<?= $p->product_id ?>">Quick Add🌟</button>
                        <button data-post="?product_id=<?= $p->product_id ?>&action=wishlist">❤️</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

<?php
include '../_foot.php';
?>