<?php
    include '../_base.php';
    $_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    try{
    $receipt_id = req('receipt_id');
    $stm = $_db->prepare('SELECT * FROM receipt WHERE receipt_id = ?');
    $stm->execute([$receipt_id]);
    $receipt = $stm->fetch();

    $stm = $_db->prepare('SELECT * FROM invoice WHERE order_id = ?');
    $stm->execute([$receipt->Order_ID]);
    $order = $stm->fetch();

    $stm = $_db->prepare('SELECT p.*, od.* FROM order_details od JOIN product p ON od.product_id = p.product_id WHERE od.order_id = ?');
    $stm->execute([$receipt->Order_ID]);
    $products = $stm->fetchAll();

    }catch(PDOException $e){
        die($e->getMessage());
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $_title ?? 'Untitled' ?></title>
        <link rel="shortcut icon" href="/images/favicon.png">
        <link rel="stylesheet" href="/css/app.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="/js/app.js"></script>
        <style>
            @page {
                size: A4;
                margin: 20mm;
            }

            html, body {
                height: 100%;
                width:100%;
                margin: 0;
                padding: 0;
            }

            .content {
                width: 100%;
            }
            h3{
                margin: 0px;
            }
            h1{
                color:#FF4060;
                margin: 0 0 10px;
            }
            img{
                width:100px;
                height:100px;
            }
            .productRowTop{
            border-top: 3px solid pink;
            }
            .productRowMiddle{
                vertical-align: top;
            }
            .productRowBottom{
                border-bottom: 3px solid pink;
            }
            h2{
                margin-bottom:5px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                border-left: 3px solid pink;
                border-right: 3px solid pink;
            }

            th, td {
                padding: 6px;
            }

            /* Alignments */
            .qty {
                text-align: center;
            }

            .price {
                text-align: center;
            }

            /* Tighten shipping spacing */
            #shipping h2 {
                margin: 0 0 5px;
            }
            #details{
                padding-top: 0px;
                color: gray;
            }
            #productName{
                padding-bottom: 0px;
            }
            #productNameHeader{
                text-align:left;
            }
            .totals{
                text-align:center;
            }
        </style>
    </head>
    <body>
        <div class = "content">
        <h1>RECEIPT</h1>
        <table>
            <tr class="productRowTop">
                <td id="shipping">
                    <h2>Shipping Address:</h2>
                    <?= $order->Street_Address ?><br>
                    <?= $order->City.", ".$order->State.", ".$order->Post_Code ?>
                </td>
                <td colspan="2" style="text-align:right;">
                    <b>Receipt ID: <?= $receipt->Receipt_ID ?></b><br>
                    <b>Receipt Date: <?= $receipt->Payment_Date ?></b>
                </td>
            </tr>

            <tr class="productRowTop">
                <th id=productNameHeader>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>

            <?php foreach($products as $p): ?>
            <tr>
                <td id = "productName"><?= $p->Name ?></td>
                <td class="qty"><?= $p->Quantity ?></td>
                <td class="price"><?= $p->Price ?></td>
            </tr>
            <tr class="productRowMiddle">
                <td colspan="3" id="details">
                    <?= $p->Brand." ".$p->Scale." ".$p->Series ?>
                </td>
            </tr>
            <?php endforeach ?>

            <tr class="productRowTop">
                <td></td>
                <td class = "totals"><h3>Subtotal:</h3></td>
                <td class="price"><?= $order->Total_Amount ?></td>
            </tr>
            <tr class="productRowBottom">
                <td></td>
                <td class = "totals"><h3>Total:</h3></td>
                <td class="price"><?= $order->Final_Amount ?></td>
            </tr>

        </table>
        </div>
    </body>
</html>
