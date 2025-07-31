<?php
// plugins/egerstudios/imagegallery/Plugin.php

namespace EgerStudios\ImageGallery;

use Backend;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name' => 'Image Gallery',
            'description' => 'Flexible image gallery component with carousel and masonry layouts',
            'author' => 'Eger Studios',
            'icon' => 'icon-picture-o',
            'homepage' => ''
        ];
    }

    public function registerComponents()
    {
        return [
            'EgerStudios\ImageGallery\Components\ImageGallery' => 'imageGallery'
        ];
    }

    public function registerPageSnippets()
    {
        return [
            'EgerStudios\ImageGallery\Components\ImageGallery' => 'imageGallery'
        ];
    }

    public function registerNavigation()
    {
        return [
            'imagegallery' => [
                'label' => 'Image Galleries',
                'url' => Backend::url('egerstudios/imagegallery/galleries'),
                'icon' => 'icon-picture-o',
                'permissions' => ['egerstudios.imagegallery.*'],
                'order' => 500,
                
                'sideMenu' => [
                    'galleries' => [
                        'label' => 'Galleries',
                        'icon' => 'icon-list',
                        'url' => Backend::url('egerstudios/imagegallery/galleries'),
                        'permissions' => ['egerstudios.imagegallery.access_galleries']
                    ]
                ]
            ]
        ];
    }

    public function registerPermissions()
    {
        return [
            'egerstudios.imagegallery.access_galleries' => [
                'tab' => 'Image Gallery',
                'label' => 'Access galleries'
            ]
        ];
    }

    public function boot()
    {
        // Register the snippet for RainLab Blog
        \Event::listen('cms.snippet.registry', function () {
            return [
                'imageGallery' => [
                    'name' => 'Image Gallery',
                    'description' => 'Display images in carousel or masonry layout',
                    'component' => 'EgerStudios\ImageGallery\Components\ImageGallery',
                    'group' => 'Media'
                ]
            ];
        });
    }
}