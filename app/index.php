<?php
include '_base.php';



// ----------------------------------------------------------------------------

$_title = 'Home';


include '_head.php';
?>

<!-- decription-->

    
    <div class="description-side">
        <h1>Welcome</h1>
        <p>This is a premium description box located on the left. 
            You can add your product details.</p>
        <button class="shop btn">Next</button>
    </div>

    <!--side image-->
    <div class="image-side">
        <img src="/images/shrek.jpg" alt="Figure Image" style="width: 100px; height:100px;">
        <button onclick="nextimage()" class="arrow-btn">></button>
    </div>
 



<?php
include '_foot.php';