class CategorySlider {
    constructor(options = {}) {
        this.track = document.getElementById('sliderTrack');
        this.slides = Array.from(document.querySelectorAll('.slider-slide'));
        this.prevBtn = document.getElementById('prevBtn');
        this.nextBtn = document.getElementById('nextBtn');
        this.dotsContainer = document.getElementById('sliderDots');
        this.progressBar = document.getElementById('progressBar');
        
        // Configuration
        this.currentIndex = 0;
        this.autoplay = options.autoplay !== undefined ? options.autoplay : false; // Changed to false
        this.autoplaySpeed = options.autoplaySpeed || 3000;
        this.slidesToShow = this.getSlidesToShow();
        this.autoplayTimer = null;
        this.progressTimer = null;
        
        this.init();
    }

    getSlidesToShow() {
        const width = window.innerWidth;
        if (width < 576) return 1;
        if (width < 992) return 2;
        return 4;
    }

    init() {
        this.createDots();
        this.updateSlider();
        this.attachEvents();
        
        if (this.autoplay) {
            this.startAutoplay();
        }
    }

    createDots() {
        this.dotsContainer.innerHTML = '';
        const totalDots = Math.ceil(this.slides.length - this.slidesToShow + 1);
        
        for (let i = 0; i < totalDots; i++) {
            const dot = document.createElement('button');
            dot.classList.add('slider-dot');
            if (i === 0) dot.classList.add('active');
            dot.addEventListener('click', () => this.goToSlide(i));
            this.dotsContainer.appendChild(dot);
        }
    }

    updateSlider() {
        const slideWidth = 100 / this.slidesToShow;
        const offset = -this.currentIndex * slideWidth;
        this.track.style.transform = `translateX(${offset}%)`;
        
        this.updateDots();
        this.updateArrows();
    }

    updateDots() {
        const dots = this.dotsContainer.querySelectorAll('.slider-dot');
        dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === this.currentIndex);
        });
    }

    updateArrows() {
        this.prevBtn.classList.toggle('disabled', this.currentIndex === 0);
        this.nextBtn.classList.toggle('disabled', 
            this.currentIndex >= this.slides.length - this.slidesToShow
        );
    }

    goToSlide(index) {
        const maxIndex = this.slides.length - this.slidesToShow;
        this.currentIndex = Math.max(0, Math.min(index, maxIndex));
        this.updateSlider();
    }

    nextSlide() {
        if (this.currentIndex < this.slides.length - this.slidesToShow) {
            this.currentIndex++;
        } else {
            this.currentIndex = 0;
        }
        this.updateSlider();
    }

    prevSlide() {
        if (this.currentIndex > 0) {
            this.currentIndex--;
        } else {
            this.currentIndex = this.slides.length - this.slidesToShow;
        }
        this.updateSlider();
    }

    attachEvents() {
        this.nextBtn.addEventListener('click', () => {
            this.nextSlide();
        });

        this.prevBtn.addEventListener('click', () => {
            this.prevSlide();
        });

        // Touch/Swipe support
        let touchStartX = 0;
        let touchEndX = 0;

        this.track.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        });

        this.track.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            if (touchEndX < touchStartX - 50) {
                this.nextSlide();
            }
            if (touchEndX > touchStartX + 50) {
                this.prevSlide();
            }
        });

        // Responsive resize
        window.addEventListener('resize', () => {
            const newSlidesToShow = this.getSlidesToShow();
            if (newSlidesToShow !== this.slidesToShow) {
                this.slidesToShow = newSlidesToShow;
                this.currentIndex = 0;
                this.createDots();
                this.updateSlider();
            }
        });
    }
}

// Initialize slider with autoplay OFF
document.addEventListener('DOMContentLoaded', () => {
    const slider = new CategorySlider({
        autoplay: false  // Autoplay is turned off
    });
});