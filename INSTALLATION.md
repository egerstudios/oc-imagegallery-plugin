# Installation Guide

## Prerequisites

- October CMS (latest version recommended)
- PHP 7.4 or higher
- Web server with mod_rewrite enabled

## Step 1: Install the Plugin

### Via Composer (Recommended)
```bash
composer require egerstudios/imagegallery
```

### Manual Installation
1. Download the plugin files
2. Extract to `plugins/egerstudios/imagegallery/`
3. Run `php artisan plugin:install egerstudios.imagegallery`

## Step 2: Include Flickity

The plugin requires Flickity for carousel functionality. Add these lines to your theme's layout file or in the `<head>` section:

### Option 1: CDN (Recommended for development)
```html
<!-- Add to your layout file (e.g., themes/your-theme/layouts/default.htm) -->
<link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
<script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
```

### Option 2: Local Files (Recommended for production)
1. Download Flickity from https://flickity.metafizzy.co/
2. Place files in your theme's assets directory:
   ```
   themes/your-theme/assets/
   ├── css/
   │   └── flickity.min.css
   └── js/
       └── flickity.pkgd.min.js
   ```
3. Include in your layout:
   ```html
   <link rel="stylesheet" href="{{ 'assets/css/flickity.min.css'|theme }}">
   <script src="{{ 'assets/js/flickity.pkgd.min.js'|theme }}"></script>
   ```

### Option 3: NPM/Webpack (Advanced)
```bash
npm install flickity
```

Then import in your build process:
```javascript
import Flickity from 'flickity';
import 'flickity/css';
```

## Step 3: Run Database Migrations

```bash
php artisan october:up
```

## Step 4: Configure Backend Access

1. Go to **Settings > Users > User Roles**
2. Create or edit a role
3. Add the permission: `egerstudios.imagegallery.access_galleries`

## Step 5: Test the Installation

1. Go to **Image Galleries** in the backend
2. Create a test gallery
3. Add some images
4. Use the component on a page to test

## Troubleshooting

### Flickity Not Loading
- Check browser console for JavaScript errors
- Verify Flickity files are accessible
- Ensure jQuery is loaded before Flickity (if using jQuery version)

### Carousel Not Working
- Verify Flickity is loaded: `console.log(typeof Flickity)`
- Check for JavaScript errors in browser console
- Ensure images are accessible

### Database Errors
- Run `php artisan october:up` to ensure migrations are applied
- Check database permissions
- Verify table exists: `egerstudios_imagegallery_galleries`

### Permission Issues
- Ensure user has proper backend permissions
- Check user role settings
- Verify plugin is properly installed

## Support

For issues and questions:
- Check the plugin documentation
- Review browser console for errors
- Ensure all dependencies are properly loaded 