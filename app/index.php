<?php
include '_base.php';



// ----------------------------------------------------------------------------

$_title = 'Home';
 




include '_head.php';
?>
 <style>
    main >:first-child{
 display:none;
} 
 </style>


<!-- decription-->

    
    <div>
        <h1 class="welcometext">Welcome</h1>
        <p class="comp-description">This is a premium description box located on the left. 
            You can add your product details.</p>
    </div>

    <!--side image-->
    <div>                                                        
        <button onclick="nextimage()">></button>
        
        <img src="/images/shrek.jpg" alt="Figure Image" class="index-image">
        
        <button onclick="previousimage()" class="left-arrow-btn"><</button>
    </div>
 

<style>
.welcometext{
    text-align: left; 
    max-width:150px; 
    font-size: 50px;
}

.right-arrow-btn{
    width: 50px;
    height: 30px;
    position: relative;
    float: right;
    bottom: -120px;
    background-color: pink;
}

.index-image{
    width: 300px;
    position: relative;
    top: -70px;
    float: right;
    right: 10px;
}

.left-arrow-btn{
    width: 50px;
    height: 30px;
    position: relative;
    float: right;
    right: 20px;
    bottom: -120px;
    background-color: pink;
}





</style>


<?php
include '_foot.php';