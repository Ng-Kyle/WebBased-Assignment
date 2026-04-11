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






<div class="slider-container">

        <!-- Slides -->
        <div class="slide active">
            <img src="/images/anime1.jpg">
        </div>

        <div class="slide">
            <img src="/images/anime2.jpg">
        </div>

        <div class="slide">
            <img src="/images/anime3.jpg">
        </div>

        <!-- Arrows -->
        <button class="arrow left" onclick="prevSlide()"><</button>
        <button class="arrow right" onclick="nextSlide()">></button>

</div>

<div class="description">

        <h2 class="com-desc">Welcome to AnonFigures!</h2>
        <p class = "desc">AnonFigures is a hobby and collectibles store for anime and mecha fans,
            specializing in Gundam model kits, figurines, and anime merchandise.
            The store offers a wide selection of items ranging from detailed Gunpla
            builds to collectible figures, accessories, and fan merchandise inspired
            by popular series. It is designed as a go-to spot for collectors who enjoy building,
            displaying, and expanding their anime figure collections.
        </p>

</div>

<div class="slider-container2">

        <h2 class="sales-products">On Sales🔥</h2>

        <div class="product-slider">

            <div class="product-card">
                <span class="sale-badge">HOT</span>
                <img class="product-image" src="/images/shrek.jpg" alt="Gundam">
                <div class="info">
                <h3>RG Hi-Nu Gundam</h3>
                <p class="price">RM48.99</p>
                </div>
            </div>
            
            <div class="product-card">
                <span class="sale-badge">HOT</span>
                <img class="product-image" src="/images/image2.png" alt="Meme Figure">
                <div class="info">
                <h3>Doge Figurine</h3>
                <p class="price">RM19.99</p>    
                </div>
            </div>

            <div class="product-card">
                <span class="sale-badge">HOT</span>
                <img class="product-image" src="/images/anonfigure.jpg" alt="Meme Figure">
                <div class="info">
                <h3>Doge Figurine</h3>
                <p class="price">RM19.99</p>
                </div>
            </div>

            <div class="product-card">
                <span class="sale-badge">HOT</span>
                <img class="product-image" src="/images/image.png" alt="Meme Figure">
                <div class="info">
                <h3>Doge Figurine</h3>
                <p class="price">RM19.99</p>
                </div>
            </div>

            <div class="product-card">
                <span class="sale-badge">HOT</span>
                <img class="product-image" src="/images/anime1.jpg" alt="Meme Figure">
                <div class="info">
                <h3>Doge Figurine</h3>
                <p class="price">RM19.99</p>
                </div>
            </div>

            
        </div>
</div>


<style>

    .description{
        max-width: 40%;
        position: relative;
        left: 50rem;
        top: -20rem;
        font-size: 1.2rem;
        flex-wrap: wrap;
        
        
        
    }

    /* Main container */
    .slider-container {
        width: 50%;
        height: 400px;
        position: relative;
        background: #1a1a1a;
        border-radius: 20px;
        overflow: hidden;
        display: flex;
        border: none;
    }

    /* Images */
    .slide {
        position: absolute;
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: opacity 0.6s;
    }

    .slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        image-rendering: auto;
    }

    /* Active image */
    .active {
        opacity: 1;
    }

    /* Arrow buttons */
    .arrow {
        position: absolute;
        top: 180px;
        font-size: 30px;
        background-color: #535353;
        opacity: 50%;
        border: none;
        color: white;
        padding: 10px 15px;
        cursor: pointer;
        border-radius: 50%;
        z-index: 10;
    }

    .arrow:hover {
        background: rgba(255,255,255,0.2);
    }

    .left {
        left: 20px;
    }

    .right {
        right: 20px;
    }

</style>

<style>
   .slider-container2 {
    width: 100%;
    max-width: 1100px;
    margin: 20px auto;
    margin-top: -250px;
   
    }

    .product-slider {
        display: flex;
        gap: 20px;
        overflow-x: scroll;
        padding: 20px 10px;
        scroll-behavior: smooth;
        scroll-snap-type: x mandatory; 
    }
    
    .product-slider::-webkit-scrollbar {
        height: 10px;
    }

    .product-slider::-webkit-scrollbar-thumb {
        background: #ff7c87; 
        border-radius: 10px;
    }

    .product-slider::-webkit-scrollbar-track {
        background: #e0e0e0;
        border-radius: 10px;
    }

    .product-card {
        min-width: 220px;
        height: 50%;
        background: #fff;
        border-radius: 12px;
        padding: 15px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        position: relative;
        text-align: center;
        scroll-snap-align: start;
    }

    .sales-products {
        margin-bottom: 0%;
        font-size: 30px;
        color: #333;
    }

    .sale-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: #ff4757;
        color: white;
        padding: 4px 8px;
        font-size: 12px;
        font-weight: bold;
        border-radius: 4px;
    }

    .product-card img {
        width: 100%;
        height: 250px;
        border-radius: 8px;
        
    }
</style>

<script>
let currentIndex = 0;
const slides = document.querySelectorAll('.slide');

function showSlide(index) {
    slides.forEach((slide, i) => {
        slide.classList.remove('active');
    });

    slides[index].classList.add('active');
}

function nextSlide() {
    currentIndex++;
    if (currentIndex >= slides.length) {
        currentIndex = 0;
    }
    showSlide(currentIndex);
}

function prevSlide() {
    currentIndex--;
    if (currentIndex < 0) {
        currentIndex = slides.length - 1;
    }
    showSlide(currentIndex);
}






</script>
















<?php
include '_foot.php';