let slideImages = document.querySelectorAll('.slides img');
    let next = document.querySelector('.next');
    let prev = document.querySelector('.prev');
    let dots = document.querySelectorAll('.dot');
    let counter = 0;

    function slideNext() {
        slideImages[counter].style.animation = 'next1 0.5s ease-in forwards';
        counter = (counter + 1) % slideImages.length;
        slideImages[counter].style.animation = 'next2 0.5s ease-in forwards';
        indicators();
    }

    function slidePrev() {
        slideImages[counter].style.animation = 'prev1 0.5s ease-in forwards';
        counter = (counter === 0) ? slideImages.length - 1 : counter - 1;
        slideImages[counter].style.animation = 'prev2 0.5s ease-in forwards';
        indicators();
    }

    function autoSliding() {
        deleteInterval = setInterval(slideNext, 3000);
    }
    autoSliding();

    const container = document.querySelector('.slide-container');
    container.addEventListener('mouseover', () => clearInterval(deleteInterval));
    container.addEventListener('mouseout', autoSliding);

    function indicators() {
        dots.forEach(dot => dot.classList.remove('active'));
        dots[counter].classList.add('active');
    }

    function switchImage(currentImage) {
        let imageId = parseInt(currentImage.getAttribute('attr'));
        if (imageId !== counter) {
            slideImages[counter].style.animation = imageId > counter ? 'next1 0.5s ease-in forwards' : 'prev1 0.5s ease-in forwards';
            counter = imageId;
            slideImages[counter].style.animation = imageId > counter ? 'next2 0.5s ease-in forwards' : 'prev2 0.5s ease-in forwards';
            indicators();
        }
    }
    function scrollProducts(direction) {
    const container = document.querySelector('.product-container');
    const scrollAmount = 200;

    if (direction === 'left') {
        container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
    } else if (direction === 'right') {
        container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    }
}
function scrollProducts2(minx) {
    const container = document.querySelector('#product_container2');
    const scrollAmount = 200;

    if (minx === 'left2') {
        container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
    } else if (minx === 'right2') {
        container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    }
}
function scrollProducts1(minx1) {
    const container = document.querySelector('#product_container1');
    const scrollAmount = 200;

    if (minx1 === 'left1') {
        container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
    } else if (minx1 === 'right1') {
        container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    }
}


