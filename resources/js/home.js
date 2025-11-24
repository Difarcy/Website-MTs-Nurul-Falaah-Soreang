/**
 * Banner slider - Auto slide terus menerus
 */
document.addEventListener('DOMContentLoaded', () => {
    const slider = document.querySelector('[data-banner-slider]');

    if (!slider) {
        return;
    }

    const slides = Array.from(slider.querySelectorAll('[data-banner-slide]'));
    const dots = Array.from(slider.querySelectorAll('[data-banner-dot]'));

    let currentIndex = 0;
    let autoPlayTimer = null;
    const AUTO_PLAY_DELAY = 5000; // 5 detik untuk auto-slide

    const setActiveSlide = (index) => {
        const prevIndex = currentIndex;
        
        // Remove all classes first
        slides.forEach((slide) => {
            slide.classList.remove('is-active', 'is-prev');
        });

        // Set previous slide (slide yang sedang aktif sebelumnya)
        if (prevIndex !== index && slides[prevIndex]) {
            slides[prevIndex].classList.add('is-prev');
        }

        // Set active slide
        if (slides[index]) {
            slides[index].classList.add('is-active');
        }

        // Update dots
        dots.forEach((dot, idx) => {
            dot.classList.toggle('is-active', idx === index);
        });

        currentIndex = index;
    };

    const nextSlide = () => {
        const nextIndex = (currentIndex + 1) % slides.length;
        setActiveSlide(nextIndex);
    };

    const startAutoPlay = () => {
        stopAutoPlay();
        autoPlayTimer = setInterval(nextSlide, AUTO_PLAY_DELAY);
    };

    const stopAutoPlay = () => {
        if (autoPlayTimer) {
            clearInterval(autoPlayTimer);
            autoPlayTimer = null;
        }
    };

    // Event listeners untuk dots (opsional, untuk manual click)
    dots.forEach((dot) => {
        dot.addEventListener('click', (e) => {
            e.stopPropagation();
            const targetIndex = parseInt(dot.dataset.slideTarget ?? '0', 10);
            setActiveSlide(targetIndex);
            // Reset timer setelah manual click
            stopAutoPlay();
            startAutoPlay();
        });
    });

    // Touch events untuk mobile (swipe)
    let touchStartX = 0;
    let touchEndX = 0;

    slider.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
    });

    slider.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    });

    const handleSwipe = () => {
        const swipeThreshold = 50;
        const diff = touchStartX - touchEndX;

        if (Math.abs(diff) > swipeThreshold) {
            if (diff > 0) {
                // Swipe left - next slide
                nextSlide();
            } else {
                // Swipe right - prev slide
                const prevIndex = (currentIndex - 1 + slides.length) % slides.length;
                setActiveSlide(prevIndex);
            }
            // Reset timer setelah swipe
            stopAutoPlay();
            startAutoPlay();
        }
    };

    // Start auto-play - akan terus berjalan
    startAutoPlay();
});

