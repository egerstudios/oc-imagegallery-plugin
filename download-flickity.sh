#!/bin/bash

# Download Flickity files for local use
# Run this script from the plugin root directory

echo "Downloading Flickity files..."

# Create directories if they don't exist
mkdir -p assets/css
mkdir -p assets/js

# Download Flickity CSS
echo "Downloading Flickity CSS..."
curl -o assets/css/flickity.min.css https://unpkg.com/flickity@2/dist/flickity.min.css

# Download Flickity JS
echo "Downloading Flickity JS..."
curl -o assets/js/flickity.pkgd.min.js https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js

echo "Flickity files downloaded successfully!"
echo "You can now set 'use_cdn' to false in the component settings to use local files." 