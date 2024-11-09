<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slideshow</title>
    <link rel="stylesheet" href="./m.css">
</head>
<body>
    <div class="slideshow-container">
        <div class="slides-wrapper">
            <!-- Loop through database images -->
            <?php foreach ($banner as $image): ?>
                <div class="mySlides">
                    <img src="<?php echo htmlspecialchars($image['image_url']); ?>" alt="Slide">
                </div>
            <?php endforeach; ?>
        </div>
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
    </div>
    
    <div style="text-align:center">
        <?php for ($i = 1; $i <= count($banner); $i++): ?>
            <span class="dot" onclick="currentSlide(<?php echo $i; ?>)"></span> 
        <?php endfor; ?>
    </div>

    <!-- JavaScript for slideshow -->
    <script>
    // JavaScript remains the same as in your current code
    let slideIndex = 1;
    const slides = document.getElementsByClassName("mySlides");
    const totalSlides = slides.length;
    const slidesWrapper = document.querySelector(".slides-wrapper");

    function showSlides() {
        slideIndex++;
        updateSlidePosition();
        setTimeout(showSlides, 2000);
    }

    function updateSlidePosition() {
        if (slideIndex === totalSlides + 1) {
            slidesWrapper.style.transition = "none";
            slideIndex = 1;
            const offset = -slideIndex * 100;
            slidesWrapper.style.transform = `translateX(${offset}%)`;
            setTimeout(() => slidesWrapper.style.transition = "transform 0.5s ease", 0);
        } else if (slideIndex === 0) {
            slidesWrapper.style.transition = "none";
            slideIndex = totalSlides;
            const offset = -slideIndex * 100;
            slidesWrapper.style.transform = `translateX(${offset}%)`;
            setTimeout(() => slidesWrapper.style.transition = "transform 0.5s ease", 0);
        } else {
            const offset = -slideIndex * 100;
            slidesWrapper.style.transform = `translateX(${offset}%)`;
        }
        updateDots();
    }

    function plusSlides(n) {
        slideIndex += n;
        updateSlidePosition();
    }

    function currentSlide(n) {
        slideIndex = n;
        updateSlidePosition();
    }

    function updateDots() {
        const dots = document.getElementsByClassName("dot");
        for (let i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        dots[(slideIndex - 1 + totalSlides) % totalSlides].className += " active";
    }

    showSlides();
    </script>
</body>
</html>
