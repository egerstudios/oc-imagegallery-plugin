// plugins/egerstudios/imagegallery/assets/js/gallery.js

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Flickity carousels
    initFlickityCarousels();
    
    // Initialize lightbox functionality
    initLightbox();
    
    // Initialize masonry load more functionality
    initLoadMore();
});

/**
 * Initialize Flickity carousels
 */
function initFlickityCarousels() {
    // Check if Flickity is available
    if (typeof Flickity === 'undefined') {
        console.warn('Flickity not loaded. Carousels will not function properly.');
        return;
    }
    
    document.querySelectorAll('.flickity-carousel').forEach(carousel => {
        // Check if Flickity is already initialized
        if (carousel.classList.contains('flickity-enabled')) {
            return;
        }
        
        try {
            const flkty = new Flickity(carousel, {
                cellAlign: 'left',
                contain: true,
                wrapAround: true,
                adaptiveHeight: true,
                lazyLoad: 1,
                // Get options from data attribute
                autoPlay: carousel.dataset.autoPlay === 'true' ? 4000 : false,
                prevNextButtons: carousel.dataset.prevNextButtons !== 'false',
                pageDots: carousel.dataset.pageDots !== 'false'
            });
            
            // Add custom event listeners
            flkty.on('change', function(index) {
                // Handle slide change if needed
                console.log('Slide changed to:', index);
            });
            
            flkty.on('settle', function() {
                // Handle settle event
                console.log('Carousel settled');
            });
            
        } catch (error) {
            console.error('Error initializing Flickity carousel:', error);
        }
    });
}

/**
 * Initialize lightbox functionality for gallery images
 */
function initLightbox() {
    document.querySelectorAll('[data-bs-toggle="modal"]').forEach(trigger => {
        trigger.addEventListener('click', function(e) {
            e.preventDefault();
            
            const imageSrc = this.dataset.imageSrc;
            const imageTitle = this.dataset.imageTitle || '';
            const modalId = this.dataset.bsTarget;
            
            const modal = document.querySelector(modalId);
            if (modal) {
                const modalImg = modal.querySelector('.modal-body img');
                const modalTitle = modal.querySelector('.modal-title');
                
                if (modalImg) {
                    modalImg.src = imageSrc;
                    modalImg.alt = imageTitle;
                }
                if (modalTitle) {
                    modalTitle.textContent = imageTitle;
                }
                
                // Show the modal using Bootstrap
                const bootstrapModal = new bootstrap.Modal(modal);
                bootstrapModal.show();
            }
        });
    });
}

/**
 * Initialize load more functionality for masonry galleries
 */
function initLoadMore() {
    document.querySelectorAll('.load-more-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            // Prevent default form submission
            e.preventDefault();
            
            const button = this;
            const originalText = button.textContent;
            
            // Show loading state
            button.textContent = 'Loading...';
            button.disabled = true;
            
            // October CMS AJAX request is handled by data-request attribute
            // We just need to handle the response and hide the button after loading
            setTimeout(() => {
                const galleryId = button.dataset.galleryId || button.closest('.image-gallery').id;
                const hiddenImages = document.querySelector(`#gallery-${galleryId} .hidden-images`);
                
                if (hiddenImages && hiddenImages.innerHTML.trim()) {
                    // Move hidden images to the main gallery
                    const galleryRow = button.closest('.masonry-gallery').querySelector('.row');
                    if (galleryRow) {
                        galleryRow.appendChild(hiddenImages);
                        hiddenImages.classList.remove('hidden-images');
                    }
                    
                    // Hide the load more button
                    button.style.display = 'none';
                } else {
                    // Restore button state if no more images
                    button.textContent = originalText;
                    button.disabled = false;
                }
            }, 1000);
        });
    });
}

/**
 * Reinitialize Flickity after dynamic content is loaded
 */
function reinitFlickity() {
    // Destroy existing Flickity instances
    document.querySelectorAll('.flickity-enabled').forEach(carousel => {
        const flkty = Flickity.data(carousel);
        if (flkty) {
            flkty.destroy();
        }
    });
    
    // Reinitialize
    initFlickityCarousels();
}

/**
 * Utility function to refresh gallery after AJAX updates
 */
function refreshGallery(galleryId) {
    const gallery = document.querySelector(`#${galleryId}`);
    if (gallery) {
        // Reinitialize lightbox for new images
        initLightbox();
        
        // Reinitialize Flickity if it's a carousel
        if (gallery.dataset.layout === 'carousel') {
            reinitFlickity();
        }
    }
}