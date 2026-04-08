<?php
include '../_base.php';
require __DIR__ . "/../vendor/autoload.php";

$mpdf = new \Mpdf\Mpdf([
    'format' => 'A4',
    'margin_top' => 20,
    'margin_bottom' => 20,
    'margin_left' => 20,
    'margin_right' => 20,
]);

$_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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

$shippingAddress = $order->Street_Address . ', ' . $order->City . ', ' . $order->State . ' ' . $order->Post_Code;
$totalAmount = $order->Total_Amount;
$finalAmount = $order->Final_Amount;

$productsHTML = '';
foreach ($products as $p) {
    $productsHTML .= "<tr>
        <td id='productName'>{$p->Name}</td>
        <td class='qty'>{$p->Quantity}</td>
        <td class='price'>{$p->Price}</td>
    </tr>
    <tr class='productRowMiddle'>
        <td colspan='3' id='details'>{$p->Brand} {$p->Scale} {$p->Series}</td>
    </tr>";
}

$html = <<<HTML
<style>
    body { 
        font-family: sans-serif;
        margin:0; 
        padding:0;
    }
    h1 {
        color:#FF4060; margin-bottom:10px; 
    }
    h2 { 
        margin-bottom:5px; 
    }
    h3 { 
        margin:0; 
    }
    table { 
        width:100%; 
        border-collapse: collapse; 
        border-left:3px solid pink; 
        border-right:3px solid pink;
    }
    th, td { 
        padding:6px; 
    }
    .productRowTop td { 
        border-top:3px solid pink; 
    }
    .productRowBottom td { 
        border-bottom:3px solid pink; 
    }
    .productRowMiddle { 
        vertical-align:top; 
    }
    .qty { 
        text-align:center; 
    }
    .price { 
        text-align:center; 
    }
    #details { 
        color:gray; padding-top:0px; 
    }
    #productName { 
        padding-bottom:0px; 
    }
    #productNameHeader { 
        text-align:left; 
    }
    .totals { 
        text-align:center; 
    }
</style>

<h1>RECEIPT</h1>

<table>
    <tr class="productRowTop">
        <td id="shipping">
            <h2>Shipping Address:</h2>
            {$shippingAddress}
        </td>
        <td colspan="2" style="text-align:right;">
            <b>Receipt ID: {$receipt->Receipt_ID}</b><br>
            <b>Receipt Date: {$receipt->Payment_Date}</b>
        </td>
    </tr>

    <tr>
        <td colspan="3" style="border-top:3px solid pink; padding:0;"></td>
    </tr>


    <tr class="productRowTop">
        <th id="productNameHeader">Product Name</th>
        <th>Quantity</th>
        <th>Price</th>
    </tr>

    {$productsHTML}

    <tr class="productRowTop">
        <td></td><td></td><td></td>
    </tr>

    <tr class="productRowBottom">
        <td></td>
        <td class="totals"><h3>Total:</h3></td>
        <td class="price">{$finalAmount}</td>
    </tr>
</table>
HTML;

// Generate PDF
$mpdf->WriteHTML($html);
$mpdf->Output("receipt_{$receipt_id}.pdf", 'I'); // 'I' = send to browser
?>