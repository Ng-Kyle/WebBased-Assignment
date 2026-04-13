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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <?php 
    if($_user && $_user->role == 'member'){
        temp('info', "You're not an admin!");
        redirect('/');
    } ?>
    <!-- Flash message -->  
    <div id="info"><?= temp('info') ?></div>
    <header>
        <h1 class="store"><a href="/index.php">AnonFigures</a></h1>
        <?php if ($_user): ?>
         <div class="search-container">
            <form action="/product/list.php" method="get">
                <?php 
                    $GLOBALS['name'] = req('name');
                    html_search('name', 'placeholder="Search figures..." class="headerSearch"');
                ?>
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
         </div>
         
        <a class = "store" href="/admin/product/product_list.php">Products</a>   
        <a class = "store" href="/admin/member_list.php">Members</a>
        <a class = "store" href="/admin/order/order_listing.php">Orders</a>
        <a class = "store" href="/admin/admin_register.php">Register</a>
            <a href="/admin/logout.php">Logout</a>
        <?php endif ?>
    </header>

   

        
       
    

    <main>
        <h1 class = "pageTitle" ><?= $_title ?? 'Untitled' ?></h1>
