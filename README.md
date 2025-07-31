# Image Gallery Plugin for October CMS

A flexible image gallery component with carousel and masonry layouts, featuring Flickity for smooth carousel functionality.

## Features

- **Two Layout Types:**
  - **Carousel**: Horizontal slideshow using Flickity
  - **Masonry**: Pinterest-style grid layout
  
- **Two Source Types:**
  - **Manual**: Simple image uploads through component settings
  - **Backend Gallery**: Advanced gallery management through backend

- **Carousel Features (Flickity-powered):**
  - Auto-play with customizable speed
  - Navigation arrows and dots
  - Touch/swipe support
  - Lazy loading
  - Responsive design
  - Caption support

- **Masonry Features:**
  - Configurable columns (2-5)
  - Load more functionality
  - Hover effects (zoom, fade, lift, none)
  - Lightbox modal for image viewing
  - Responsive grid

## Installation

1. Install the plugin via Composer or manual installation
2. The plugin automatically includes Flickity from CDN by default
3. For local files (recommended for production), download Flickity:

### Option 1: Automatic Download (Recommended)
```bash
# Run from plugin directory
cd plugins/egerstudios/imagegallery
chmod +x download-flickity.sh
./download-flickity.sh
```

### Option 2: Manual Download
1. Download Flickity from https://flickity.metafizzy.co/
2. Place files in `plugins/egerstudios/imagegallery/assets/`:
   ```
   assets/
   ├── css/
   │   └── flickity.min.css
   └── js/
       └── flickity.pkgd.min.js
   ```

### Option 3: Keep Using CDN
The plugin uses CDN by default. No additional setup required.

## Usage

### As a Component

Add the component to your page:

```twig
[imageGallery]
source_type = "manual"
layout = "carousel"
image1 = "path/to/image1.jpg"
title1 = "Image 1 Title"
image2 = "path/to/image2.jpg"
title2 = "Image 2 Title"
auto_play = true
show_arrows = true
show_dots = true
carousel_height = 400
```

### As a Snippet

Use the snippet in your content:

```twig
{% component 'imageGallery' %}
```

## Configuration Options

### Source Type
- `manual`: Use component settings for images
- `model`: Use backend gallery management

### Layout Options
- `carousel`: Horizontal slideshow
- `masonry`: Grid layout

### Carousel Options
- `carousel_height`: Height in pixels (default: 400)
- `auto_play`: Enable automatic slideshow (default: false)
- `show_arrows`: Show navigation arrows (default: true)
- `show_dots`: Show navigation dots (default: true)
- `show_captions`: Display image titles (default: true)

### Masonry Options
- `masonry_columns`: Number of columns (2-5, default: 3)
- `images_per_page`: Images to show initially (0 = all, default: 6)
- `load_more_text`: Button text (default: "Se flere bilder →")
- `enable_lightbox`: Enable modal lightbox (default: true)

### Advanced Options
- `use_cdn`: Load Flickity from CDN (default: true, set to false for local files)

## Backend Gallery Management

1. Go to **Image Galleries** in the backend
2. Create a new gallery
3. Configure layout settings
4. Upload images with titles and descriptions
5. Use the gallery slug in your component

## Customization

### CSS Customization
The plugin includes comprehensive CSS for styling. You can override styles in your theme:

```css
/* Custom carousel styling */
.flickity-carousel {
    /* Your custom styles */
}

/* Custom masonry styling */
.masonry-gallery .gallery-card {
    /* Your custom styles */
}
```

### JavaScript Customization
The plugin provides hooks for custom JavaScript:

```javascript
// Listen for carousel events
document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.querySelector('.flickity-carousel');
    if (carousel) {
        const flkty = Flickity.data(carousel);
        flkty.on('change', function(index) {
            // Your custom logic
        });
    }
});
```

## Browser Support

- Modern browsers with ES6 support
- Touch devices for swipe functionality
- Flickity handles fallbacks for older browsers

## Dependencies

- **Flickity**: For carousel functionality
- **Bootstrap**: For modal lightbox (optional)
- **October CMS**: Core framework

## License

This plugin is licensed under the MIT License.