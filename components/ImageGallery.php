<?php
// plugins/egerstudios/imagegallery/components/ImageGallery.php

namespace EgerStudios\ImageGallery\Components;

use Cms\Classes\ComponentBase;
use EgerStudios\ImageGallery\Models\Gallery;

class ImageGallery extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Image Gallery',
            'description' => 'Flexible image gallery with carousel and masonry layouts',
            'snippetCode' => 'imageGallery',
            'snippetName' => 'Image Gallery',
            'snippetDescription' => 'Display images in carousel or masonry layout'
        ];
    }

    public function defineProperties()
    {
        return [
            // Option to use either model-based or manual images
            'source_type' => [
                'title' => 'Source Type',
                'description' => 'Choose image source',
                'type' => 'dropdown',
                'default' => 'manual',
                'options' => [
                    'manual' => 'Manual Images (Simple)',
                    'model' => 'Backend Gallery (Advanced)'
                ]
            ],
            
            // Model-based gallery selection
            'gallery_slug' => [
                'title' => 'Gallery',
                'description' => 'Select gallery to display',
                'type' => 'dropdown',
                'options' => $this->getGalleryOptions(),
                'group' => 'Backend Gallery',
                'dependsOn' => 'source_type'
            ],
            
            // Manual image fields
            'image1' => [
                'title' => 'Image 1',
                'type' => 'string',
                'description' => 'Path to first image',
                'group' => 'Manual Images'
            ],
            'title1' => [
                'title' => 'Title 1',
                'type' => 'string',
                'group' => 'Manual Images'
            ],
            'image2' => [
                'title' => 'Image 2',
                'type' => 'string',
                'description' => 'Path to second image',
                'group' => 'Manual Images'
            ],
            'title2' => [
                'title' => 'Title 2',
                'type' => 'string',
                'group' => 'Manual Images'
            ],
            'image3' => [
                'title' => 'Image 3',
                'type' => 'string',
                'group' => 'Manual Images'
            ],
            'title3' => [
                'title' => 'Title 3',
                'type' => 'string',
                'group' => 'Manual Images'
            ],
            'image4' => [
                'title' => 'Image 4',
                'type' => 'string',
                'group' => 'Manual Images'
            ],
            'title4' => [
                'title' => 'Title 4',
                'type' => 'string',
                'group' => 'Manual Images'
            ],
            'image5' => [
                'title' => 'Image 5',
                'type' => 'string',
                'group' => 'Manual Images'
            ],
            'title5' => [
                'title' => 'Title 5',
                'type' => 'string',
                'group' => 'Manual Images'
            ],
            
            // Layout options
            'layout' => [
                'title' => 'Layout Type',
                'description' => 'Choose how to display the gallery',
                'type' => 'dropdown',
                'default' => 'carousel',
                'options' => [
                    'carousel' => 'Carousel (horizontal scrolling)',
                    'masonry' => 'Masonry (grid layout)'
                ],
                'group' => 'Layout Settings'
            ],
            
            // Carousel options
            'carousel_height' => [
                'title' => 'Carousel Height (px)',
                'description' => 'Height in pixels for carousel layout',
                'type' => 'string',
                'default' => '400',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'Height must be a number',
                'group' => 'Carousel Options'
            ],
            'auto_play' => [
                'title' => 'Auto Play',
                'description' => 'Enable automatic slideshow',
                'type' => 'checkbox',
                'default' => false,
                'group' => 'Carousel Options'
            ],
            'show_dots' => [
                'title' => 'Show Navigation Dots',
                'description' => 'Show dots for navigation',
                'type' => 'checkbox',
                'default' => true,
                'group' => 'Carousel Options'
            ],
            'show_arrows' => [
                'title' => 'Show Navigation Arrows',
                'description' => 'Show previous/next arrows',
                'type' => 'checkbox',
                'default' => true,
                'group' => 'Carousel Options'
            ],
            'show_captions' => [
                'title' => 'Show Captions',
                'description' => 'Display image titles as captions',
                'type' => 'checkbox',
                'default' => true,
                'group' => 'Carousel Options'
            ],
            
            // Masonry options
            'masonry_columns' => [
                'title' => 'Masonry Columns',
                'description' => 'Number of columns in masonry layout',
                'type' => 'dropdown',
                'default' => '3',
                'options' => [
                    '2' => '2 Columns',
                    '3' => '3 Columns',
                    '4' => '4 Columns',
                    '5' => '5 Columns'
                ],
                'group' => 'Masonry Options'
            ],
            'images_per_page' => [
                'title' => 'Images Per Page',
                'description' => 'Number of images to show initially (0 = show all)',
                'type' => 'string',
                'default' => '6',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'Must be a number',
                'group' => 'Masonry Options'
            ],
            'load_more_text' => [
                'title' => 'Load More Button Text',
                'description' => 'Text for the load more button',
                'type' => 'string',
                'default' => 'Se flere bilder →',
                'group' => 'Masonry Options'
            ],
            'enable_lightbox' => [
                'title' => 'Enable Lightbox',
                'description' => 'Allow clicking images to view in lightbox',
                'type' => 'checkbox',
                'default' => true,
                'group' => 'General Options'
            ],
            'use_cdn' => [
                'title' => 'Use CDN for Flickity',
                'description' => 'Load Flickity from CDN (uncheck to use local files)',
                'type' => 'checkbox',
                'default' => true,
                'group' => 'Advanced Options'
            ]
        ];
    }

    public function getGalleryOptions()
    {
        try {
            return Gallery::active()->pluck('name', 'slug')->toArray();
        } catch (\Exception $e) {
            // Return empty array if Gallery model doesn't exist yet
            return [];
        }
    }

    public function onRun()
    {
        // Add Flickity CSS and JS for carousel functionality
        $useCdn = $this->property('use_cdn', true);
        
        if ($useCdn) {
            // Load from CDN with fallback
            $this->addCss('https://cdnjs.cloudflare.com/ajax/libs/flickity/2.3.0/flickity.min.css');
            $this->addJs('https://cdnjs.cloudflare.com/ajax/libs/flickity/2.3.0/flickity.pkgd.min.js');
        } else {
            // Load local files from plugin assets
            $this->addCss('~/plugins/egerstudios/imagegallery/assets/css/flickity.min.css');
            $this->addJs('~/plugins/egerstudios/imagegallery/assets/js/flickity.pkgd.min.js');
        }
        
        // Add plugin's custom CSS and JS
        $this->addCss('assets/css/gallery.css');
        $this->addJs('assets/js/gallery.js');
        
        $this->page['gallery'] = $this->getGalleryData();
        $this->page['images'] = $this->getImages();
        $this->page['visibleImages'] = $this->getVisibleImages();
        $this->page['hasMoreImages'] = $this->hasMoreImages();
    }

    public function getGalleryData()
    {
        $sourceType = $this->property('source_type', 'manual');
        
        if ($sourceType === 'model') {
            // Use backend gallery
            $slug = $this->property('gallery_slug');
            try {
                return Gallery::where('slug', $slug)->where('is_active', true)->first();
            } catch (\Exception $e) {
                // Fallback to manual if Gallery model doesn't exist
                return $this->createManualGalleryObject();
            }
        } else {
            // Create gallery object from manual properties
            return $this->createManualGalleryObject();
        }
    }

    protected function createManualGalleryObject()
    {
        $images = $this->getImages();
        
        return (object)[
            'id' => 'manual-' . uniqid(),
            'name' => 'Manual Gallery',
            'layout' => $this->property('layout', 'carousel'),
            'images' => $images,
            'carousel_height' => (int)$this->property('carousel_height', 400),
            'auto_play' => $this->property('auto_play', false),
            'show_dots' => $this->property('show_dots', true),
            'show_arrows' => $this->property('show_arrows', true),
            'show_captions' => $this->property('show_captions', true),
            'masonry_columns' => (int)$this->property('masonry_columns', 3),
            'images_per_page' => (int)$this->property('images_per_page', 6),
            'enable_lightbox' => $this->property('enable_lightbox', true),
            'load_more_text' => $this->property('load_more_text', 'Se flere bilder →')
        ];
    }

    public function getImages()
    {
        $images = [];
        for ($i = 1; $i <= 5; $i++) {
            $imagePath = $this->property("image{$i}");
            if ($imagePath) {
                $images[] = [
                    'image' => $imagePath, // Store as string path, not object
                    'title' => $this->property("title{$i}"),
                    'alt_text' => $this->property("title{$i}") ?: "Image {$i}"
                ];
            }
        }
        return $images;
    }

    public function getVisibleImages()
    {
        $images = $this->getImages();
        $imagesPerPage = (int) $this->property('images_per_page', 0);
        
        if ($imagesPerPage > 0 && $this->property('layout') === 'masonry') {
            return array_slice($images, 0, $imagesPerPage);
        }
        
        return $images;
    }

    public function getHiddenImages()
    {
        $images = $this->getImages();
        $imagesPerPage = (int) $this->property('images_per_page', 0);
        
        if ($imagesPerPage > 0 && $this->property('layout') === 'masonry' && count($images) > $imagesPerPage) {
            return array_slice($images, $imagesPerPage);
        }
        
        return [];
    }

    public function hasMoreImages()
    {
        return count($this->getHiddenImages()) > 0;
    }

    public function onLoadMore()
    {
        $images = $this->getHiddenImages();
        
        return [
            '#gallery-' . $this->getGalleryId() . ' .hidden-images' => $this->renderPartial('@masonry_images', [
                'images' => $images,
                'show_captions' => $this->property('show_captions', true)
            ])
        ];
    }

    /**
     * Get a unique identifier for the gallery
     */
    public function getGalleryId()
    {
        $sourceType = $this->property('source_type', 'manual');
        
        if ($sourceType === 'model') {
            $gallery = $this->getGalleryData();
            if ($gallery && is_object($gallery) && isset($gallery->slug)) {
                return $gallery->slug;
            }
        }
        
        // Fallback to component ID with prefix
        return 'gallery-' . $this->id;
    }

    /**
     * Get Flickity options for carousel
     */
    public function getFlickityOptions()
    {
        $sourceType = $this->property('source_type', 'manual');
        
        if ($sourceType === 'model') {
            $gallery = $this->getGalleryData();
            if ($gallery && is_object($gallery)) {
                return [
                    'autoPlay' => isset($gallery->auto_play) && $gallery->auto_play ? 'true' : 'false',
                    'prevNextButtons' => isset($gallery->show_arrows) && $gallery->show_arrows ? 'true' : 'false',
                    'pageDots' => isset($gallery->show_dots) && $gallery->show_dots ? 'true' : 'false'
                ];
            }
        }
        
        // Default options for manual galleries or fallback
        $options = [
            'autoPlay' => $this->property('auto_play', false) ? 'true' : 'false',
            'prevNextButtons' => $this->property('show_arrows', true) ? 'true' : 'false',
            'pageDots' => $this->property('show_dots', true) ? 'true' : 'false'
        ];
        
        // Debug logging
        \Log::info('Flickity Options: ' . json_encode($options));
        
        return $options;
    }
}