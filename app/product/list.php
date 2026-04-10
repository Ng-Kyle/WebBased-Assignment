<?php
    include '../_base.php';
    $_title = "Product List";
    include '../_head.php';

    $name = req('name');

    if (is_post()){
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
    $stm = $_db->prepare('SELECT p.*, pi.Image_URL FROM product p JOIN product_image pi ON p.Product_ID = pi.Product_ID
                          WHERE p.Name LIKE ? GROUP BY p.Product_ID');
    $stm->execute(["%$name%"]);
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
    .msg { background: #d4edda; 
        color: #155724; 
        padding: 15px; 
        margin: 20px; 
        border-radius: 5px; 
        text-align: center; 
    }
</style>
    <div class="search-bar">
        <form action="" method="get"?>
            <?= html_search('name', 'placeholder="Search figues..."') ?>
        </form>
    </div>

    <div class="search-container">
        <aside class="sidebar">
            <h3>Filter by</h3>
            <p>Category Filters coming soon..</p>
        </aside>

        <div class="content">
            <h1>All Figures</h1>
            <?php if ($m = temp('info')): ?>
                <div class="msg"><?= encode($m) ?></div>
            <?php endif; ?>
        

            <div class="products-side">
                <?php foreach ($products as $p): ?>
                    <div class="products-card">
                        <a href="productDetails.php?Product_ID=<?= $p->Product_ID ?>">
                            <img src="../images/<?= basename($p->Image_URL) ?>" alt="<?= encode($p->Name) ?>">
                            <h3><?= encode($p->Name) ?></h3>
                            <p class="price">RM <?= number_format($p->Price,2) ?></p>
                        </a>
                        <button data-post="?Product_ID=<?= $p->Product_ID ?>&Quantity=1">Quick Add</button>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

<?php
include '../_foot.php';
?>