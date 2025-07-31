<?php
// plugins/egerstudios/imagegallery/controllers/Galleries.php

namespace EgerStudios\ImageGallery\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

class Galleries extends Controller
{
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('EgerStudios.ImageGallery', 'imagegallery', 'galleries');
    }
}