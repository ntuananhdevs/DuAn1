// Dropdown functionality

// Close the dropdown if the user clicks outside of it
// window.onclick = function(event) {
//     if (!event.target.matches('#userIcon') && !event.target.matches('ion-icon') && !event.target.closest('.list-img')) {
//         document.querySelectorAll('.dropdown-menu.show').forEach(function(openDropdown) {
//             openDropdown.classList.remove('show');
//         });
//     }
// };

// Slideshow functionality
let listimg = document.querySelector(".list-img");
let items = document.querySelectorAll(".item");
let prev = document.getElementById("prev");
let next = document.getElementById("next");
let count = 0;
let index = items.length - 1;
let auto = setInterval(() => { next.click() }, 9000);

next.addEventListener('click', function() {
    count = (count + 1) > index ? 0 : count + 1;
    reloadslide();
    resetAutoSlide();
});

prev.addEventListener('click', function() {
    count = (count - 1) < 0 ? index : count - 1;
    reloadslide();
    resetAutoSlide();
});

function reloadslide() {
    let checkleft = items[count].offsetLeft;
    listimg.style.left = -checkleft + 'px';
}

//header
let lastScrollTop = 0;

        document.getElementById('searchIcon').addEventListener('click', function() {
            document.getElementById('searchOverlay').classList.toggle('active');
            document.querySelector('.main-content').classList.toggle('blurred');
        });

        // Close overlay when clicking outside
        document.addEventListener('click', function(event) {
            var searchOverlay = document.getElementById('searchOverlay');
            if (!searchOverlay.contains(event.target) && !event.target.closest('#searchIcon')) {
                searchOverlay.classList.remove('active');
                document.querySelector('.main-content').classList.remove('blurred');
            }
        });

        // Prevent closing overlay when clicking inside it
        document.querySelector('.search-overlay').addEventListener('click', function(event) {
            event.stopPropagation();
        });

        // Close search overlay on scroll
        window.addEventListener('scroll', function() {
            let st = window.pageYOffset || document.documentElement.scrollTop;
            if (st > lastScrollTop) {
                document.getElementById('searchOverlay').classList.remove('active');
                document.querySelector('.main-content').classList.remove('blurred');
            }
            lastScrollTop = st <= 0 ? 0 : st; 
        });

