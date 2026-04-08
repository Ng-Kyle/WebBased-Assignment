<!--
Use later for search page 
<a href="product.php?Product_ID=<?php echo $row['Product_ID'] ?>">
    <?php echo $row['Name'] ?>
     
</a>
-->

<?php 
    include '../_base.php';
    


    if (is_get()){
                //req('Product_ID');
        $id = 1;
        $stm = $_db->prepare('SELECT p.*, pi.* FROM product p LEFT JOIN product_image pi ON p.Product_ID = pi.Product_ID WHERE p.Product_ID = ?');
        $stm->execute([$id]);
        $productIDimg = $stm->fetchAll();
        
        //Debug
        //var_dump($id);
        //print_r($productIDimg);

        if (!$productIDimg){
            echo "Product not found";
            exit;
        }

        $products= [
            
            'Product_ID'     => $productIDimg[0]->Product_ID,
            'Name'           => $productIDimg[0]->Name,
            'Description'    => $productIDimg[0]->Description,
            'Price'          => $productIDimg[0]->Price,
            'Stock_Quantity' => $productIDimg[0]->Stock_Quantity,
            'Status'         => $productIDimg[0]->Status,
            'Scale'          => $productIDimg[0]->Scale,
            'Series'         => $productIDimg[0]->Series,
            'Brand'          => $productIDimg[0]->Brand,
            'Images'         => []

        ];

        foreach ($productIDimg as $p){
            if ($p->Image_URL ?? false){ //?? end means if there's no or image_URL, it will turn it to false
                $products['Images'][] = '../images/' . basename($p->Image_URL); //the extra [] is for append.
            }
        }

        $_title = $products['Name'];
        include '../_head.php';

    }
    
?>


<!-- Display product images -->
<div class="products-images">
    <?php if (!empty($products['Images'])): ?>
        <?php foreach ($products['Images'] as $img): ?>
            <img src="<?= htmlspecialchars($img) ?>" 
                 alt="<?= htmlspecialchars($products['Name']) ?>" 
                 style="max-width:200px; margin:10px;">
        <?php endforeach; ?>
    <?php else: ?>
        <p>No images available.</p>
    <?php endif; ?>
</div>

<!-- Display product info -->

<p>Price: $<?= htmlspecialchars($products['Price']) ?></p>
<p>Description</p>
<p><?= htmlspecialchars($products['Description']) ?></p>
<p>Stock Quantity: <?= htmlspecialchars($products['Stock_Quantity']) ?></p> <p>Status: <?= htmlspecialchars($products['Status']) ?></p>

















<?php 
    include '../_foot.php';
?>