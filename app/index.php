<?php
include '_base.php';

// ----------------------------------------------------------------------------
$_title = 'Home';

$stm = $_db->prepare('SELECT p.*, i.image_url FROM product p JOIN product_image i on p.product_id = i.product_id ORDER BY product_id LIMIT 6' );
$stm->execute();
$product = $stm->fetchAll();

include '_head.php';


?>



<main class="main-container">

    <!-- Top Section -->
    <div class="top-section">

        <!-- LEFT: Slider -->
        <div class="slider-container">
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

        <!-- RIGHT: Description -->
        <div class="description-container">
            <h2>AnonFigures</h2>
            <p>
                AnonFigures is a hobby and collectibles store for anime and mecha fans,
                specializing in Gundam model kits, figurines, and anime merchandise.
                The store offers a wide selection of items ranging from detailed Gunpla
                builds to collectible figures, accessories, and fan merchandise inspired
                by popular series. It is designed as a go-to spot for collectors who enjoy building,
                displaying, and expanding their anime figure collections.
            </p>
        </div>

    </div>
<div class="product-section">

    <h2>🔥 Most Ordered Products</h2>

    <div class="slider-wrapper">

        <button class="slide-btn left" onclick="slideLeft()">‹</button>

        <div class="product-slider" id="productSlider">

            <?php foreach ($product as $p): ?>
                
                <div class="product-card">
                    <a href="product/productDetails.php?product_id=<?= $p->product_id ?>">
                         <img class="product-image" src="<?= $p->image_url ?>" alt="<?= encode($p->name) ?>">
                    </a>
                    <h3><?= encode($p->name) ?></h3>
                    <p class="price">RM <?= number_format($p->price,2) ?></p>
                </div>
            <?php endforeach; ?>

        </div>

        <button class="slide-btn right" onclick="slideRight()">›</button>

    </div>


</div>

    
</main>

<style>
/* MAIN WRAPPER */
.main-container {
    padding: 20px;
}

/* TOP SECTION LAYOUT */
.top-section {
    display: flex;
    gap: 20px;
    align-items: stretch;
    height: 250px;
    
}

/* LEFT: SLIDER */
.slider-container {
    position: relative;
    width: 60%;
    overflow: hidden;
    border-radius: 10px;
}

.slide {
    display: none;
    width: 100%;
    height: 100%;
}

.slide.active {
    display: block;
}

.slide img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* keeps images same shape */
}

/* ARROWS */
.arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(0,0,0,0.5);
    color: white;
    border: none;
    padding: 10px;
    cursor: pointer;
}

.arrow.left {
    left: 10px;
}

.arrow.right {
    right: 10px;
}

.description-container h2 {
    margin-bottom: 0;
    
}

.description-container p{
    margin:10px;
    font-family:Georgia, 'Times New Roman', Times, serif;
}

.top-section {
    display: flex;
    flex-wrap: wrap; /* KEY: allows items to move down */
    gap: 20px;
}

/* Slider */
.slider-container {
    flex: 1 1 400px; /* grow, shrink, minimum width */
    height: 300px;
}


/* Description */
.description-container {
    flex: 1 1 300px;
    background-color: rgba(255, 199, 199, 0.86);
    border-radius: 20px;
    text-align: center;
    font-size: 20px;
    
}
 </style>

<style>

.product-section{
    margin-top: 70px;
}

 /* WRAPPER (hides extra items) */
.slider-wrapper {
    position: relative;
    overflow: hidden;
}

/* SLIDER */
.product-slider {
    display: flex;
    gap: 20px;
    transition: transform 0.3s ease;
}

/* PRODUCT CARD */
.product-card {
    flex: 0 0 calc(25% - 15px); /* 4 items max */
    background: #ffdbdb;
    border: 6px solid pink;
    border-radius: 10px;
    overflow: hidden;
    text-align: center;
    justify-content: center;
   
}

/* IMAGE */
.product-image {
    width: 100%;
    margin-top: 5px;
    height: 150px;
    object-fit: contain;
}

/* BUTTONS */
.slide-btn {
    position: absolute;
    top: 40%;
    transform: translateY(-50%);
    background: rgba(0,0,0,0.5);
    color: white;
    border: none;
    padding: 10px;
    cursor: pointer;
    z-index: 10;
}

.slide-btn.left {
    left: 0;
}

.slide-btn.right {
    right: 0;
}
</style>

 <script>
let index = 0;
const slides = document.querySelectorAll(".slide");

function showSlide(i) {
    slides.forEach(slide => slide.classList.remove("active"));
    slides[i].classList.add("active");
}

function nextSlide() {
    index = (index + 1) % slides.length;
    showSlide(index);
}

function prevSlide() {
    index = (index - 1 + slides.length) % slides.length;
    showSlide(index);
}
</script>

<script>

let scrollAmount = 0;
const slider = document.getElementById("productSlider");

function getMaxScroll() {
    return slider.scrollWidth - slider.parentElement.clientWidth;
}

function slideRight() {
    const maxScroll = getMaxScroll();

    scrollAmount += 300;

    if (scrollAmount > maxScroll) {
        scrollAmount = maxScroll; // STOP at end
    }

    slider.style.transform = `translateX(-${scrollAmount}px)`;
}

function slideLeft() {
    scrollAmount -= 300;

    if (scrollAmount < 0) {
        scrollAmount = 0; // STOP at start
    }

    slider.style.transform = `translateX(-${scrollAmount}px)`;
}

</script>

<?php
include '_foot.php';