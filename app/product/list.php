<?php
    include '../_base.php';
    $_title = "Product List";
    include '../_head.php';

    $min = req('min');
    $max = req('max');
    $name = req('name');
    $GLOBALS['Brand'] = req('Brand', []); 
    $GLOBALS['Series'] = req('Series', []);
    $GLOBALS['Scale'] = req('Scale', []);

    //for fetching the stuff
    $stm = $_db->query('SELECT DISTINCT Brand FROM product WHERE Brand IS NOT NULL');
    $brands_list = $stm->fetchAll(PDO::FETCH_COLUMN);
    $brands_options = array_combine($brands_list, $brands_list);

    $stm = $_db->query('SELECT DISTINCT Series FROM product WHERE Series IS NOT NULL');
    $series_list = $stm->fetchAll(PDO::FETCH_COLUMN);
    $series_options = array_combine($series_list, $series_list);

    $stm = $_db->query('SELECT DISTINCT Scale FROM product WHERE Scale IS NOT NULL');
    $scale_list = $stm->fetchAll(PDO::FETCH_COLUMN);
    $scale_options = array_combine($scale_list, $scale_list);

    //Quick Add stuff
    if (is_post()){

        if (!$_user){
            temp('info', 'Please login to add an item into your cart!');
            redirect('../login/login.php');
        }

        $product_id = req('Product_ID');
        $quantity = req('Quantity');
        $member_id = $_SESSION['user']->Member_ID ?? 1;

        $stm = $_db->prepare('SELECT Cart_ID FROM cart WHERE Member_ID = ?');
        $stm->execute([$member_id]);
        $cart = $stm->fetch();

        if($cart){
            $cart_id = $cart->Cart_ID;   
            //this is for checking if the product exists in the member's cart
            $stm = $_db->prepare('SELECT * FROM cart_product WHERE Product_ID = ? AND Cart_ID = ? ');
            $stm->execute([$product_id,$cart_id]);
            $exists = $stm->fetch();

            if($exists){
                 //update existing product
                $stm = $_db->prepare('UPDATE cart_product SET Quantity = Quantity + ? WHERE Product_ID = ? AND Cart_ID = ?');
                $stm->execute([$quantity,$product_id,$cart_id]);
            }else{
                 //insert new product
                $stm = $_db->prepare('INSERT INTO cart_product (Product_ID, Cart_ID,Quantity) VALUES (?,?,?)');
                $stm->execute([$product_id,$cart_id,$quantity]);
            }
            temp('info', 'Product successfully added to cart!');
            redirect();
        }
    }

    $filter = 'SELECT p.*, pi.Image_URL FROM product p JOIN product_image pi ON p.Product_ID = pi.Product_ID WHERE p.Name LIKE ?';
    $params = ["%$name%"];

    //changed from separate to a foreach loop using $Globals from base file
    foreach(['Brand', 'Series', 'Scale'] as $key){
        if (!empty($GLOBALS[$key])){
            $placeholder = implode(',', array_fill(0, count($GLOBALS[$key]), '?'));
            $filter .= " AND p.$key IN ($placeholder)";
            $params = array_merge($params, $GLOBALS[$key]);
        }
    }
    if ($min){
        $filter .= "AND p.Price >= ?";
        $params[] = $min;
    }
    if ($max){
        $filter .= "AND p.Price <= ?";
        $params[] = $max;
    }


    $filter .= ' GROUP BY p.Product_ID';
    $stm = $_db->prepare($filter);
    $stm->execute($params);
    $products = $stm->fetchAll();

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
    .search-container{
        display: flex;
        gap: 20px;
        padding: 20px;
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
    .price-tag { 
        color: #ff6b81; 
        font-weight: bold; 
        font-size: 1.3; 
    }
</style>
    <div class="search-bar">
        <form action="" method="get">
            <?= html_search('name', 'placeholder="Search figues..."') ?>
        </form>
    </div>

    <div class="search-container">
        <aside class="sidebar">
            <form id="filter" action="" method ="get">
                <?php html_hidden('name', $name); ?>
                <h3>Filter by Brand</h3>
                <div class="filter-group">
                    <?php html_checkboxes('Brand', $brands_options, true) ?>
                </div>

                <h3>Filter by Series</h3>
                <div class="filter-group">
                    <?php html_checkboxes('Series', $series_options, true) ?>
                </div>

                <h3>Filter by Scale</h3>
                <div class="filter-group">
                    <?php html_checkboxes('Scale', $scale_options, true) ?>
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
                        <a href="productDetails.php?Product_ID=<?= $p->Product_ID ?>">
                            <img src="../images/<?= basename($p->Image_URL) ?>" alt="<?= encode($p->Name) ?>">
                            <h3><?= encode($p->Name) ?></h3>
                            <p class="price">RM <?= number_format($p->Price,2) ?></p>
                        </a>
                        <div class="buttonGroup">
                        <button data-post="?Product_ID=<?= $p->Product_ID ?>&Quantity=1">Quick Add</button>
                        <button data-post="../wishlist/wishlist.php?Product_ID=<?= $p->Product_ID ?>">❤️</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

<?php
include '../_foot.php';
?>