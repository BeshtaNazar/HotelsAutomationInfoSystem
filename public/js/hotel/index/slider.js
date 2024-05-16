let slideIndex = 0;

function showSlide(n) {
    const slides = document.querySelectorAll(".slider img");
    if (n >= slides.length) {
        slideIndex = 0;
    }
    if (n < 0) {
        slideIndex = slides.length - 1;
    }
    const slideWidth = slides[0].clientWidth;
    const offset = -slideIndex * slideWidth;
    slides.forEach(
        (slide) => (slide.style.transform = `translateX(${offset}px)`)
    );
}

function nextSlide() {
    slideIndex++;
    showSlide(slideIndex);
}

function prevSlide() {
    slideIndex--;
    showSlide(slideIndex);
}

showSlide(slideIndex);
