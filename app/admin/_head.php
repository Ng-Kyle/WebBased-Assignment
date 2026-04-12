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
        <h1 class="store"><a href="/index.php">AnonFigures</a></h1>

         <div class="search-container">
            <form action="/product/list.php" method="get">
                <?php 
                    $GLOBALS['name'] = req('name');
                    html_search('name', 'placeholder="Search figures..." class="headerSearch"');
                ?>
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
         </div>
         
        <a class = "store" href="/product/list.php">Product</a>   

        <?php if ($_user): ?>
            <a href="/login/logout.php">Logout</a>
            <a id = "profile" href="/user/profile.php">Profile <img src = "<?= $_user->image_url?>" alt = "profileImg" ></a>
        <?php endif ?>
    </header>

   

        
       
    

    <main>
        <h1><?= $_title ?? 'Untitled' ?></h1>
