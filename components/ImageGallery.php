<?php namespace EgerStudios\ImageGallery\Components;

use Cms\Classes\ComponentBase;

/**
 * ImageGallery Component
 *
 * @link https://docs.octobercms.com/3.x/extend/cms-components.html
 */
class ImageGallery extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Image Gallery Component',
            'description' => 'No description provided yet...'
        ];
    }

    /**
     * @link https://docs.octobercms.com/3.x/element/inspector-types.html
     */
    public function defineProperties()
    {
        return [];
    }
}
