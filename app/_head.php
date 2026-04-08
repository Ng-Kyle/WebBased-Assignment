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
    <!-- Flash message -->
    <div id="info"><?= temp('info') ?></div>

    <header>
        <h1><a href="/">Anonfigures</a></h1>
        
        <!-- User profile photo --> 
         <a href="/profile.php">Profile</a>
         <i class="fa fa-shopping-cart" style="font-size:24px;color:ff7777;"></i>
         <a href="/cart/cart.php">Cart</a>
       
    </header>

    <nav class="navbar">
        <a href="/mainmenu.php">Main Menu</a>
    
        <div></div>

    
        <a href="/wishlist.php">Wishlist</a>
        <a href="/logout.php">Logout</a>
    
       <a href="/login.php">Login</a>
   
        <!-- Second menu -->
    </nav>

    
       
    

    <main>
        <h1><?= $_title ?? 'Untitled' ?></h1>