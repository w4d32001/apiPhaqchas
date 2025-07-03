document.addEventListener("DOMContentLoaded", function () {
    const carousel = document.getElementById("carousel");
    const slides = document.querySelectorAll("#carousel > div");

    if (slides.length === 0) {
        carousel.style.display = "none";
        return;
    }

    let currentIndex = 0;
    let slidesPerView = getSlidesPerView();
    let autoPlayInterval;
    let isDragging = false;
    let startPosX = 0;
    let currentTranslate = 0;
    let prevTranslate = 0;

    carousel.style.cursor = "grab";
    carousel.style.userSelect = "none";

    function getSlidesPerView() {
        // Sincronizamos con los anchos CSS de tu plantilla
        if (window.innerWidth >= 1024) return Math.min(3.5, slides.length); // lg: w-[calc(100%/3.5)]
        if (window.innerWidth >= 640) return Math.min(2, slides.length);   // sm: w-[50%] = 2 cards
        return 1; // w-full = 1 card
    }

    function getMaxIndex() {
        // Mantenemos el cálculo original que permitía ver parcialmente la última card
        return Math.max(0, Math.ceil(slides.length - slidesPerView));
    }

    function updatePosition() {
        carousel.style.transform = `translateX(${currentTranslate}%)`;
    }

    carousel.addEventListener("mousedown", dragStart);
    carousel.addEventListener("touchstart", dragStart);
    carousel.addEventListener("mousemove", drag);
    carousel.addEventListener("touchmove", drag);
    carousel.addEventListener("mouseup", dragEnd);
    carousel.addEventListener("mouseleave", dragEnd);
    carousel.addEventListener("touchend", dragEnd);

    function dragStart(e) {
        e.preventDefault();
        stopAutoPlay();
        isDragging = true;
        startPosX = e.type.includes("touch") ? e.touches[0].clientX : e.clientX;
        carousel.style.cursor = "grabbing";
        carousel.style.transition = "none";
    }

    function drag(e) {
        if (!isDragging) return;
        const currentPosition = e.type.includes("touch")
            ? e.touches[0].clientX
            : e.clientX;
        const diff = currentPosition - startPosX;
        currentTranslate = prevTranslate + (diff / carousel.offsetWidth) * 100;
        updatePosition();
    }

    function dragEnd() {
        if (!isDragging) return;
        isDragging = false;
        carousel.style.cursor = "grab";
        carousel.style.transition = "transform 0.5s ease-out";

        const movedBy = currentTranslate - prevTranslate;
        const threshold = 15;

        if (movedBy < -threshold) {
            goToNext();
        } else if (movedBy > threshold) {
            goToPrev();
        } else {
            resetPosition();
        }

        startAutoPlay();
    }

    function goToNext() {
        const maxIndex = getMaxIndex();
        
        if (currentIndex < maxIndex) {
            currentIndex++;
            updateCarousel();
        } else {
            // Cuando llegamos al final, pausamos y luego reiniciamos
            stopAutoPlay();
            setTimeout(() => {
                currentIndex = 0;
                carousel.style.transition = "transform 0.8s ease-in-out";
                updateCarousel();
                // Reiniciamos el autoplay después de un breve delay
                setTimeout(() => {
                    startAutoPlay();
                }, 500);
            }, 2000); // Pausa de 2 segundos en la última vista
        }
    }

    function goToPrev() {
        const maxIndex = getMaxIndex();
        if (maxIndex > 0) {
            currentIndex = currentIndex <= 0 ? maxIndex : currentIndex - 1;
            updateCarousel();
        }
    }

    function resetPosition() {
        currentTranslate = prevTranslate;
        updatePosition();
    }

    function updateCarousel() {
        slidesPerView = getSlidesPerView();
        const maxIndex = getMaxIndex();
        currentIndex = Math.min(currentIndex, maxIndex);
        
        // Calculamos la posición para mostrar las cards correctamente
        // incluyendo las fracciones (como en 2.5 cards)
        prevTranslate = -(100 / slidesPerView) * currentIndex;
        currentTranslate = prevTranslate;
        updatePosition();
    }

    function startAutoPlay() {
        stopAutoPlay();
        if (getMaxIndex() > 0) {
            autoPlayInterval = setInterval(goToNext, 3000);
        }
    }

    function stopAutoPlay() {
        clearInterval(autoPlayInterval);
    }

    window.addEventListener("resize", function () {
        updateCarousel();
        startAutoPlay();
    });

    updateCarousel();
    startAutoPlay();
});