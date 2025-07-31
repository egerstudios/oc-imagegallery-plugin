<?php
// plugins/egerstudios/imagegallery/models/Gallery.php

namespace EgerStudios\ImageGallery\Models;

use Model;

class Gallery extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $table = 'egerstudios_imagegallery_galleries';

    protected $fillable = [
        'name', 
        'slug', 
        'description', 
        'layout', 
        'images',
        'is_active',
        // Carousel settings
        'carousel_height',
        'auto_play',
        'show_dots',
        'show_arrows',
        'autoplay_speed',
        'pause_on_hover',
        // Masonry settings
        'masonry_columns',
        'images_per_page',
        'load_more_text',
        'show_image_titles',
        'enable_lightbox',
        'image_hover_effect'
    ];

    protected $jsonable = ['images'];

    public $rules = [
        'name' => 'required|max:255',
        'slug' => 'required|unique:egerstudios_imagegallery_galleries|max:255',
        'layout' => 'required|in:carousel,masonry',
        'carousel_height' => 'integer|min:200|max:1000',
        'autoplay_speed' => 'integer|min:1000|max:10000',
        'masonry_columns' => 'integer|min:1|max:6',
        'images_per_page' => 'integer|min:0|max:50'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'auto_play' => 'boolean',
        'show_dots' => 'boolean',
        'show_arrows' => 'boolean',
        'pause_on_hover' => 'boolean',
        'show_image_titles' => 'boolean',
        'enable_lightbox' => 'boolean',
        'images' => 'array',
        'carousel_height' => 'integer',
        'autoplay_speed' => 'integer',
        'masonry_columns' => 'integer',
        'images_per_page' => 'integer'
    ];

    public function beforeValidate()
    {
        if (empty($this->slug)) {
            $this->slug = \Str::slug($this->name);
        }
    }

    public function getLayoutOptions()
    {
        return [
            'carousel' => 'Carousel (Horizontal Slideshow)',
            'masonry' => 'Masonry Grid (Pinterest-style)'
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Helper methods for accessing settings with defaults
    public function getCarouselHeight()
    {
        return $this->carousel_height ?: 400;
    }

    public function getAutoplaySpeed()
    {
        return $this->autoplay_speed ?: 4000;
    }

    public function getMasonryColumns()
    {
        return $this->masonry_columns ?: 3;
    }

    public function getImagesPerPage()
    {
        return $this->images_per_page ?: 9;
    }

    public function getLoadMoreText()
    {
        return $this->load_more_text ?: 'Se flere bilder →';
    }

    public function getImageHoverEffect()
    {
        return $this->image_hover_effect ?: 'zoom';
    }

    // Get visible images for pagination
    public function getVisibleImages()
    {
        $images = $this->images ?: [];
        
        if ($this->layout === 'masonry' && $this->getImagesPerPage() > 0) {
            return array_slice($images, 0, $this->getImagesPerPage());
        }
        
        return $images;
    }

    // Get hidden images for load more functionality
    public function getHiddenImages()
    {
        $images = $this->images ?: [];
        
        if ($this->layout === 'masonry' && $this->getImagesPerPage() > 0 && count($images) > $this->getImagesPerPage()) {
            return array_slice($images, $this->getImagesPerPage());
        }
        
        return [];
    }

    public function hasMoreImages()
    {
        return count($this->getHiddenImages()) > 0;
    }
}