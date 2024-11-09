<div class="slideshow-container">
    <?php foreach ($banners as $index => $banner) : ?>
        <div class="slide">
        <img src="<?= $banner['img_url'] ?>"alt="">
        </div>
    <?php endforeach; ?>
    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
    <a class="next" onclick="plusSlides(1)">&#10095;</a>
</div>

<div style="text-align:center">
    <?php foreach ($banners as $index => $banner) : ?>
        <span class="dot" onclick="currentSlide(<?= $index + 1 ?>)"></span>
    <?php endforeach; ?>
</div>

<script>
let slideIndex = 0; 
const slides = document.getElementsByClassName("slide");
const dots = document.getElementsByClassName("dot");

function showSlides() {

    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }


    for (let i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }


    slideIndex++;
    if (slideIndex > slides.length) { slideIndex = 1; }


    slides[slideIndex - 1].style.display = "block";
    dots[slideIndex - 1].className += " active";

    setTimeout(showSlides, 2000);
}


function plusSlides(n) {
    slideIndex += n - 1; 
    showSlides();
}


function currentSlide(n) {
    slideIndex = n - 1;
    showSlides();
}

// Initialize the automatic slideshow
showSlides();
</script>
