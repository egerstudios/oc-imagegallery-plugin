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
        'settings', 
        'images',
        'is_active'
    ];

    protected $jsonable = ['settings', 'images'];

    public $rules = [
        'name' => 'required|max:255',
        'slug' => 'required|unique:egerstudios_imagegallery_galleries|max:255',
        'layout' => 'required|in:carousel,masonry'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'settings' => 'array',
        'images' => 'array'
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
            'carousel' => 'Carousel',
            'masonry' => 'Masonry Grid'
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}