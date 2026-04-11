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

    
    <div class ="welcome-container">
        <h1 class="welcometext">Welcome</h1>
        <p class="comp-description"> Welcome to AnonFigures, where your favorite worlds come to life! 
            Whether you are a master Gunpla builder or just looking for the latest viral meme figure to brighten your desk, 
            we got you covered. From iconic anime heroes to the legendary mobile suits of Gundam, 
            we source the finest collectibles for every kind of fan. Step in, browse our latest arrivals 
            and find the perfect addition to your shelf today!</p>
    </div>

    

    <!--side image-->
    <div>                                                        
        <button onclick="nextimage()" class="right-arrow-btn">></button>

        <div class="image-container">
        <img id="displayImage" src="/images/shrek.jpg">
        </div>

        <button onclick="previousimage()" class="left-arrow-btn"><</button>
    </div>

    
   
<style>
.welcome-container{
    width: 500px;   
    
}

.welcometext{
    text-align: left; 
    width : 100px;
    font-size: 50px;
    
}

.comp-description{
    text-align: left; 
    width:550px; 
    font-size: 20px;
}


.right-arrow-btn{
    width: 50px;
    height: 30px;
    position: relative;
    float: right;
    top: -120px;
    background-color: pink;
    border-radius: 50%;
    border: none;
}

.image-container{
    display:flex;
    justify-content: center;
    align-items: center;
    width: 400px;
    height: 400px;
    position: relative;
    top: -300px;
    float: right;
    right: 10px;
    object-fit: fill;
    overflow: hidden;
}

#displayImage{
    width: 400px;
    height: 400px;
    position: relative;
    object-fit: contain;
    object-position: center;
}

.left-arrow-btn{
    width: 50px;
    height: 30px;
    position: relative;
    float: right;
    right: 20px;
    top: -120px;
    background-color: pink;
    border-radius: 50%;
    border: none;
}

</style>


<script>

 // 3. List your images here in the order you want them to show
    var myImages = [" /images/shrek.jpg", " /images/69d78e1830754.jpg", " /images/69d7911df1613.jpg"];
    var i = 0; // This keeps track of which image we are on

    function nextimage() {
        i++; 
        
       
        if (i >= myImages.length) {
            i = 0;
        }

        document.getElementById("displayImage").src = myImages[i];
    }

    function previousimage() {
        i--; 
        
       
        if (i < 0) {
            i = myImages.length - 1;
        }

        document.getElementById("displayImage").src = myImages[i];
    }

</script>






<?php
include '_foot.php';