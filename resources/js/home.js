/**
 * Banner slider - Auto slide terus menerus
 */
document.addEventListener("DOMContentLoaded", () => {
    const slider = document.querySelector("[data-banner-slider]");

    if (!slider) {
        return;
    }

    const slides = Array.from(slider.querySelectorAll("[data-banner-slide]"));
    const dots = Array.from(slider.querySelectorAll("[data-banner-dot]"));

    let currentIndex = 0;
    let autoPlayTimer = null;
    const AUTO_PLAY_DELAY = 5000; // 5 detik untuk auto-slide

    const setActiveSlide = (index) => {
        const prevIndex = currentIndex;

        // Baseline: semua slide diset ke off-screen kanan & tidak terlihat
        slides.forEach((slide) => {
            slide.classList.remove(
                "translate-x-0",
                "-translate-x-full",
                "translate-x-full",
                "visible",
                "invisible",
                "z-10",
                "z-0",
                "opacity-100",
                "opacity-0"
            );
            slide.classList.add(
                "translate-x-full",
                "invisible",
                "z-0",
                "opacity-0"
            );
        });

        // Slide sebelumnya: animasi keluar ke kiri
        if (prevIndex !== index && slides[prevIndex]) {
            slides[prevIndex].classList.remove(
                "translate-x-full",
                "invisible",
                "z-0",
                "opacity-0"
            );
            slides[prevIndex].classList.add(
                "-translate-x-full",
                "visible",
                "z-0",
                "opacity-100"
            );
        }

        // Slide aktif: posisi tengah dan terlihat
        if (slides[index]) {
            slides[index].classList.remove(
                "translate-x-full",
                "invisible",
                "z-0",
                "opacity-0"
            );
            slides[index].classList.add(
                "translate-x-0",
                "visible",
                "z-10",
                "opacity-100"
            );
        }

        // Update indikator (dots) dengan utilitas Tailwind
        dots.forEach((dot, idx) => {
            const isActive = idx === index;
            dot.classList.toggle("bg-white", isActive);
            dot.classList.toggle("w-10", isActive);
            dot.classList.toggle("bg-white/50", !isActive);
            dot.classList.toggle("w-8", !isActive);
        });

        currentIndex = index;
    };

    const nextSlide = () => {
        const nextIndex = (currentIndex + 1) % slides.length;
        setActiveSlide(nextIndex);
    };

    const startAutoPlay = () => {
        stopAutoPlay();
        if (!document.hidden) {
            autoPlayTimer = setInterval(nextSlide, AUTO_PLAY_DELAY);
        }
    };

    const stopAutoPlay = () => {
        if (autoPlayTimer) {
            clearInterval(autoPlayTimer);
            autoPlayTimer = null;
        }
    };

    // Cleanup saat halaman tidak aktif
    document.addEventListener("visibilitychange", function () {
        if (document.hidden) {
            stopAutoPlay();
        } else {
            startAutoPlay();
        }
    });

    window.addEventListener("pagehide", function () {
        stopAutoPlay();
    });

    // Event listeners untuk dots (opsional, untuk manual click)
    dots.forEach((dot) => {
        dot.addEventListener("click", (e) => {
            e.stopPropagation();
            const targetIndex = parseInt(dot.dataset.slideTarget ?? "0", 10);
            setActiveSlide(targetIndex);
            // Reset timer setelah manual click
            stopAutoPlay();
            startAutoPlay();
        });
    });

    // Touch events untuk mobile (swipe)
    let touchStartX = 0;
    let touchEndX = 0;

    slider.addEventListener("touchstart", (e) => {
        touchStartX = e.changedTouches[0].screenX;
    });

    slider.addEventListener("touchend", (e) => {
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
                const prevIndex =
                    (currentIndex - 1 + slides.length) % slides.length;
                setActiveSlide(prevIndex);
            }
            // Reset timer setelah swipe
            stopAutoPlay();
            startAutoPlay();
        }
    };

    // Start auto-play - akan terus berjalan
    setActiveSlide(0);
    startAutoPlay();
});
