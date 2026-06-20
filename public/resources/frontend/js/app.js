
    // ========== HOMEPAGE LIGHTBOX ==========
    const lightbox = document.getElementById('lightbox');
    const lightboxImg = document.getElementById('lightboxImg');
    const lightboxCaption = document.getElementById('lightboxCaption');
    const lightboxClose = document.getElementById('lightboxClose');
    const lightboxPrev = document.getElementById('lightboxPrev');
    const lightboxNext = document.getElementById('lightboxNext');
    const galleryCards = document.querySelectorAll('.projects-section .gallery-card');
    let currentIndex = 0;

    if (galleryCards.length > 0) {
        function openLightbox(index) {
            currentIndex = index;
            updateLightbox();
            lightbox.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            lightbox.classList.remove('active');
            document.body.style.overflow = '';
        }

        function updateLightbox() {
            const card = galleryCards[currentIndex];
            const imgSrc = card.getAttribute('data-img');
            const title = card.querySelector('h5').textContent;
            
            // Safely get location text without the icon text
            const locationEl = card.querySelector('.gallery-location');
            const locationText = locationEl ? locationEl.textContent.trim() : '';
            
            lightboxImg.src = imgSrc;
            lightboxCaption.textContent = title + (locationText ? ' — ' + locationText : '');
        }

        function nextSlide() {
            currentIndex = (currentIndex + 1) % galleryCards.length;
            updateLightbox();
        }

        function prevSlide() {
            currentIndex = (currentIndex - 1 + galleryCards.length) % galleryCards.length;
            updateLightbox();
        }

        galleryCards.forEach((card, index) => {
            card.addEventListener('click', () => openLightbox(index));
        });

        lightboxClose.addEventListener('click', closeLightbox);
        lightboxNext.addEventListener('click', nextSlide);
        lightboxPrev.addEventListener('click', prevSlide);

        lightbox.addEventListener('click', (e) => {
            if (e.target === lightbox) closeLightbox();
        });

        document.addEventListener('keydown', (e) => {
            if (!lightbox.classList.contains('active')) return;
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowRight') nextSlide();
            if (e.key === 'ArrowLeft') prevSlide();
        });
    }