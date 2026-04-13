<?php
    include '_base.php';

    // ----------------------------------------------------------------------------
    $_title = 'AnonFigures';

    $stm = $_db->prepare('SELECT p.product_id, p.name, p.price, i.image_url, 
                            COUNT(od.product_id) AS total_bought
                            FROM product p
                            JOIN product_image i ON p.product_id = i.product_id
                            LEFT JOIN order_details od ON p.product_id = od.product_id
                            LEFT JOIN invoice inv ON od.order_id = inv.order_id
                            GROUP BY p.product_id
                            ORDER BY total_bought DESC
                            LIMIT 6');
    $stm->execute();
    $arr = $stm->fetchAll();

    include '_head.php';
?>

<div class="indexPage">
    <!-- Top Section -->
    <div class="indexTopSection">
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
        <div class="indexDescriptionContainer">
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
                <?php foreach ($arr as $p): ?>
                    <div class="product-card">
                        <a href="product/productDetails.php?product_id=<?= $p->product_id ?>">
                            <img class="product-image" src="<?= $p->image_url ?>" alt="<?= encode($p->name) ?>">
                        </a>
                        <h3><?= encode($p->name) ?></h3>
                        <p class="price">RM <?= number_format($p->price,2) ?></p>
                    </div >
                <?php endforeach; ?>
            </div>
            <button class="slide-btn right" onclick="slideRight()">›</button>
        </div>
    </div>
    <div>
        <h3>Our Store Location📌</h3>
        <iframe class="map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3971.8764056341292!2d100.3086100750317!3d5.435735894543674!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x304ac30639a8371d%3A0xd64b8208b7c331b1!2sGurney%20Paragon%20Mall!5e0!3m2!1sen!2smy!4v1776099943740!5m2!1sen!2smy"
                     width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</div>
    


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
?>