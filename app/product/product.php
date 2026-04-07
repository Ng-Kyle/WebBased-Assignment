<!--
Use later for search page 
<a href="product.php?Product_ID=<?php echo $row['Product_ID'] ?>">
    <?php echo $row['Name'] ?>
     
</a>
-->

<?php 
    include '../_base.php';
    $_title = 'Product Page';
    include '../_head.php';


    if (is_get()){

        $id = req('Product_ID');
        $stm = $_db->prepare('SELECT p.*, pi.* FROM product JOIN product_image ON p.Product_ID = pi.Product_ID WHERE p.Product_ID = ?');
        $stm->execute([$id]);
        $productIDimg = $stm->fetchAll();
        
        if (!$productIDimg){
            echo "Product not found";
            exit;
        }

        $productIDimg = [
            
            'Product_ID'     => $productIDimg[0]['Product_ID'],
            'Name'           => $productIDimg[0]['Name'],
            'Description'    => $productIDimg[0]['Decription'],
            'Price'          => $productIDimg[0]['Price'],
            'Stock_Quantity' => $productIDimg[0]['Stock_Quantity'],
            'Status'         => $productIDimg[0]['Status'],
            'Scale'          => $productIDimg[0]['Scale'],
            'Series'         => $productIDimg[0]['Series'],
            'Brand'          => $productIDimg[0]['Brand'],
            'Images'         => []

        ];

        foreach ($productIDimg as $p){
            if ($p['image_URL'] ?? false){ //?? end means if there's no or image_URL, it will turn it to false
                $productIDimg['Images'] = $p['image_URL'];
            }
        }

        $_title = $product->Name;

    }

    
?>

















<?php 
    include '../_foot.php';
?>